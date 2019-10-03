<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminSection;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Form\Buttons\FormButton;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Form\FormElements;
use SleepingOwl\Admin\Section;


/**
 * Class Footer
 *
 * @property \App\Models\Footer $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
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
            ->setHtmlAttribute('class', 'table-info text-center ')
            ->paginate(1);


        $display->setColumns([

            $title = AdminColumn::text('title', 'Title')
                ->setWidth(200),

            $text = AdminColumn::text('text', 'Text'),

            $position = AdminColumn::text('position', 'Position')
                ->setWidth(100),

            $approved = AdminColumnEditable::checkbox('approved')
                ->setLabel('Approved')
                ->setWidth(100),
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

            $title = AdminFormElement::text('title', 'Title')
                ->setValidationRules(['required', 'string', 'max:255']),

            $text = AdminFormElement::wysiwyg('text', 'Text', 'simplemde')
                ->setValidationRules(['required', 'string', 'max:255']),

            $email = AdminFormElement::text('email', 'Email')
                ->setHtmlAttribute('autocomplete', 'off')
                ->setHtmlAttribute('type', 'email')
                ->setValidationRules(['nullable', 'email', 'max:255']),

            $text = AdminFormElement::text('icq', 'Discord')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $approved = AdminFormElement::checkbox('approved', 'Approved'),

        ]);

        return $display;
    }
}
