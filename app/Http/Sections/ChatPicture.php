<?php

namespace App\Http\Sections;

use AdminFormElement;
use AdminForm;
use AdminColumnEditable;
use AdminDisplayFilter;
use AdminDisplay;
use AdminColumn;
use AdminColumnFilter;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ChatPicture
 *
 * @property \App\Models\ChatPicture $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ChatPicture extends Section
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
//            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            /*->setActions([
                AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction('#'),
            ])*/
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'asc');
        });

        $display->setFilters([
            AdminDisplayFilter::field('tag')
        ]);

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px'),

            $image = AdminColumn::image('image', 'Image')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('100px'),

            $comment = AdminColumn::text('comment', 'Comment')
                ->setWidth('60px'),

            $charactor = AdminColumn::text('charactor', 'Charactor')
                ->setWidth('50px'),

            $tag = AdminColumn::text('tag', 'Tag')
                ->setWidth('50px')
                ->append(
                    AdminColumn::filter('tag')
                ),
            $date = AdminColumn::datetime('created_at', 'Date')->setFormat('Y-m-d')->setWidth('20px'),

        ]);

        $display->setColumnFilters([
            null,
            null,
            null,
            null,
            AdminColumnFilter::text()->setOperator('contains')->setPlaceholder('Charactor'),
//            AdminColumnFilter::text()->setPlaceholder('News')->setColumnName('news'),
            /*AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::text()->setPlaceholder('From')
            )->setTo(
                AdminColumnFilter::text()->setPlaceholder('To')
            ),
            AdminColumnFilter::range()->setFrom(
                AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d.m.Y')
            )->setTo(
                AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d.m.Y')
            ),*/
//            AdminColumnFilter::select(ForumTopic::class, 'news')->setPlaceholder('News')->setColumnName('news'),
            null,
            null,
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
            $comment = AdminFormElement::text('comment', 'Comment'),
            $charactor = AdminFormElement::text('charactor', 'Charactor')->required(),
            $tag = AdminFormElement::text('tag', 'Tag')->required(),
            $user = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),

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
