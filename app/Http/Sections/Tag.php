<?php

namespace App\Http\Sections;

use AdminFormElement;
use AdminForm;
use AdminColumnEditable;
use AdminDisplayFilter;
use AdminDisplay;
use AdminColumn;
use AdminColumnFilter;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Tag
 *
 * @property \App\Models\Tag $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Tag extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
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
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
//            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            /*->setActions([
                AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction('#'),
            ])*/
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'asc');
        });

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $name = AdminColumn::text('name', 'Name')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('100px'),

            $display_name = AdminColumn::text('display_name', 'Display Name')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('100px'),

        ]);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();
        $form->setItems([
            /*Init FormElement*/

            $name = AdminFormElement::text('name', 'Name')->required(),
            $display_name = AdminFormElement::text('display_name', 'Display Name')->required(),

        ]);
        return $form;// remove if unused
    }

    /**
     * @return FormInterface
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
}
