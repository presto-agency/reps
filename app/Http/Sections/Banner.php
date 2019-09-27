<?php

namespace App\Http\Sections;

use AdminFormElement;
use AdminForm;
use AdminColumnEditable;
use AdminDisplay;
use AdminColumn;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use SleepingOwl\Admin\Contracts\Initializable;

/**
 * Class Banner
 *
 * @property \App\Models\Banner $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Banner extends Section implements Initializable
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
//    protected $title;

    /**
     * @var string
     */
    protected $alias;

    public function getIcon()
    {
        return 'fa fa-film';
    }

    public function getTitle()
    {
        return 'Banners';
    }

    public function initialize()
    {
        $this->addToNavigation(7);
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
//            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'asc');
        });

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $image = AdminColumn::image('image', 'Image')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('100px'),

            $title = AdminColumn::text('title', 'Title')
                ->setWidth('60px'),

            $url = AdminColumn::text('url_redirect', 'URL')
                ->setWidth('50px'),

            $isActive = AdminColumnEditable::checkbox('is_active','Yes', 'No')
                ->setLabel('Active'),

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

            $image = AdminFormElement::image('image', 'Image')->required(),
            $title = AdminFormElement::text('title', 'Title')->required(),
            $url = AdminFormElement::text('url_redirect', 'URL')->required(),
            $isActive = AdminFormElement::checkbox('is_active', 'Active'),
        ]);
        return $form;

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