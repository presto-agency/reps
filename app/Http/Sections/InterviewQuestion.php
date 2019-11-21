<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Http\ViewComposers\admin\InterviewVariantAnswerComposer;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Section;

/**
 * Class InterviewQuestionObserver
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\InterviewQuestion $model
 *
 */
class InterviewQuestion extends Section
{

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $alias = false;

    public function getIcon()
    {
        return parent::getIcon();
    }

    public function getTitle()
    {
        return 'Опросы';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync();
        $display->setHtmlAttribute('class', 'table-info table-sm text-center ');
        $display->paginate(10);
        $display->with(['answers', 'userAnswers']);

        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });

        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')
                ->setWidth('100px'),

            $question = AdminColumn::text('question', 'Вопрос')
                ->setWidth('100px'),

            $active = AdminColumnEditable::checkbox('active')
                ->setLabel('Активный')
                ->setWidth(100),

            $for_login = AdminColumnEditable::checkbox('for_login')
                ->setLabel('Только для авторизированных')
                ->setWidth(100),

            $count_answer = AdminColumn::count('answers', 'Количество вариатов')
                ->setWidth(100),

            $count_answerUsers = AdminColumn::count('userAnswers',
                'Количество ответов')
                ->setWidth(100),


        ]);
        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);

        return $display;
    }

    /**
     * @param $id
     *
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onEdit($id)
    {
//        InterviewVariantAnswerComposer::$method = 'edit';
//        InterviewVariantAnswerComposer::$id     = $id;

        $form = AdminForm::panel();

        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $question = AdminFormElement::text('question', 'Вопрос')
                            ->setHtmlAttribute('placeholder', 'Вопрос')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules([
                                'required', 'string', 'between:1,255',
                            ]),
                        $active = AdminFormElement::checkbox('active',
                            'Активный')
                            ->setValidationRules(['boolean']),
                        $active = AdminFormElement::checkbox('for_login',
                            'Только для авторизированных')
                        ,
                    ];
                })->addColumn(function () {
                    return [
                        AdminFormElement::hasMany('answers',[
                            AdminFormElement::text('answer'),
                        ])
                    ];
                })
        );

        return $form;
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onCreate()
    {
//        InterviewVariantAnswerComposer::$method = 'create';

        return $this->onEdit('');
//        $form = AdminForm::panel();
//
//        $form->setItems(
//            AdminFormElement::columns()
//                ->addColumn(function () {
//                    return [
//                        $question = AdminFormElement::text('question', 'Вопрос')
//                            ->setHtmlAttribute('placeholder', 'Вопрос')
//                            ->setHtmlAttribute('maxlength', '255')
//                            ->setHtmlAttribute('minlength', '1')
//                            ->setValidationRules([
//                                'required', 'string', 'between:1,255',
//                            ]),
//                        $active = AdminFormElement::checkbox('active',
//                            'Активный')
//                            ->setValidationRules(['boolean'])
//                            ->setHtmlAttribute('checked', 'checked')
//                            ->setDefaultValue(true),
//                        $for_login = AdminFormElement::checkbox('for_login',
//                            'Только для авторизированных')
//                            ->setValidationRules(['boolean'])
//                            ->setDefaultValue(false),
//                    ];
//                })->addColumn(function () {
//                    return [
//                        AdminFormElement::hasMany('answers',[
//                            AdminFormElement::text('answer'),
//                        ])
//                    ];
//                })
//
//        );
//        return $form;
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {

    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    /**
     * @param $display
     *
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show($display)
    {

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (
            \Illuminate\Database\Eloquent\Model $model
        ) {
            $id  = $model->getKey();
            $url = asset("admin/interview_questions/$id/show");

            return $url;
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
