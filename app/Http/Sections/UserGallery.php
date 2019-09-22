<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminNavigation;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class UserGallery
 *
 * @property \App\Models\UserGallery $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserGallery extends Section implements Initializable
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

    public function initialize()
    {

        $page = AdminNavigation::getPages()->findById('parent-users');

        $page->addPage(
            $this->makePage(300)
        );

    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(false)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(50);

        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')
                ->setWidth('50px'),
            $picture = AdminColumn::image('picture', 'Picture')
                ->setHtmlAttribute('class', 'hidden-sm'),
            $user_id = AdminColumn::relatedLink('users.name', 'User name')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('100px'),
            $sign = AdminColumn::text('sign', 'Sign')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('200px'),
            $for_adults = AdminColumnEditable::checkbox('for_adults', '18+')
                ->setWidth('50px'),
            $negative_count = AdminColumn::text('negative_count', 'Negative Rating')
                ->setWidth('50px'),
            $positive_count = AdminColumn::text('positive_count', 'Positive Rating')
                ->setWidth('50px'),
            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth('50px'),
            $comments_count = AdminColumn::text('comments_count', 'Comments')
                ->setWidth('50px'),

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
            $name = AdminFormElement::text('sign', 'Sign')->setValidationRules(['required', 'max:255']),
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
