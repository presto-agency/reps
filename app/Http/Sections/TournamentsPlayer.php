<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\TourneyList;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Section;

/**
 * Class TournamentsPlayer
 *
 * @property \App\Models\TourneyPlayer $model
 */
class TournamentsPlayer extends Section
{

    /**
     * @var bool
     */
    protected $checkAccess = true;

    /**
     * @var string
     */
    protected $title = 'Список игроков';

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
            AdminColumn::text('tourney.name', 'Tourney name')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('tourney', function ($q) use ($search) {
                            return $q->where('name', 'like', "%$search%");
                        });
                    }
                }),
            AdminColumn::custom('Tourney status', function ($model) {
                if ( ! empty($model->tourney)) {
                    return TourneyList::$status[$model->tourney->status];
                }
            }),
            AdminColumn::text('user.name', 'User name')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('user', function ($q) use ($search) {
                            return $q->where('name', 'like', "%$search%");
                        });
                    }
                })->setWidth('200px'),
            AdminColumn::text('description', 'Description')->setWidth('200px'),
            AdminColumnEditable::checkbox('check')
                ->setLabel('Check')
                ->setWidth('75px'),
            AdminColumnEditable::checkbox('ban')
                ->setLabel('Ban')
                ->setWidth('75px'),
            AdminColumn::text('place_result', 'Place<br>result<br>(old)')
                ->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('victory_points', 'Victory<br>points<br>(new)')
                ->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('defeat', 'Defeat<br>points<br>(new)')
                ->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('TournamentsPlayerDataTables')
            ->setOrder([[0, 'desc']])
            ->with('user', 'tourney')
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setColumnFilters([

            null,
            AdminColumnFilter::select()
                ->setOptions((new \App\Models\TourneyList())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('All')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            null,
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('User name')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Description')
                ->setHtmlAttributes(['style' => 'width: 100%']),

        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }


    public $tourneyStatus;

    public function onEdit($id)
    {
        $tourneyStatus = $this->getModel()->find($id);
        if ($tourneyStatus) {
            $this->tourneyStatus = TourneyList::$status[$tourneyStatus->tourney->status];
        }

        return AdminForm::panel()->addBody([
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::checkbox('check', 'Check')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::checkbox('ban', 'Ban')
                            ->setValidationRules([
                                'boolean',
                            ]),
                        AdminFormElement::text('description', 'Description')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setValidationRules([
                                'nullable',
                                'string',
                                'max:255',
                            ]),
                    ];
                }, 6)->addColumn(function () {
                    return [
                        AdminFormElement::text('tourney.name', 'Tourney')
                            ->setHtmlAttribute('readonly', 'true')
                            ->setHtmlAttribute('tabindex', '-1'),
                        AdminFormElement::text('tourney_status', 'Tourney status')
                            ->setHtmlAttribute('readonly', 'true')
                            ->setHtmlAttribute('tabindex', '-1')
                            ->setHtmlAttribute('value', $this->tourneyStatus),
                        AdminFormElement::text('user.name', 'User name')
                            ->setHtmlAttribute('readonly', 'true')
                            ->setHtmlAttribute('tabindex', '-1'),
                        AdminFormElement::text('place_result', 'Place result')
                            ->setHtmlAttribute('readonly', 'true')
                            ->setHtmlAttribute('tabindex', '-1'),
                    ];
                }, 6),
        ]);
    }

    //    /**
    //     * @return FormInterface
    //     */
    //    public function onCreate()
    //    {
    //        return null;
    //    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
