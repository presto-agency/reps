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
 * Class Headline
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\Headline $model
 *
 */
class Headline extends Section
{

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $alias = false;

    public function getIcon()
    {
        return parent::getIcon();
    }

    public function getTitle()
    {
        return 'Новостной заголовок';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info')
            ->setOrder([[0, 'desc']])
            ->paginate(10);

        $display->setColumns([
            AdminColumn::text('id', 'ID')->setWidth('100px'),
            AdminColumn::custom('Новостная строка', function ($model) {
                return $model->title;
            })->setHtmlAttribute('class', 'text-left'),

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
        $display = AdminForm::panel();

        $display->setItems([
            AdminFormElement::wysiwyg('title', 'Новостная строка', 'simplemde')
                ->setHtmlAttributes(['placeholder' => 'Новостная строка'])
                ->setValidationRules(['required', 'string', 'between:1,5000']),
        ]);

        return $display;
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
