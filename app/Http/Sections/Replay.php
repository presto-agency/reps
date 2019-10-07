<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;

use AdminDisplayFilter;
use AdminFormElement;
use App\Models\Race;
use App\Models\ReplayMap;
use App\Models\Country;
use App\Models\ReplayType;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
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
        $replay = \App\Models\Replay::class;

        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center')
            ->paginate(10);

        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Replay::class),
            AdminDisplayFilter::related('type_id')->setModel(\App\Models\Replay::class),
        ]);

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->with('users', 'maps', 'types');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь'),

            $user_replay = AdminColumn::text('user_replay', 'Название'),

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

            $race = AdminColumn::custom('Расы', function ($replay) {
                return "{$replay->firstRaces->title}" . '<br/><small>vs</small><br/>' . "{$replay->secondRaces->title}";
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
                ->append(AdminColumn::filter('type_id'))
                ->setWidth(55),

            $comments_count = AdminColumn::text('comments_count', 'Коментарии')
                ->setWidth(105),

            $user_rating = AdminColumn::relatedLink('user_rating', 'Оценка <br/><small>(пользователей)</small>')
                ->setWidth(125),

            $rating = AdminColumn::custom('Рейтинг', function ($replay) {
                $positive = $replay->negative_count;
                $negative = $replay->positive_count;
                $result = $positive - $negative;
                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';
                return "{$thumbsUp}" . "({$positive})" . '<br/>' . "{$equals}" . "({$result})" . '<br/>' . "{$thumbsDown}" . "({$negative})";
            })->setWidth(10),

            $approved = AdminColumnEditable::checkbox('approved')->setLabel('Подтвержден')
                ->append(AdminColumn::filter('approved'))
                ->setWidth(75),

        ]);

        $display->setColumnFilters([
            $id = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Id')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user_id = AdminColumnFilter::text()
                ->setOperator('contains')
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user_replay = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $map_id = AdminColumnFilter::select()
                ->setOptions((new ReplayMap())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все карты')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $country = AdminColumnFilter::select()
                ->setOptions((new Country())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все Страны')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $race = AdminColumnFilter::select()
                ->setOptions((new Race())->pluck('title', 'title')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все Расы')
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

                    $user_replay = AdminFormElement::text('user_replay', 'Название')
                        ->setHtmlAttributes(['placeholder' => 'Название'])
                        ->setValidationRules(['required', 'string', 'between:4,255'])
                ], 3)
                ->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Тип', $this->type())
                        ->setValidationRules(['required', 'string'])
                ], 3)
                ->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Карта', $this->map())
                        ->setValidationRules(['required', 'string'])
                ])
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [

                        $first_race = AdminFormElement::select('first_race', 'Перва раса', $this->race())
                            ->setValidationRules(['required', 'string']),

                        $first_country_id = AdminFormElement::select('first_country_id', 'Первая страна', $this->country())
                            ->setValidationRules(['required', 'string']),

                        $first_location = AdminFormElement::text('first_location', 'Первая локация')
                            ->setHtmlAttributes(['placeholder' => 'Первая локация'])
                            ->setValidationRules(['nullable', 'numeric', 'max:255'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'Первое имя')
                            ->setHtmlAttributes(['placeholder' => 'Первое имя'])
                            ->setValidationRules(['nullable', 'string', 'alpha_dash', 'max:255']),

                        $first_apm = AdminFormElement::text('first_apm', 'Первый APM')
                            ->setHtmlAttributes(['placeholder' => 'Первый APM'])
                            ->setValidationRules(['nullable', 'numeric', 'between:1,255']),

                    ];
                })->addColumn(function () {
                    return [

                        $first_race = AdminFormElement::select('second_race', 'Вторая раса', $this->race())
                            ->setValidationRules(['required', 'string']),

                        $first_country_id = AdminFormElement::select('second_country_id', 'Вторая страна', $this->country())
                            ->setValidationRules(['required', 'string']),

                        $first_location = AdminFormElement::text('second_location', 'Вторая локация')
                            ->setHtmlAttributes(['placeholder' => 'Вторая локация'])
                            ->setValidationRules(['nullable', 'numeric', 'min:1'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),

                        $first_name = AdminFormElement::text('second_name', 'Второе имя')
                            ->setHtmlAttributes(['placeholder' => 'Второе имя'])
                            ->setValidationRules(['nullable', 'string', 'alpha_dash', 'max:255']),

                        $first_apm = AdminFormElement::text('second_apm', 'Второй APM')
                            ->setHtmlAttributes(['placeholder' => 'Второй APM'])
                            ->setValidationRules(['nullable', 'numeric', 'between:1,255']),

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
                            ->setValidationRules(['required', 'file', 'max:10000'])
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage/file/replay';
                            })->setUploadFileName(function (UploadedFile $file) {
                                return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                            }),
                    ];
                })
                ->addColumn(function () {
                    return [
                        $date = AdminFormElement::date('start_date', 'Дата начала')->setFormat('Y-m-d'),

                        $approved = AdminFormElement::checkbox('approved', 'Подтвержден')

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
        return $this->onEdit(null);
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
            $url = url('admin/replays/show');
            return $url . '/' . $model->getKey();
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

    private $map, $country, $race, $type;


    private function map()
    {
        foreach (ReplayMap::get(['id', 'name']) as $item) {
            $this->map[$item->id] = $item->name;
        }
        return $this->map;
    }

    private function country()
    {
        foreach (Country::get(['id', 'name']) as $item) {
            $this->country[$item->id] = $item->name;
        }

        return $this->country;
    }

    private function race()
    {
        foreach (Race::get(['id', 'title']) as $item) {
            $this->race[$item->id] = $item->title;
        }
        return $this->race;
    }

    private function type()
    {

        foreach (ReplayType::get(['id', 'title']) as $item) {
            $this->type[$item->id] = $item->title;
        }
        return $this->type;
    }

}
