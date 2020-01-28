<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class TournamentsMatches
 *
 * @property \App\Models\TourneyMatch $model
 */
class TournamentsMatches extends Section
{

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Список матчей';

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return mixed
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('tourney.name', '<small>Турнир</small>')
                ->setWidth('300px'),
            AdminColumn::text('player1.description', '<small>Игрок 1<br>GameNick/Name</small>', 'player1.user.name')
                ->setWidth('125px'),
            AdminColumn::text('player2.description', '<small>Игрок 2<br>GameNick/Name</small>', 'player1.user.name')
                ->setWidth('125px'),
            AdminColumn::text('player1_score', '<small>Игрок 1<br>очки</small>')->setWidth('67px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('player2_score', '<small>Игрок 2<br>очки</small>')->setWidth('67px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('winner_score', '<small>Чемпион<br>очки</small>')->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('match_number', '<small>№<br>матча</small>')->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('round_number', '<small>№<br>раунда</small>')->setWidth('60px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::boolean('played')->setLabel('<small>Сыграно</small>'),

        ];
        //        $columns = [
        //            AdminColumn::link('name', 'Name', 'created_at')
        //                ->setSearchCallback(function($column, $query, $search){
        //                    return $query->orWhere('name', 'like', '%'.$search.'%')
        //                        ->orWhere('created_at', 'like', '%'.$search.'%');
        //                })
        //                ->setOrderable(function($query, $direction) {
        //                    $query->orderBy('created_at', $direction);
        //                }),
        //            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
        //                ->setWidth('160px')
        //                ->setOrderable(function($query, $direction) {
        //                    $query->orderBy('updated_at', $direction);
        //                })
        //                ->setSearchable(false),
        //        ];

        $display = AdminDisplay::datatables()
            ->setName('TournamentsMatchesDataTables')
            ->setOrder([[0, 'desc']])
            ->with('tourney', 'player1', 'player2', 'player1.user:id,name', 'player2.user:id,name')
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');
        $display->setFilters(
            AdminDisplayFilter::field('tourney_id')->setTitle('Tourney ID [:value]')
        );

        //        $display->setColumnFilters([
        //          AdminColumnFilter::select()
        //            ->setModelForOptions(\App\Models\TourneyMatch::class, 'name')
        //            ->setLoadOptionsQueryPreparer(function($element, $query) {
        //              return $query;
        //            })
        //            ->setDisplay('name')
        //            ->setColumnName('name')
        //            ->setPlaceholder('All names'),
        //        ]);
        //
        //        $display->getColumnFilters()->setPlacement('panel.heading');

        return $display;
    }

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('tourney_id', 'Турнир')->setReadonly(true),
            AdminFormElement::text('player1_id', 'Первый игрок'),
        ]);
    }

    //    /**
    //     * @return FormInterface
    //     */
    //    public function onCreate()
    //    {
    //        return AdminForm::panel()->addBody([
    //            AdminFormElement::text('tourney_id')->setReadonly(true),
    //        ]);
    //    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
