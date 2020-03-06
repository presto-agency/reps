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
use SleepingOwl\Admin\Display\ControlLink;

use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;

use SleepingOwl\Admin\Form\FormElements;
use App\Models\GasTransaction as GasTransactionModel;

use App\User;

/**
 * Class GasTransaction
 *
 * @property \App\Models\GasTransaction $model
 */
class GasTransaction extends Section
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
        /*$columns = [
          AdminColumn::text('id', '#')
            ->setWidth('50px')
            ->setHtmlAttribute('class', 'text-center'),
          AdminColumn::link('name', 'Name', 'created_at')
            ->setSearchCallback(function($column, $query, $search){
              return $query->orWhere('name', 'like', '%'.$search.'%')
                           ->orWhere('created_at', 'like', '%'.$search.'%');
            })
            ->setOrderable(function($query, $direction) {
              $query->orderBy('created_at', $direction);
            }),
          AdminColumn::boolean('name', 'On'),
          AdminColumn::text('created_at', 'Created / updated', 'updated_at')
            ->setWidth('160px')
            ->setOrderable(function($query, $direction) {
              $query->orderBy('updated_at', $direction);
            })
            ->setSearchable(false),
        ];*/

/*
        $display = AdminDisplay::datatables()
          ->setName('firstdatatables')
          ->setOrder([[0, 'asc']])
          ->setDisplaySearch(true)
          ->paginate(25)
          ->setColumns($columns)
          ->setHtmlAttribute('class', 'table-primary table-hover th-center');


        $display->setColumnFilters([
          AdminColumnFilter::select()
            ->setModelForOptions(\App\Models\GasTransaction::class, 'name')
            ->setLoadOptionsQueryPreparer(function($element, $query) {
              return $query;
            })
            ->setDisplay('name')
            ->setColumnName('name')
            ->setPlaceholder('All names'),
        ]);

        $display->getColumnFilters()->setPlacement('panel.heading');



        $tabs = AdminDisplay::tabbed();




        $tabs->appendTab(
            new  FormElements([
                '<div class="alert bg-info">
                           <p>На данный момент существует 4 типа колонок с возможностью редактирования:</p>
                           <p>AdminColumnEditable::text(\'fielName\', \'Label\'),</p>
                           <p>AdminColumnEditable::checkbox(\'fielName\', \'Label\'),</p>
                           <p>AdminColumnEditable::datetime(\'fielName\', \'Label\'),</p>
                           <p>AdminColumnEditable::select(\'fielName\')</p>
                           <p>      ->setModelForOptions(new SourseModel)</p>
                           <p>      ->setLabel(\'label\')</p>
                           <p>      ->setDisplay(\'title\')</p>


                        </div>
                        ',

                $display
            ]),
            'Editable Columns'

        );





        return $tabs;*/


//        return $display;


        /*$columns = [
            AdminColumn::link('title', 'Title'),
            AdminColumn::datetime('date', 'Date')->setFormat('d.m.Y')->setWidth('150px'),
            AdminColumn::checkbox('published', 'On'),
        ];*/
        $columns = [
            AdminColumn::text('id', 'ID')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('user.name', 'User')
                ->setSearchable(false)
                ->append(
                    AdminColumn::filter('user_id')
                ),
            AdminColumn::text('initializable.name', 'Initializator')
                ->setSearchable(false),
            AdminColumn::text('incoming', 'Приход'),
            AdminColumn::text('outgoing', 'Расход'),
            AdminColumn::text('description', 'Описание'),
            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function($query, $direction) {
                    $query->orderBy('updated_at', $direction);
                })
                ->setSearchable(false),
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'desc']])
//            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

        $display->with('user');
        $display->setFilters(
            AdminDisplayFilter::related('user_id')->setModel(User::class)
        );



        /*$display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Full Name'),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('From')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('To')
            ),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
            )->setTo(
                AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
            ),
            AdminColumnFilter::select(Country::class, 'title')->setPlaceholder('Country')->multiple(),
            null,
        ]);*/


        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setPlaceholder('Name')->setOperator('contains'),
