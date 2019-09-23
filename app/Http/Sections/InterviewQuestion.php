<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
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
        $display->setDatatableAttributes(['bInfo' => false]);
        $display->setHtmlAttribute('class', 'table-info table-hover text-center');
        $display->setDisplaySearch(true);
        $display->paginate(50);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'desc');
        });
        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')->setWidth('100px'),
            $question = AdminColumn::text('question', 'Title')->setWidth('100px'),
            $active = AdminColumn::custom('Active<br/>', function ($active) {
                return $active->active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('100px'),
            $count_answer = AdminColumn::text('count_answer', 'Answers')->setWidth('100px'),
            $for_login = AdminColumnEditable::checkbox('for_login', 'For login only')
                ->setWidth('100px'),
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
        $display = AdminForm::panel();

        $display->setItems([
            $question = AdminFormElement::text('question', 'Question')
                ->setValidationRules(['required', 'string', 'max:255']),
            $active = AdminFormElement::checkbox('active', 'Active'),
            $forLogin = AdminFormElement::radio('for_login', 'Who can see')
                ->setOptions(['0' => 'For login only', '1' => 'For all']),

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
