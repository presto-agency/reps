<?php

namespace App\Http\Sections;

use AdminFormElement;
use AdminForm;
use AdminColumnEditable;
use AdminDisplay;
use AdminColumn;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ForumSections
 *
 * @property \App\Models\ForumSection $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ForumSections extends Section
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
//        return parent::getTitle();
        return 'Разделы форума';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
//            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->setActions([
                AdminColumn::action('export', 'Export')->setIcon('fa fa-share')->setAction('#'),
            ])
            ->paginate(50);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'asc');
        });

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),
            $name = AdminColumn::text('name', 'Name')
                ->setWidth('50px'),
            $title = AdminColumn::text('title', 'Display Name')
                ->setWidth('60px'),
            $position = AdminColumn::text('position', 'Position')
                ->setWidth('50px'),
            $description = AdminColumn::text('description', 'Description')
                ->setWidth('50px'),
            $quantity = AdminColumn::count('topics', 'Quantity topics')
                ->setWidth('50px'),
            /*$quantity = AdminColumn::custom('Quantity topics', function(\Illuminate\Database\Eloquent\Model $model) {
                return $model->topics()->count();
            })->setWidth('50px'),*/
            $isActive = AdminColumnEditable::checkbox('is_active','Yes', 'No')
                ->setLabel('Active'),
            $isGeneral = AdminColumnEditable::checkbox('is_general','Yes', 'No')
                ->setLabel('General'),
            $userCanAddTopics = AdminColumnEditable::checkbox('user_can_add_topics','Yes', 'No')
                ->setLabel('User can add'),

        ]);

        $control = $display->getColumns()->getControlColumn();

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $url = url('admin/forum_topics');
            return $url.'?forum_section_id='.$model->getKey(); // Генерация ссылки
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return $model->title . ' (' . $model->topics()->count() . ')'; // Генерация текста на кнопке
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        $control->addButton($link);

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
            $name = AdminFormElement::text('name', 'Name')
                ->setValidationRules(['required', 'max:255']),
            $title = AdminFormElement::text('title', 'Display Name')
                ->setValidationRules(['required', 'max:255']),
            $position = AdminFormElement::number('position', 'Position')
                ->setValidationRules(['required', 'min:0']),
            $description = AdminFormElement::textarea('description', 'Description')
                ->setValidationRules(['required', 'max:255']),
            $isActive = AdminFormElement::checkbox('is_active', 'Active'),
            $isGeneral = AdminFormElement::checkbox('is_general', 'General'),
            $userCanAddTopics = AdminFormElement::checkbox('user_can_add_topics', 'User Can Add Topics'),

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

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }
}
