<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class PublicChat
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\PublicChat $model
 *
 */
class PublicChat extends Section
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
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(50);

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px'),

            $message = AdminColumn::text('message', 'Message')
                ->setWidth('60px'),

            $isHidden = AdminColumnEditable::checkbox('is_hidden', 'Yes', 'No')
                ->setLabel('Hidden'),

            $date = AdminColumn::datetime('created_at', 'Date')
                ->setFormat('Y-m-d H:m:s')->setWidth('20px'),

        ]);

        return $display;
    }

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();
        $form->setItems([
            /*Init FormElement*/

            $message = AdminFormElement::text('message', 'Message')->required(),
            $isHidden = AdminFormElement::checkbox('is_hidden', 'Hidden'),
            $user = AdminFormElement::hidden('user_id')
                ->setDefaultValue(auth()->user()->id),

        ]);

        return $form;
    }

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
