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

/**
 * Class ChatSmile
 *
 * @property \App\Models\ChatSmile $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ChatSmile extends Section
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

    public function getIcon()
    {
        return parent::getIcon();
    }

    public function getTitle()
    {
        return 'Smiles';
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
            /*->setActions([
                AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction('#'),
            ])*/
            ->paginate(50);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'asc');
        });


        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px'),

            $image = AdminColumn::image('image', 'Image')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs foobar')
                ->setWidth('100px'),

            $title = AdminColumn::text('comment', 'Comment')
                ->setWidth('60px'),

            $position = AdminColumn::text('charactor', 'Charactor')
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
        $form = AdminForm::panel();
        $form->setItems([
            /*Init FormElement*/

            $image = AdminFormElement::image('image', 'Image')->required(),
            $comment = AdminFormElement::text('comment', 'Comment'),
            $charactor = AdminFormElement::text('charactor', 'Charactor')->required(),
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
