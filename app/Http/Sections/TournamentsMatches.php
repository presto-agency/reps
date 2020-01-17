<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
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
    protected $title;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('TournamentsMatchesDataTables')
            ->setOrder([[0, 'desc']])
            ->with('tourney','player1','player2','player1.user:id,name','player2.user:id,name')
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');


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
            AdminFormElement::text('tourney_id','Турнир')->setReadonly(true),
            AdminFormElement::text('player1_id','Первый игрок'),
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