//            AdminColumnFilter::select(User::class, 'name')/*->setModel(new User())->setDisplay('name')*/->setPlaceholder('Имя не выбрано')->setColumnName('user_id')->multiple(),
            null,
            null,
            null,
            AdminColumnFilter::text()->setPlaceholder('Description')->setColumnName('description')->setOperator('contains'),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::date()->setPlaceholder('From Date')->setColumnName('created_at')->setFormat('Y-m-d')->setOperator('greater')
            )->setTo(
                AdminColumnFilter::date()->setPlaceholder('To Date')->setColumnName('created_at')->setFormat('Y-m-d')->setOperator('less')
            ),

        ]);
        $display->getColumnFilters()->setPlacement('table.header');




        $tabs = AdminDisplay::tabbed();

        $tabs->setElements([
            AdminDisplay::tab($display)
                ->setLabel('All'),
        ]);

        return $tabs;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onCreate()
    {
        /*$form = AdminForm::panel()->addBody([
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

        return $form;*/


        /*$form = AdminForm::form()->addElement(
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::select('user_id', 'User', User::class)->setDisplay('name')
                ], 12)
                ->addColumn([
                    AdminFormElement::text('description', 'Description')->required()
                ], 3)
        );*/

        /*$formDebet = AdminForm::form()->addElement(
            new FormElements([
                AdminFormElement::number('incoming', 'Amount')->required('so sad but this field is empty')
            ])
        );*/


        $form = AdminForm::panel();

        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::selectajax('user_id', 'User')
                        ->setModelForOptions(User::class)
                        ->setSearch('name')
                        ->setDisplay('name')
                        ->required()
                ])
        ]);

        $tabs = AdminDisplay::tabbed([
            'Начислить' => new FormElements([
                AdminFormElement::number('incoming', 'Amount')
                    ->setDefaultValue(0),
            ]),
            'Списать' => new FormElements([
                AdminFormElement::number('outgoing', 'Amount')
                    ->setDefaultValue(0),
            ]),
        ]);

        $form->addElement($tabs);

        $form->addBody(AdminFormElement::textarea('description', 'Description')->required());
        $form->addBody(AdminFormElement::hidden('admin_id')->setDefaultValue(auth()->user()->id));

        return $form;

        /*$formDebet = AdminForm::form()->addElement(
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::selectajax('user_id', 'User')
                        ->setModelForOptions(User::class, 'name')
                        ->setSearch('name')
                        ->setDisplay('name')
                ])
                ->addColumn([
                    AdminFormElement::number('incoming', 'Amount')->required('so sad but this field is empty')
                ])
                ->addColumn([
                    AdminFormElement::textarea('description', 'Description')->required()
                ])
                ->addColumn([
                    AdminFormElement::hidden('admin_id')->setDefaultValue(auth()->user()->id)
                ])
        );
        $formCredit = AdminForm::form()->addElement(
            AdminFormElement::columns()

                ->addColumn([
                    AdminFormElement::number('outgoing', 'Amount')->required('so sad but this field is empty')
                ])
                ->addColumn([
                    AdminFormElement::textarea('description', 'Description')->required()
                ])
                ->addColumn([
                    AdminFormElement::hidden('admin_id')->setDefaultValue(auth()->user()->id)
                ])
        );

        $tabs = AdminDisplay::tabbed();

        $tabs->appendTab($formDebet,     'Начислить');

        $tabs->appendTab($formCredit,   'Списать');


        return $tabs;*/

    }

    /**
     * @return FormInterface
     */
    /*public function onEdit($id)
    {
        return $this->onCreate(null);
    }*/

    /**
     * @return void
     */
    /*public function onDelete($id)
    {
        // remove if unused
    }*/

}
