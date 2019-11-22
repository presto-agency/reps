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

            //            ->setSearchCallback(function($column, $query, $search){
            //              return $query->orWhere('name', 'like', '%'.$search.'%')
            //                           ->orWhere('created_at', 'like', '%'.$search.'%');
            //            })
            //            ->setOrderable(function($query, $direction) {
            //              $query->orderBy('created_at', $direction);
            //            })
            //          AdminColumn::boolean('name', 'On'),
            //          AdminColumn::text('created_at', 'Created / updated', 'updated_at')
            //            ->setWidth('160px')
            //            ->setOrderable(function($query, $direction) {
            //              $query->orderBy('updated_at', $direction);
            //            })
            //            ->setSearchable(false),
            AdminColumn::text('id', '#')->setWidth('50px'),
            AdminColumn::text('name', 'Название')
                ->setHtmlAttribute('class', 'text-left'),
            AdminColumn::text('title', 'Имя'),
            AdminColumn::text('position', 'Позиция')->setWidth('100px'),
            AdminColumn::count('topics', 'Количество тем')->setWidth('100px'),
            \AdminColumnEditable::checkbox('is_active', 'Да', 'Нет')
                ->setWidth('100px')
                ->setLabel('Активен'),
            \AdminColumnEditable::checkbox('is_general', 'Да', 'Нет')
                ->setWidth('100px')
                ->setLabel('Основной'),
            AdminColumn::text('description', 'Описание')
                ->setHtmlAttribute('class', 'text-left'),
        ];

        $display = AdminDisplay::datatables()
            ->setName('forumSectionsTables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(false)
            ->with(['topics'])
            ->paginate(5)
            ->setColumns($columns)
            ->setHtmlAttribute('class',
                'table-info table-hover th-center text-center');


        //        $display->setColumnFilters([
        //          AdminColumnFilter::select()
        //            ->setModelForOptions(\App\Models\ForumSection::class, 'name')
        //            ->setLoadOptionsQueryPreparer(function($element, $query) {
        //              return $query;
        //            })
        //            ->setDisplay('name')
        //            ->setColumnName('name')
        //            ->setPlaceholder('All names'),
        //        ]);

        //        $display->getColumnFilters()->setPlacement('panel.heading');

        $control = $display->getColumns()->getControlColumn();
        $control->addButton($this->lincShow());

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
                'Пользователь добавляет'),

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
