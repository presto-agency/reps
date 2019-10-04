<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class InterviewQuestionObserver
 *
 * @property \App\Models\InterviewQuestion $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
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
        $display->with('answers', 'userAnswers');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')->setWidth('100px'),

            $question = AdminColumn::text('question', 'Title')->setWidth('100px'),

            $active = AdminColumnEditable::checkbox('active')->setLabel('Active')
                ->setWidth(100),

            $for_login = AdminColumnEditable::checkbox('for_login')->setLabel('For login only')
                ->setWidth(100),

            $count_answer = AdminColumn::count('answers', 'Количество вариатов')
                ->setWidth(100),

            $count_answerUsers = AdminColumn::count('userAnswers', 'Количество ответов')
                ->setWidth(100),


        ]);
        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);
        return $display;
    }

    /**
     * @param $id
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onEdit($id)
    {
        $form = AdminForm::panel();


        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [

                        $question = AdminFormElement::text('question', 'Question')
                            ->setValidationRules(['required', 'string', 'max:255']),

                        $active = AdminFormElement::checkbox('active', 'Active'),

                        $active = AdminFormElement::checkbox('for_login', 'For login only'),

                    ];
                })->addColumn(function () {
                    return [

                        $answer = AdminFormElement::hidden('answer'),
                        view('admin.InterviewQuestion.questionClone'),

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

        return $this->onEdit(null);

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
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show($display)
    {

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $url = url('admin/interview_questions/show');
            return $url . '/' . $model->getKey();
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }
}
