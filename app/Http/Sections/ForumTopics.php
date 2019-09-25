<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
//use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class ForumTopics
 *
 * @property \App\Models\ForumTopic $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ForumTopics extends Section
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
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-group';
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

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),
            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth('30px'),
            $comments_count = AdminColumn::text('comments_count', 'Comments')
                ->setWidth('15px'),
            $reviews = AdminColumn::text('reviews', 'Reviews')
                ->setWidth('30px'),

            $news = AdminColumnEditable::checkbox('news','Yes', 'No')->setLabel('News'),

            /*$activity_at = AdminColumn::datetime('activity_at', 'Last activity')
                ->setFormat('d-m-Y')
                ->setWidth('50px'),*/
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
        // remove if unused
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
