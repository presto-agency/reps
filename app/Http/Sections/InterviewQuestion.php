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
//        $display->with('answers', 'userAnswers');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'asc');
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
        self::setIVAAttributes($id, true);

        $form = AdminForm::panel();

        $form->setItems(
//            AdminFormElement::html("<div>hi</div>"),
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        $question = AdminFormElement::text('question', 'Вопрос')
                            ->setHtmlAttribute('placeholder', 'Вопрос')
                            ->setHtmlAttribute('maxlength', '255')
                            ->setHtmlAttribute('minlength', '1')
                            ->setValidationRules(['required', 'string', 'between:1,255']),
                        $active = AdminFormElement::checkbox('active', 'Активный')
                            ->setValidationRules(['nullable', 'boolean']),
                        $active = AdminFormElement::checkbox('for_login', 'Только для авторизированных'),
                    ];
                })->addColumn(function () {
                    return [
                        $answer = AdminFormElement::hidden('answers'),
                        AdminFormElement::view('admin.interviewQuestion.answers', $data = [], function ($instance) {
                            \Log::info($instance->toArray());
//                             $store = new InterviewVariantAnswerController;
                        })

//                        \View::make('admin.interviewQuestion.answers')->render(),
//                        $content = 'admin.InterviewQuestion.questionClone',
//                        \AdminFormElement::view($content)
                    ];
                })

        );

//        return view('admin.interviewQuestion.questionClone');
        return $form;
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onCreate()
    {
        return $this->onEdit('');
//        $form = AdminForm::panel();
//        $form->setItems(
//            AdminFormElement::columns()
//                ->addColumn(function () {
//                    return [
//
//                        $question = AdminFormElement::text('question', 'Вопрос')
//                            ->setHtmlAttribute('placeholder', 'Вопрос')
//                            ->setHtmlAttribute('maxlength', '255')
//                            ->setHtmlAttribute('minlength', '1')
//                            ->setValidationRules(['required', 'string', 'between:1,255']),
//
//                        $active = AdminFormElement::checkbox('active', 'Активный')
//                            ->setHtmlAttribute('checked', 'checked')
//                            ->setDefaultValue(true)
//                            ->setValidationRules(['nullable', 'boolean']),
//
//                        $active = AdminFormElement::checkbox('for_login', 'Только для авторизированных')
//                            ->setDefaultValue(false)
//                            ->setValidationRules(['nullable', 'boolean']),
//                    ];
//                })->addColumn(function () {
//                    return [
//                        $answer = AdminFormElement::hidden('answer'),
////                        \View::make('admin.InterviewQuestion.questionClone')->render(),
//                    ];
//                })
//        );
//
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
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show($display)
    {

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $id = $model->getKey();
            $url = url("admin/interview_questions/$id/show");
            return $url;
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

    public static function setIVAAttributes($id, $edit)
    {
        InterviewVariantAnswerComposer::$id = $id;
        InterviewVariantAnswerComposer::$method = $edit;
    }
}
