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
    protected $title = 'Секции';

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

            AdminColumn::text('id', 'ID')
                ->setWidth('100px')
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
            AdminColumn::custom('Количество тем', function ($model) {
                return $model->topicsCount();
            })
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
            \AdminColumnEditable::checkbox('bot', 'Да', 'Нет')
                ->setWidth('50px')
                ->setLabel('Бот')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('description', 'Описание')
                ->setHtmlAttribute('class', 'text-left'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('forumsectionstables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->paginate(5)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setHtmlAttribute('class', 'text-center');


        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show();
        $control->addButton($buttonShow);

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
                ->setHtmlAttribute('placeholder', 'Название')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $title = AdminFormElement::text('title', 'Имя:')
                ->setHtmlAttribute('placeholder', 'Имя')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $position = AdminFormElement::number('position', 'Позиция:')
                ->setHtmlAttribute('placeholder', 'Позиция')
                ->setStep('1')
                ->setMin('0')
                ->setValidationRules([
                    'required',
                    'min:0',
                ]),
            $description = AdminFormElement::textarea('description', 'Описание:')
                ->setHtmlAttribute('placeholder', 'Описание')
                ->setValidationRules([
                    'required',
                    'max:255',
                ]),
            $bot_script = AdminFormElement::textarea('bot_script', 'Скрип бота')
                ->setHtmlAttribute('placeholder', 'Скрип бота')
                ->setValidationRules([
                    'string',
                    'nullable',
                    'max:5000',
                ]),
            AdminFormElement::checkbox('is_active', 'Активный')
                ->setValidationRules(['boolean',]),
            AdminFormElement::checkbox('is_general', 'Основной')
                ->setValidationRules(['boolean',]),
            AdminFormElement::checkbox('bot', 'Бот')
                ->setValidationRules(['boolean',]),
            AdminFormElement::checkbox('user_can_add_topics', 'Пользователь может добавлять')
                ->setValidationRules(['boolean',]),

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

    public function show()
    {
        $link = new ControlLink(function ($model) {
            $url = asset('admin/forum_topics');

            return $url.'?forum_section_id='.$model->getKey();
        }, 'Просмотреть', 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
