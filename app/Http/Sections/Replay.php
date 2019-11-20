<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use App\Models\{Country, Race, ReplayMap, ReplayType};
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use phpDocumentor\Reflection\Types\Object_;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Replay
 *
 * @property \App\Models\Replay $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Replay extends Section
{

    /**
     * @var bool
     */
    protected $checkAccess = false;
    /**
     * @var bool
     */
    protected $alias = false;

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fas fa-reply';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Список';
    }

    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \SleepingOwl\Admin\Exceptions\FilterOperatorException
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->with([
                'users',
                'maps',
                'comments',
                'types',
                'firstCountries',
                'secondCountries',
                'firstRaces',
                'secondRaces',
            ])
            ->setHtmlAttribute('class', 'table-info table-sm text-center')
            ->paginate(10);

        $display->setFilters(
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Replay::class)
        );
        $display->setApply(function ($query) {
            $query->orderByDesc('id');

        });


        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(70),

            $user = AdminColumn::relatedLink('users.name', 'Пользователь'),

            $title = AdminColumn::text('title', 'Название'),

            $map = AdminColumn::relatedLink('maps.name', 'Карта')
                ->setWidth(100),

            $country = AdminColumn::custom('Первая или вторая страна', function ($model) {
                return $model->firstCountries->name . '<br/><small>vs</small><br/>' . $model->secondCountries->name;
            })->setFilterCallback(function ($column, $query, $search) {
                if ($search) {
                    $query->whereHas('firstCountries', function ($q) use ($search) {
                        return $q->where('name', $search);
                    })->orWhereHas('secondCountries', function ($q) use ($search) {
                        return $q->where('name', $search);
                    });
                }
            })->setWidth(120),

            $race = AdminColumn::custom('Первая или вторая раса', function ($model) {
                return $model->firstRaces->title . '<br/><small>vs</small><br/>' . $model->secondRaces->title;
            })->setFilterCallback(function ($column, $query, $search) {
                if ($search) {
                    $query->whereHas('firstRaces', function ($q) use ($search) {
                        return $q->where('title', $search);
                    })->orWhereHas('secondRaces', function ($q) use ($search) {
                        return $q->where('title', $search);
                    });
                }
            })->setWidth(70),

            $type = AdminColumn::text('types.title', 'Тип')
                ->setWidth(70),

            $user_replay = AdminColumn::custom('Тип 2', function ($model) {
                return $model::$userReplaysType[$model->user_replay];
            })->setFilterCallback(function ($column, $query, $search) {
                if ($search) {
                    $query->where('user_replay', $this->model::$userReplaysType[$search]);
                }
            })->setWidth(100),

            $comments_count = AdminColumn::count('comments', 'Коментарии')
                ->setWidth(105),

            $user_rating = AdminColumn::text('user_rating', 'Оценка <br/><small>(пользователей)</small>')
                ->setWidth(125),

            $rating = AdminColumn::custom('Рейтинг', function ($model) {
                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';
                return $thumbsUp . $model->positive_count . '<br/>' . $equals . ($model->positive_count - $model->negative_count) . '<br/>' . $thumbsDown . $model->negative_count;
            })->setWidth(10),

            $approved = AdminColumnEditable::checkbox('approved')->setLabel('Подтвержден')
                ->setHtmlAttributes(['checked' => 'checked'])
                ->append(AdminColumn::filter('approved'))
                ->setWidth(75),

        ]);

        $display->setColumnFilters([
            $id = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('ID')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user = AdminColumnFilter::text()
                ->setOperator('contains')
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $title = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $map = AdminColumnFilter::select()
                ->setOptions((new ReplayMap())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $country = AdminColumnFilter::select()
                ->setOptions((new Country())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $race = AdminColumnFilter::select()
                ->setOptions((new Race())->pluck('title', 'title')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $type = AdminColumnFilter::select()
                ->setOptions((new ReplayType())->pluck('title', 'title')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $type2 = AdminColumnFilter::select()
                ->setOptions($this->model::$userReplaysType)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),

        ]);
        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show();
        $control->addButton($buttonShow);


        $display->getColumnFilters()->setPlacement('table.header');
        return $display;
    }

    /**
     * @param $id
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();

        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn([
                    $user_replay = AdminFormElement::text('title', 'Название')
                        ->setHtmlAttribute('placeholder', 'Название')
                        ->setHtmlAttribute('maxlength', '255')
                        ->setHtmlAttribute('minlength', '1')
                        ->setValidationRules(['required',
                                              'string',
                                              'between:1,255'])
                ], 3)
                ->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Тип')
                        ->setOptions((new ReplayType())->pluck('title', 'id')->toArray())
                        ->setDisplay('title')
                        ->setValidationRules(['required',
                                              'string',
                                              'exists:replay_types,id'])
                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Карта')
                        ->setOptions((new ReplayMap())->pluck('name', 'id')->toArray())
                        ->setDisplay('name')
                        ->setValidationRules(['required',
                                              'string',
                                              'exists:replay_maps,id'])

                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('user_replay', 'Профессиональный/Пользовательский')
                        ->setOptions(\App\Models\Replay::$userReplaysType)
                        ->setValidationRules(['required',
                                              'string',
                                              'in:0,1'])
                ], 3)
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('first_race', 'Перва раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string',
                                                  'exists:races,id']),
                        $first_country_id = AdminFormElement::select('first_country_id', 'Первая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string',
                                                  'exists:countries,id']),
                        $first_location = AdminFormElement::number('first_location', 'Первая локация')
                            ->setHtmlAttribute('placeholder', 'Первая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable',
                                                  'numeric',
                                                  'min:1',
                                                  'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'Первое имя')
                            ->setHtmlAttribute('placeholder', 'Первое имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable',
                                                  'string',
                                                  'between:1,255']),
                    ];
                })->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('second_race', 'Вторая раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string',
                                                  'exists:races,id']),
                        $first_country_id = AdminFormElement::select('second_country_id', 'Вторая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string',
                                                  'exists:countries,id']),
                        $second_location = AdminFormElement::number('second_location', 'Вторая локация')
                            ->setHtmlAttribute('placeholder', 'Вторая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable',
                                                  'numeric',
                                                  'min:1',
                                                  'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),
                        $first_name = AdminFormElement::text('second_name', 'Второе имя')
                            ->setHtmlAttribute('placeholder', 'Второе имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable',
                                                  'string',
                                                  'between:1,255']),
                    ];
                })
        );

        $form->addBody([
            $video_iframe = AdminFormElement::wysiwyg('video_iframe', 'Видео')
                ->setHtmlAttributes(['placeholder' => 'Видео'])
                ->setValidationRules(['nullable',
                                      'string',
                                      'max:5000']),

            $content = AdminFormElement::wysiwyg('content', 'Краткое описание')
                ->setHtmlAttributes(['placeholder' => 'Краткое описание'])
                ->setValidationRules(['required',
                                      'string',
                                      'between:1,2000']),

            AdminFormElement::columns()
                ->addColumn(function () use ($id) {
                    return [
                        $file = AdminFormElement::file('file', 'Файл')
                            ->setValidationRules(['required',
                                                  'file',
                                                  'max:5120'])
                            ->setUploadPath(function (UploadedFile $file) use ($id) {
                                $filePath = \App\Models\Replay::where('id', $id)->value('file');
                                return 'storage' . PathHelper::checkUploadsFileAndPath("/files/replays", $filePath);
                            }),
                    ];
                })
                ->addColumn(function () {
                    return [
                        $date = AdminFormElement::date('start_date', 'Дата начала')
                            ->setHtmlAttributes(['placeholder' => Carbon::now()->format('Y-m-d')])
                            ->setFormat('Y-m-d'),
                        $approved = AdminFormElement::checkbox('approved', 'Подтвержден'),
                    ];
                })
        ]);

        return $form;
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onCreate()
    {
        $form = AdminForm::panel();

        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn([
                    $user_replay = AdminFormElement::text('title', 'Название')
                        ->setHtmlAttribute('placeholder', 'Название')
                        ->setHtmlAttribute('maxlength', '255')
                        ->setHtmlAttribute('minlength', '1')
                        ->setValidationRules(['required',
                                              'string',
                                              'between:1,255'])
                ], 3)
                ->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Тип')
                        ->setOptions((new ReplayType())->pluck('title', 'id')->toArray())
                        ->setDisplay('title')
                        ->setValidationRules(['required',
                                              'string'])
                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Карта')
                        ->setOptions((new ReplayMap())->pluck('name', 'id')->toArray())
                        ->setDisplay('name')
                        ->setValidationRules(['required',
                                              'string'])

                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('user_replay', 'Профессиональный/Пользовательский')
                        ->setOptions(\App\Models\Replay::$userReplaysType)
                        ->setValidationRules(['required',
                                              'string'])
                ], 3)
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('first_race', 'Перва раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string']),
                        $first_country_id = AdminFormElement::select('first_country_id', 'Первая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string']),
                        $first_location = AdminFormElement::number('first_location', 'Первая локация')
                            ->setHtmlAttribute('placeholder', 'Первая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable',
                                                  'numeric',
                                                  'min:1',
                                                  'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'Первое имя')
                            ->setHtmlAttribute('placeholder', 'Первое имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable',
                                                  'string',
                                                  'between:1,255']),
                    ];
                })->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('second_race', 'Вторая раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string']),
                        $first_country_id = AdminFormElement::select('second_country_id', 'Вторая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required',
                                                  'string']),
                        $second_location = AdminFormElement::number('second_location', 'Вторая локация')
                            ->setHtmlAttribute('placeholder', 'Вторая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable',
                                                  'numeric',
                                                  'min:1',
                                                  'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),
                        $first_name = AdminFormElement::text('second_name', 'Второе имя')
                            ->setHtmlAttribute('placeholder', 'Второе имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable',
                                                  'string',
                                                  'between:1,255']),
                    ];
                })
        );
        $form->addBody([
            $content = AdminFormElement::wysiwyg('content', 'Контент')
                ->setHtmlAttributes(['placeholder' => 'Контент'])
                ->setValidationRules(['nullable',
                                      'string',
                                      'between:1,1000']),
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $file = AdminFormElement::file('file', 'Файл')
                            ->setValidationRules(['required',
                                                  'file',
                                                  'max:5120'])
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage' . PathHelper::checkUploadsFileAndPath("/files/replays");
                            }),
                    ];
                })
                ->addColumn(function () {
                    return [
                        $date = AdminFormElement::date('start_date', 'Дата начала')
                            ->setHtmlAttributes(['placeholder' => Carbon::now()->format('Y-m-d')])
                            ->setFormat('Y-m-d'),
                        $approved = AdminFormElement::checkbox('approved', 'Подтвержден')
                            ->setHtmlAttribute('checked', 'checked')
                            ->setDefaultValue(true),
                    ];
                })
        ]);

        return $form;
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    /**
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show()
    {
        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            return asset('admin/replays/' . $model->getKey() . '/show');
        }, 'Просмотреть', 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
