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
 * Class Footer
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\Footer $model
 *
 */
class Footer extends Section
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
     * @var bool
     */
    protected $alias = false;

    public function getIcon()
    {
        return 'fas fa-reply';
    }

    public function getTitle()
    {
        return 'Disclaimer';
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
            ->paginate(1);


        $display->setColumns([

            $text = AdminColumn::custom('Текст Footer', function ($model) {
                return $model->text;
            })->setHtmlAttribute('class', 'text-left'),

            $approved = AdminColumnEditable::checkbox('approved')
                ->setLabel('Подтвердить')
                ->setWidth(100),
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

            $text = AdminFormElement::wysiwyg('text', 'Текст Footer',
                'simplemde')
                ->setHtmlAttributes(['placeholder' => 'Текст'])
                ->setValidationRules(['required', 'string', 'between:1,1000']),

            $approved = AdminFormElement::checkbox('approved', 'Подтвердить'),


        ]);

        return $display;
    }

}
