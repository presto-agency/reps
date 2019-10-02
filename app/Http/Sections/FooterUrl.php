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
 * Class FooterUrl
 *
 * @property \App\Models\FooterUrl $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class FooterUrl extends Section
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
    protected $alias = false;

    public function getIcon()
    {
        return 'fas fa-reply';
    }

    public function getTitle()
    {
        return parent::getTitle();
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info text-center ')
            ->paginate(10);


        $display->setColumns([

            $id = AdminColumn::text('id', 'ID'),

            $title = AdminColumn::text('title', 'Title')
                ->setWidth(200),

            $url = AdminColumn::text('url', 'Url'),

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

            $url = AdminFormElement::text('url', 'Url')
                ->setValidationRules(['required', 'string', 'max:255']),

            $approved = AdminFormElement::checkbox('approved', 'Approved'),

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
}