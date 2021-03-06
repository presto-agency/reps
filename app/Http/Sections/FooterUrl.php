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
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\FooterUrl $model
 *
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
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center ')
            ->setOrder([[0, 'desc']])
            ->paginate(10);


        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')->setWidth('100px'),

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
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $display = AdminForm::panel();

        $display->setItems([

            $title = AdminFormElement::text('title', 'Title')
                ->setHtmlAttribute('placeholder', 'Title')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required', 'string', 'between:1,255']),

            $url = AdminFormElement::text('url', 'Url')
                ->setHtmlAttribute('placeholder', 'Url')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required', 'string', 'between:1,255']),

            $approved = AdminFormElement::checkbox('approved', 'Подтвердить'),

        ]);

        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        $display = AdminForm::panel();

        $display->setItems([

            $title = AdminFormElement::text('title', 'Title')
                ->setHtmlAttribute('placeholder', 'Title')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required', 'string', 'between:1,255']),

            $url = AdminFormElement::text('url', 'Url')
                ->setHtmlAttribute('placeholder', 'Url')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required', 'string', 'between:1,255']),

            $approved = AdminFormElement::checkbox('approved', 'Подтвердить')
                ->setHtmlAttribute('checked', 'checked')
                ->setDefaultValue(true),

        ]);

        return $display;
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
