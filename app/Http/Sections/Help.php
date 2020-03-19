<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Help
 *
 * @property \App\Models\Help $model
 */
class Help extends Section implements Initializable
{

    /**
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Подсказки';

    /**
     * @var string
     */
    protected $alias;

    public function getIcon()
    {
        return 'fa fa-question-circle';
    }

    public function initialize()
    {
    }


    /**
     * @return \SleepingOwl\Admin\Display\DisplayTable
     */
    public function onDisplay()
    {
        return AdminDisplay::table()->setHtmlAttribute('class', 'table-primary')
            ->setColumns([
                AdminColumn::text('id', '#')->setWidth('30px'),
                AdminColumn::link('display_name', 'Настройка')->setWidth('200px'),
                AdminColumn::text('value', 'Значение'),
                AdminColumn::text('description', 'Описание'),
            ])->paginate(20);
    }

    /**
     * @param $id
     *
     * @return \SleepingOwl\Admin\Form\FormPanel
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::text('display_name', 'Название настройки')->required(),
            AdminFormElement::wysiwyg('value', 'Значение')
                ->setHtmlAttributes(['placeholder' => 'Текст'])
                ->setValidationRules(['required', 'string', 'between:1,1000']),
            AdminFormElement::text('description', 'Описание подсказки')->required(),
            AdminFormElement::text('id', 'ID')->setReadonly(1),
            AdminFormElement::text('created_at')->setLabel('Создано')->setReadonly(1),

        ]);
    }

//    /**
//     * @return \SleepingOwl\Admin\Form\FormPanel
//     */
//    public function onCreate()
//    {
//        return AdminForm::panel()->addBody([
//            AdminFormElement::text('display_name', 'Название настройки')->required(),
//            AdminFormElement::text('key', 'Постоянный системный код')->required()->unique(),
//            AdminFormElement::wysiwyg('value', 'Значение')
//                ->setHtmlAttributes(['placeholder' => 'Текст'])
//                ->setValidationRules(['required', 'string', 'between:1,1000']),
//            AdminFormElement::text('description', 'Описание подсказки')->required(),
//
//        ]);
//    }


}
