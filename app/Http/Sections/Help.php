<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;

use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Help
 *
 * @property \App\Models\Help $model
 */
class Help extends Section implements Initializable
{
    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Подсказки';

    /**
     * @var string
     */
    protected $alias;

    public function getIcon()
    {
        return 'fa fa-question-circle';
    }

    public function initialize()
    {
        $this->addToNavigation(9);
    }


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

        /*$display = AdminDisplay::datatables()
          ->setName('firstdatatables')
          ->setOrder([[0, 'asc']])
          ->setDisplaySearch(true)
          ->paginate(25)
//          ->setColumns($columns)
          ->setHtmlAttribute('class', 'table-primary table-hover th-center');*/


        /*$display->setColumnFilters([
          AdminColumnFilter::select()
            ->setModelForOptions(\App\Models\Help::class, 'name')
            ->setLoadOptionsQueryPreparer(function($element, $query) {
              return $query;
            })
            ->setDisplay('name')
            ->setColumnName('name')
            ->setPlaceholder('All names'),
        ]);

        $display->getColumnFilters()->setPlacement('panel.heading');*/

//        return $display;


        return AdminDisplay::table()
        ->setHtmlAttribute('class', 'table-primary')
            ->setColumns(
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('display_name', 'Настройка')->setWidth('200px'),
                AdminColumn::text('value', 'Значение'),
                AdminColumn::text('description', 'Описание')
            )->paginate(20);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
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

        // поле key - нельзя редактировать
        return AdminForm::panel()->addBody([
            AdminFormElement::text('display_name', 'Название настройки')->required(),
            AdminFormElement::wysiwyg('value', 'Значение')
                ->setHtmlAttributes(['placeholder' => 'Текст'])
                ->setValidationRules(['required', 'string', 'between:1,10000']),
            AdminFormElement::text('description', 'Описание подсказки')->required(),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),

        ]);

    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
//        return $this->onEdit(null);
        // а вот создать var можно. Один раз и навсегда
        return AdminForm::panel()->addBody([
            AdminFormElement::text('display_name', 'Название настройки')->required(),
            AdminFormElement::text('key', 'Постоянный системный код')->required()->unique(),
            AdminFormElement::wysiwyg('value', 'Значение')
                ->setHtmlAttributes(['placeholder' => 'Текст'])
                ->setValidationRules(['required', 'string', 'between:1,1000']),
            AdminFormElement::text('description', 'Описание подсказки')->required(),

        ]);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
