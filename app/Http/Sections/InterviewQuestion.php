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
        return parent::getTitle();
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync();
        $display->setHtmlAttribute('class', 'table-info table-sm text-center ');
        $display->paginate(10);

        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\InterviewQuestion::class),
            AdminDisplayFilter::related('active')->setModel(\App\Models\InterviewQuestion::class),
        ]);

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')->setWidth('100px'),
            $question = AdminColumn::text('question', 'Title')->setWidth('100px'),
            $active = AdminColumnEditable::checkbox('active')->setLabel('Active')
                ->append(AdminColumn::filter('Active'))
                ->setWidth(100),
            $count_answer = AdminColumn::text('count_answer', 'Answers')->setWidth('100px'),

            $for_login = AdminColumnEditable::checkbox('for_login')->setLabel('For login only')
                ->append(AdminColumn::filter('approved'))
                ->setWidth(100),
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
                        /*Костыль с инпутом..:(*/

                        $answer = AdminFormElement::hidden('answer'),
                        view('admin.InterviewQuestion.questionClone'),

                    ];
                })
        );


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

    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    public function store($id)
    {
        dd($id, request());
        parent::updating($id);
        // remove if unused
    }
}
