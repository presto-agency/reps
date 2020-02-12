<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\TourneyList;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Section;

/**
 * Class Tournaments
 *
 * @property \App\Models\TourneyList $model
 */
class Tournaments extends Section
{

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Список турниров';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return mixed
     * @throws \SleepingOwl\Admin\Exceptions\FilterOperatorException
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('id', '#')
                ->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('user.name', 'Admin')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('user', function ($q) use ($search) {
                            return $q->where('name', 'like',
                                '%'.$search.'%');
                        });
                    }
                })
                ->setWidth('150px')->setHtmlAttribute('class', 'text-left'),
            AdminColumn::text('name', 'Name')
                ->setHtmlAttribute('class', 'text-left'),
            AdminColumn::text('place', 'Place')->setWidth('150px')
                ->setHtmlAttribute('class', 'text-left'),
            AdminColumn::custom('Status', function ($model) {
                return TourneyList::$status[$model->status];
            })->setWidth('110px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Map select type', function ($model) {
                return TourneyList::$map_types[$model->map_select_type];
            })->setWidth('150px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::custom('Tourney type', function ($model) {
                if ( ! empty($model->type)) {
                    return TourneyList::$tourneyType[$model->type];
                } else {
                    return null;
                }
            })->setWidth('100px')->setHtmlAttribute('class', 'text-center')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        if ($search == TourneyList::TYPE_SINGLE) {
                            $query->where('type', TourneyList::TYPE_SINGLE);
                        }
                        if ($search == TourneyList::TYPE_DOUBLE) {
                            $query->where('type', TourneyList::TYPE_DOUBLE);
                        }
                    }
                }),
            AdminColumnEditable::checkbox('visible')->setLabel('Visible')
                ->setHtmlAttribute('class', 'text-center')->setWidth('75px')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        if ($search == TourneyList::YES) {
                            $query->where('visible', true);
                        }
                        if ($search == TourneyList::NO) {
                            $query->where('visible', false);
                        }
                    }
                }),
            AdminColumnEditable::checkbox('ranking')->setLabel('Ranking')
                ->setHtmlAttribute('class', 'text-center')->setWidth('75px')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        if ($search == TourneyList::YES) {
                            $query->where('ranking', true);
                        }
                        if ($search == TourneyList::NO) {
                            $query->where('ranking', false);
                        }
                    }
                }),

            AdminColumn::datetime('reg_time', 'Reg')->setWidth('90px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::datetime('checkin_time', 'Checkin')->setWidth('90px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::datetime('start_time', 'Start')->setWidth('90px')
                ->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('tournamentsDataTables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->with(['user', 'checkPlayers'])
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([
            AdminColumnFilter::text()
                ->setColumnName('id')
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Id')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Admin')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::text()
                ->setColumnName('name')
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Name')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::text()
                ->setColumnName('place')
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Place')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setColumnName('status')
                ->setOptions(TourneyList::$status)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setColumnName('map_select_type')
                ->setOptions(TourneyList::$map_types)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setColumnName('visible')
                ->setOptions(TourneyList::$tourneyTypeSelect)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setColumnName('visible')
                ->setOptions(TourneyList::$yesOrNo)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setColumnName('ranking')
                ->setOptions(TourneyList::$yesOrNo)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            null,
            null,

        ]);

        $display->getColumnFilters()->setPlacement('table.header');

        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->matches();
        $control->addButton($buttonShow);

        return $display;
    }

    public $id;
    public $tourneyStatus;

    public function onEdit($id)
    {
        $this->id = $id;
        $tourney  = $this->getModel()->find($id);
        if ($tourney) {
            $this->tourneyStatus = TourneyList::$status[$tourney->status];
        }
        $form = AdminForm::panel();
        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('name', 'Name')
                            ->setHtmlAttribute('placeholder', 'Name')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'string',
                                'unique:tourney_lists,name,'.$this->id,
                                'between:1,255',
                            ]),
                        AdminFormElement::text('place', 'Place')
                            ->setHtmlAttribute('placeholder', 'Place')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::select('map_select_type', 'Map select type')
                            ->setOptions(TourneyList::$map_types)
                            ->setValidationRules([
                                'in:1,2,3',
                            ]),
                        AdminFormElement::select('type', 'Tourney type')
                            ->setReadonly(function ($model) {
                                return isset($model::$status2[$model->status]);
                            })
                            ->setOptions(TourneyList::$tourneyType)
                            ->setValidationRules([
                                'nullable',
                                'in:1,2',
                            ]),
                    ];
                }, 4)
                ->addColumn(function () {
                    return [
                        AdminFormElement::datetime('reg_time', 'Reg time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'before:checkin_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i')
                            ->setReadonly(function ($model) {
                                return isset($model::$status2[$model->status]);
                            })
                        , AdminFormElement::datetime('checkin_time', 'Checkin time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'after:reg_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i')
                            ->setReadonly(function ($model) {
                                return isset($model::$status2[$model->status]);
                            })
                        ,
                        AdminFormElement::datetime('start_time', 'Start time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'after:checkin_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i'),

                    ];
                }, 4)
                ->addColumn(function () {
                    return [
                        AdminFormElement::select('user_id', 'Admin')
                            ->setOptions((new User())->pluck('name', 'id')->toArray())
                            ->setValidationRules([
                                'nullable',
                                'exists:users,id',
                            ]),
                        AdminFormElement::text('password', 'Password')
                            ->setHtmlAttribute('placeholder', 'Password')
                            ->setHtmlAttribute('maxlength', '12')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,12',
                            ]),
                        AdminFormElement::text('prize_pool', 'Prize pool')
                            ->setHtmlAttribute('placeholder', 'ВАНИМАНИЕ! Здесь важна разметка!!!')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHelpText('В зависимости от "," можна получить разные резултаты пара примеров заполнения:$,30,20,10,|$,15,5, (Webmoney)|,место в сборной,место в сборной,')
                            ->setValidationRules([
                                'string',
                                'max:255',
                            ]),
                    ];
                }, 4),
        ]);
        $form->addBody([
            AdminFormElement::columns()
                ->addColumn(function () {
                    $data1 = [
                        AdminFormElement::text('tourney_status', 'Tourney status')
                            ->setReadonly(true)
                            ->setHtmlAttribute('tabindex', '-1')
                            ->setHtmlAttribute('value', $this->tourneyStatus),
                    ];
                    $data2 = [
                        AdminFormElement::select('status', 'Status')
                            ->setOptions(TourneyList::$newStatus)
                            ->setValidationRules([
                                'in:5,6',
                            ]),
                    ];

                    $arr1 = $data1;
                    if ($this->tourneyStatus === 'STARTED' || $this->tourneyStatus === 'FINISHED') {
                        $arr1 = array_merge($data1, $data2);
                    }

                    $arr2 = [

                        AdminFormElement::checkbox('visible', 'Visible')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::checkbox('ranking', 'Ranking')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::file('all_file', 'All Tourney file in arch')
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage'.PathHelper::checkUploadsFileAndPath('/tourney/arch');
                            })
                            ->setValidationRules([
                                'nullable',
                                'max:20000',
                            ]),
                    ];

                    return array_merge($arr1, $arr2);
                }, 3)
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('rules_link', 'Rules link')
                            ->setHtmlAttribute('placeholder', 'Rules link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::text('vod_link', 'Vod link')
                            ->setHtmlAttribute('placeholder', 'Vod link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::text('logo_link', 'Logo link')
                            ->setHtmlAttribute('placeholder', 'Logo link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                    ];
                }, 9),
        ]);


        return $form;
    }


    public function onCreate()
    {
        $form = AdminForm::panel();
        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('name', 'Name')
                            ->setHtmlAttribute('placeholder', 'Name')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'required',
                                'unique:tourney_lists,name,'.$this->id,
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::text('place', 'Place')
                            ->setHtmlAttribute('placeholder', 'Place')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'required',
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::select('map_select_type', 'Map select type')
                            ->setOptions(TourneyList::$map_types)
                            ->setValidationRules([
                                'required',
                                'in:1,2,3',
                            ]),
                        AdminFormElement::select('type', 'Tourney type')
                            ->setOptions(TourneyList::$tourneyType)
                            ->setValidationRules([
                                'required',
                                'in:1,2',
                            ]),

                    ];
                }, 4)
                ->addColumn(function () {
                    return [
                        AdminFormElement::datetime('reg_time', 'Reg time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'before:checkin_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i')
                        , AdminFormElement::datetime('checkin_time', 'Checkin time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'after:reg_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i')
                        ,
                        AdminFormElement::datetime('start_time', 'Start time')
                            ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d H:i'))
                            ->setValidationRules([
                                'nullable',
                                'after:checkin_time',
                                'date_format:"Y-m-d H:i"',
                            ])
                            ->setPickerFormat('Y-m-d H:i'),

                    ];
                }, 4)
                ->addColumn(function () {
                    return [
                        AdminFormElement::select('user_id', 'Admin')
                            ->setOptions((new User())->where('role_id', '=', 1)->pluck('name', 'id')->toArray())
                            ->setValidationRules([
                                'nullable',
                                'exists:users,id',
                            ]),
                        AdminFormElement::text('password', 'Password')
                            ->setHtmlAttribute('placeholder', 'Password')
                            ->setHtmlAttribute('maxlength', '12')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,12',
                            ]),


                        AdminFormElement::text('prize_pool', 'Prize pool')
                            ->setHtmlAttribute('placeholder', 'ВАНИМАНИЕ! Здесь важна разметка!!!')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHelpText('В зависимости от "," можна получить разные резултаты пара примеров заполнения:$,30,20,10,|$,15,5, (Webmoney)|,место в сборной,место в сборной,')
                            ->setValidationRules([
                                'required',
                                'string',
                                'max:255',
                            ]),
                    ];
                }, 4),
        ]);
        $form->addBody([
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::checkbox('visible', 'Visible')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::checkbox('ranking', 'Ranking')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::file('all_file', 'All Tourney file in arch')
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage'.PathHelper::checkUploadsFileAndPath('/tourney/arch');
                            })
                            ->setValidationRules([
                                'nullable',
                                'max:10000',
                            ]),
                    ];
                }, 3)
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('rules_link', 'Rules link')
                            ->setHtmlAttribute('placeholder', 'Rules link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::text('vod_link', 'Vod link')
                            ->setHtmlAttribute('placeholder', 'Vod link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                        AdminFormElement::text('logo_link', 'Logo link')
                            ->setHtmlAttribute('placeholder', 'Logo link')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'between:1,255',
                            ]),
                    ];
                }, 9),
        ]);

        return $form;
    }

    /**
     * @param $id
     */
    public function onDelete($id)
    {
    }

    /**
     * @return ControlLink
     */
    public function matches()
    {
        $link = new ControlLink(function (Model $model) {
            return route('admin.tourney.show', ['id' => $model->getKey()]);
        }, 'Создать матчи', 50);
        $link->hideText();
        $link->setIcon('fas fa-archway');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
