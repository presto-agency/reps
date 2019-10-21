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
 * @property \App\Models\Headline $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
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
        $display = AdminDisplay::datatablesAsync();
        $display->setHtmlAttribute('class', 'table-info table-sm');
        $display->paginate(10);

        $display->setApply(function ($query) {
            $query->orderBy('id', 'asc');
        });

        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')->setWidth('50px'),

            $title = AdminColumn::custom('Новостная строка', function ($model) {
                return $model->title;
            })->setHtmlAttribute('class', 'text-left'),

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
        $display = AdminForm::panel();

        $display->setItems([
            $title = AdminFormElement::wysiwyg('title', 'Новостная строка', 'simplemde')
                ->setHtmlAttributes(['placeholder' => 'Новостная строка'])
                ->setValidationRules(['required', 'string', 'between:1,1000']),
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
