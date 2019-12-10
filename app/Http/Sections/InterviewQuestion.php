<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Exception;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Form\FormPanel;
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
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info table-sm text-center ')
            ->with(['answers', 'userAnswers'])
            ->setOrder([[0, 'desc']])
            ->paginate(10);

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
     * @param $display
     *
     * @return ControlLink
     */
    public function show($display)
    {

        $link = new ControlLink(function (
            Model $model
        ) {
            $id  = $model->getKey();
            $url = asset("admin/interview_questions/$id/show");

            return $url;
        }, function (Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

    /**
     * @return FormPanel
     * @throws Exception
     */
    public function onCreate()
    {
        return $this->onEdit('');
    }

    /**
     * @param $id
     *
     * @return FormPanel
     * @throws Exception
     */
    public function onEdit($id)
    {

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
                        AdminFormElement::hasMany('answers', [
                            AdminFormElement::text('answer')
                                ->setHtmlAttribute('placeholder',
                                    'Вариант ответа')
                                ->setHtmlAttribute('maxlength', '255')
                                ->setHtmlAttribute('minlength', '1')
                                ->setValidationRules([
                                    'required', 'string', 'between:1,255',
                                ]),
                        ]),
                    ];
                })
        );

        return $form;
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

}
