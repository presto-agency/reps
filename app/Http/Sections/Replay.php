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
            ->setHtmlAttribute('class', 'table-info table-sm text-center')
            ->paginate(10);

        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Replay::class),
            AdminDisplayFilter::related('user_replay')->setModel(\App\Models\Replay::class),
        ]);
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });
        $display->with('users', 'maps', 'types');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(70),

            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь'),

            $user_replay = AdminColumn::text('title', 'Название'),

            $map_id = AdminColumn::relatedLink('maps.name', 'Карта')
                ->setWidth(100),

            $country = AdminColumn::custom('Страны', function ($model) {
                return "{$model->firstCountries->name}" . '<br/><small>vs</small><br/>' . "{$model->secondCountries->name}";
            })->setFilterCallback(function ($column, $query, $search) {
                $searchId = Country::where('name', $search)->value('id');
                if (!empty($searchId)) {
                    $query->where('first_country_id', 'like', "$searchId")->orWhere('second_country_id', 'like', "$searchId");
                }
                if (empty($searchId)) {
                    $query->get();
                }
            })->setWidth(120),

            $race = AdminColumn::custom('Расы', function ($model) {
                return "{$model->firstRaces->title}" . '<br/><small>vs</small><br/>' . "{$model->secondRaces->title}";
            })->setFilterCallback(function ($column, $query, $search) {
                $searchId = Race::where('title', $search)->value('id');
                if (!empty($searchId)) {
                    $query->where('first_race', 'like', "$searchId")->orWhere('second_race', 'like', "$searchId");
                }
                if (empty($searchId)) {
                    $query->get();
                }
            })
                ->setWidth(70),

            $type_id = AdminColumn::text('types.title', 'Тип')
                ->setWidth(70),

            $user_replay = AdminColumn::custom('Тип 2', function ($model) {
                return $model->user_replay == $model::REPLAY_PRO ? "Профессиональный" : "Пользовательский";
            })
                ->append(AdminColumn::filter('user_replay'))
                ->setWidth(100),

            $comments_count = AdminColumn::text('comments_count', 'Коментарии')
                ->setWidth(105),

            $user_rating = AdminColumn::relatedLink('user_rating', 'Оценка <br/><small>(пользователей)</small>')
                ->setWidth(125),

            $rating = AdminColumn::custom('Рейтинг', function ($model) {
                $positive = $model->negative_count;
                $negative = $model->positive_count;
                $result = $positive - $negative;
                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';
                return "{$thumbsUp}" . "({$positive})" . '<br/>' . "{$equals}" . "({$result})" . '<br/>' . "{$thumbsDown}" . "({$negative})";
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
            $user_id = AdminColumnFilter::text()
                ->setOperator('contains')
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $title = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $map_id = AdminColumnFilter::select()
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
            $type_id = AdminColumnFilter::select()
                ->setOptions((new ReplayType())->pluck('title', 'title')->toArray())
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
                        ->setValidationRules(['required', 'string', 'between:1,255'])
                ], 3)
                ->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Тип')
                        ->setOptions((new ReplayType())->pluck('title', 'id')->toArray())
                        ->setDisplay('title')
                        ->setValidationRules(['required', 'string', 'exists:replay_types,id'])
                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Карта')
                        ->setOptions((new ReplayMap())->pluck('name', 'id')->toArray())
                        ->setDisplay('name')
                        ->setValidationRules(['required', 'string', 'exists:replay_maps,id'])

                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('user_replay', 'Профессиональный/Пользовательский')
                        ->setOptions(\App\Models\Replay::$userReplaysType)
                        ->setValidationRules(['required', 'string', 'in:0,1'])
                ], 3)
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('first_race', 'Перва раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string', 'exists:races,id']),
                        $first_country_id = AdminFormElement::select('first_country_id', 'Первая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string', 'exists:countries,id']),
                        $first_location = AdminFormElement::number('first_location', 'Первая локация')
                            ->setHtmlAttribute('placeholder', 'Первая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable', 'numeric', 'min:1', 'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'Первое имя')
                            ->setHtmlAttribute('placeholder', 'Первое имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable', 'string', 'between:1,255']),
                    ];
                })->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('second_race', 'Вторая раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string', 'exists:races,id']),
                        $first_country_id = AdminFormElement::select('second_country_id', 'Вторая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string', 'exists:countries,id']),
                        $second_location = AdminFormElement::number('second_location', 'Вторая локация')
                            ->setHtmlAttribute('placeholder', 'Вторая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable', 'numeric', 'min:1', 'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),
                        $first_name = AdminFormElement::text('second_name', 'Второе имя')
                            ->setHtmlAttribute('placeholder', 'Второе имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable', 'string', 'between:1,255']),
                    ];
                })
        );

        $form->addBody([
            $video_iframe = AdminFormElement::wysiwyg('video_iframe', 'Видео')
                ->setHtmlAttributes(['placeholder' => 'Видео'])
                ->setValidationRules(['nullable', 'string', 'max:5000']),

            $content = AdminFormElement::wysiwyg('content', 'Краткое описание')
                ->setHtmlAttributes(['placeholder' => 'Краткое описание'])
                ->setValidationRules(['required', 'string', 'between:1,2000']),

            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $file = AdminFormElement::file('file', 'Файл')
                            ->setValidationRules(['required', 'file', 'max:5120'])
                            ->setUploadPath(function (UploadedFile $file) {
                                return PathHelper::checkUploadStoragePath("/files/replays");
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
                        ->setValidationRules(['required', 'string', 'between:1,255'])
                ], 3)
                ->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Тип')
                        ->setOptions((new ReplayType())->pluck('title', 'id')->toArray())
                        ->setDisplay('title')
                        ->setValidationRules(['required', 'string'])
                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Карта')
                        ->setOptions((new ReplayMap())->pluck('name', 'id')->toArray())
                        ->setDisplay('name')
                        ->setValidationRules(['required', 'string'])

                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('user_replay', 'Профессиональный/Пользовательский')
                        ->setOptions(\App\Models\Replay::$userReplaysType)
                        ->setValidationRules(['required', 'string'])
                ], 3)
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('first_race', 'Перва раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string']),
                        $first_country_id = AdminFormElement::select('first_country_id', 'Первая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string']),
                        $first_location = AdminFormElement::number('first_location', 'Первая локация')
                            ->setHtmlAttribute('placeholder', 'Первая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable', 'numeric', 'min:1', 'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'Первое имя')
                            ->setHtmlAttribute('placeholder', 'Первое имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable', 'string', 'between:1,255']),
                    ];
                })->addColumn(function () {
                    return [
                        $first_race = AdminFormElement::select('second_race', 'Вторая раса')
                            ->setOptions((new Race())->pluck('title', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string']),
                        $first_country_id = AdminFormElement::select('second_country_id', 'Вторая страна')
                            ->setOptions((new Country())->pluck('name', 'id')->toArray())
                            ->setDisplay('name')
                            ->setValidationRules(['required', 'string']),
                        $second_location = AdminFormElement::number('second_location', 'Вторая локация')
                            ->setHtmlAttribute('placeholder', 'Вторая локация')
                            ->setStep('1')
                            ->setMin('1')
                            ->setMax('20')
                            ->setValidationRules(['nullable', 'numeric', 'min:1', 'max:20'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),
                        $first_name = AdminFormElement::text('second_name', 'Второе имя')
                            ->setHtmlAttribute('placeholder', 'Второе имя')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['nullable', 'string', 'between:1,255']),
                    ];
                })
        );

        $form->addBody([
            $content = AdminFormElement::wysiwyg('content', 'Контент')
                ->setHtmlAttributes(['placeholder' => 'Контент'])
                ->setValidationRules(['nullable', 'string', 'between:1,1000']),
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $file = AdminFormElement::file('file', 'Файл')
                            ->setValidationRules(['required', 'file', 'max:5120'])
                            ->setUploadPath(function (UploadedFile $file) {
                                return PathHelper::checkUploadStoragePath("/files/replays");
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
            $id = $model->getKey();
            $url = url("admin/replays/$id/show");
            return $url;
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
