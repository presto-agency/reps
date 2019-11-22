<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Section;

/**
 * Class ForumSections
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property ForumSection $model
 *
 */
class ForumSections extends Section
{

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $alias;

    protected $title;

    public function getIcon()
    {
        return 'fa fa-group';
    }

    public function getTitle()
    {
        return 'Разделы форума';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->with(['topics'])
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->paginate(4);

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),
//            $name = AdminColumn::text('name', 'Название')
//                ->setWidth('50px'),
//            $title = AdminColumn::text('title', 'Имя')
//                ->setWidth('60px'),
//            $position = AdminColumn::text('position', 'Позиция')
//                ->setWidth('50px'),
//            $quantity = AdminColumn::count('topics', 'Количество тем')
//                ->setWidth('50px'),
//            $isActive = AdminColumnEditable::checkbox('is_active', 'Да', 'Нет')
//                ->setLabel('Активный'),
//            $isGeneral = AdminColumnEditable::checkbox('is_general', 'Да',
//                'Нет')
//                ->setLabel('Основной'),
//            $userCanAddTopics
//                = AdminColumnEditable::checkbox('user_can_add_topics', 'Да',
//                'Нет')
//                ->setLabel('Пользователь добавляет'),
//            $description = AdminColumn::text('description', 'Описание')
//                ->setHtmlAttribute('class', 'text-left')
//                ->setWidth('200px'),

        ]);

//        $control = $display->getColumns()->getControlColumn();
//        $control->addButton($this->lincShow());

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

    /**
     * @return void
     */
    public function onRestore($id)
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
