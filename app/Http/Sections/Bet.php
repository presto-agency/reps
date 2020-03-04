<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;

/**
 * Class Bet
 *
 * @property \App\Models\Bet $model
 */
class Bet extends Section
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
          AdminColumn::text('id', 'ID')
            ->setWidth('50px')
            ->setHtmlAttribute('class', 'text-center'),
          /*AdminColumn::link('name', 'Name', 'created_at')
            ->setSearchCallback(function($column, $query, $search){
              return $query->orWhere('name', 'like', '%'.$search.'%')
                           ->orWhere('created_at', 'like', '%'.$search.'%');
            })
            ->setOrderable(function($query, $direction) {
              $query->orderBy('created_at', $direction);
            }),*/
          AdminColumn::text('author.name', 'Author')
              ->setSearchable(false)
              ->append(
                  AdminColumn::filter('author_id')
              ),
          AdminColumn::text('winner.name', 'Winner')
              ->setSearchable(false)
              ->append(
                  AdminColumn::filter('winner_id')
              ),
            AdminColumn::text('player1', 'Player1'),
            AdminColumn::text('player2', 'Player2'),
            AdminColumn::text('coefficient1', 'K1'),
            AdminColumn::text('coefficient2', 'K2'),
            AdminColumn::boolean('status', 'Active'),
          AdminColumn::text('created_at', 'Created / updated', 'updated_at')
            ->setWidth('160px')
            ->setOrderable(function($query, $direction) {
              $query->orderBy('updated_at', $direction);
            })
            ->setSearchable(false),
        ];

        $display = AdminDisplay::datatables()
          ->setName('firstdatatables')
          ->setOrder([[0, 'asc']])
          ->setDisplaySearch(true)
          ->paginate(25)
          ->setColumns($columns)
          ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->setFilters(
            AdminDisplayFilter::related('author_id')->setModel(User::class),
            AdminDisplayFilter::related('winner_id')->setModel(User::class)
        );

        /*$display->setColumnFilters([
          AdminColumnFilter::select()
            ->setModelForOptions(\App\Models\Bet::class, 'name')
            ->setLoadOptionsQueryPreparer(function($element, $query) {
              return $query;
            })
            ->setDisplay('name')
            ->setColumnName('name')
            ->setPlaceholder('All names'),
        ]);*/

        $display->getColumnFilters()->setPlacement('panel.heading');

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    /*public function onEdit($id)
    {
        $form = AdminForm::panel()->addBody([
          AdminFormElement::columns()->addColumn([

            AdminFormElement::text('name', 'Name')
              ->required(),
            AdminFormElement::html('<hr>'),
            AdminFormElement::datetime('created_at')
              ->setVisible(true)
              ->setReadonly(false),
            AdminFormElement::html('last AdminFormElement without comma')

          ], 8)->addColumn([

            AdminFormElement::text('id', 'ID')
              ->setReadonly(true),
            AdminFormElement::html('last AdminFormElement without comma')

          ]),
        ]);

        $form->getButtons()->setButtons([
          'save'  => new Save(),
          'save_and_close'  => new SaveAndClose(),
          'save_and_create'  => new SaveAndCreate(),
          'cancel'  => (new Cancel()),
        ]);

        return $form;
    }*/

    /**
     * @return FormInterface
     */
    /*public function onCreate()
    {
        return $this->onEdit(null);
    }*/

    /**
     * @return void
     */
    /*public function onDelete($id)
    {
        // remove if unused
    }*/

}
