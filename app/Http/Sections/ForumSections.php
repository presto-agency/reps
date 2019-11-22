<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Section;

/**
 * Class ForumSections
 *
 * @property \App\Models\ForumSection $model
 */
class ForumSections extends Section
{

    /**
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
        $columns = [

            AdminColumn::text('id', '#')
                ->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Название')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('title', 'Имя')
                ->setWidth('100px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('position', 'Позиция')
                ->setWidth('80px')
                ->setHtmlAttribute('class', 'text-center'),
            \AdminColumnEditable::checkbox('is_active', 'Да', 'Нет')
                ->setWidth('90px')
                ->setLabel('Активный')
                ->setHtmlAttribute('class', 'text-center'),
            \AdminColumnEditable::checkbox('is_general', 'Да', 'Нет')
                ->setWidth('90px')
                ->setLabel('Основной')
                ->setHtmlAttribute('class', 'text-center'),
            \AdminColumnEditable::checkbox('user_can_add_topics', 'Да', 'Нет')
                ->setWidth('120px')
                ->setLabel('Пользователь может добавляь')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('description', 'Описание')
                ->setHtmlAttribute('class', 'text-left'),
        ];

        //            $position = AdminColumn::text('position', 'Позиция')
        //                ->setWidth('50px'),
        //            $quantity = AdminColumn::count('topics', 'Количество тем')
        //                ->setWidth('50px'),
        //            $isActive = AdminColumnEditable::checkbox('is_active', 'Да', 'Нет')
        //                ->setLabel('Активный'),
        //            $isGeneral = AdminColumnEditable::checkbox('is_general', 'Да',
        //                'Нет')
        //                ->setLabel('Основной'),
        //            $userCanAddTopics
        //                = AdminColumnEditable::checkbox('user_can_add_topics', 'Да',
        //                'Нет')
        //                ->setLabel('Пользователь добавляет'),
        //            $description = AdminColumn::text('description', 'Описание')
        //                ->setHtmlAttribute('class', 'text-left')
        //                ->setWidth('200px'),


        $display = AdminDisplay::datatables()
            ->setName('forumsectionstables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->paginate(5)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');

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
            $name = AdminFormElement::text('name', 'Название:')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $title = AdminFormElement::text('title', 'Имя:')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $position = AdminFormElement::number('position', 'Позиция:')
                ->setValidationRules([
                    'required',
                    'min:0',
                ]),
            $description = AdminFormElement::textarea('description',
                'Описание:')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $isActive = AdminFormElement::checkbox('is_active', 'Активный'),
            $isGeneral = AdminFormElement::checkbox('is_general', 'Основной'),
            $userCanAddTopics
                = AdminFormElement::checkbox('user_can_add_topics',
                'Пользователь может добавлять'),

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

    public function lincShow()
    {
        $link = new ControlLink(function ($model) {
            $url = asset('admin/forum_topics');

            return $url.'?forum_section_id='.$model->getKey();
        }, function ($model) {
            //            return $model->title . ' (' . $model->topicsCount() . ')'; // Генерация текста на кнопке
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
