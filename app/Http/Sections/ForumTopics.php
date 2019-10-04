<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use AdminColumnFilter;
use App\Models\ForumSection;
use App\Models\ForumTopic;
use App\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
//use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class ForumTopics
 *
 * @property \App\Models\ForumTopic $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ForumTopics extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
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
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-group';
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
            ->paginate(10);
        $display->setFilters([
            AdminDisplayFilter::related('forum_section_id')->setModel(ForumSection::class),
            AdminDisplayFilter::related('user_id')->setModel(User::class),
        ]);

        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),
            $id = AdminColumn::text('title', 'Title')
                ->setWidth('15px'),
            $section = AdminColumn::text('forumSection.title', 'Section')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px')
                ->append(
                    AdminColumn::filter('forum_section_id')
                ),
            $author = AdminColumn::text('author.name', 'Author')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px')
                ->append(
                    AdminColumn::filter('user_id')
                ),
            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth('30px'),
            $comments_count = AdminColumn::text('comments_count', 'Comments')
                ->setWidth('15px'),
            $reviews = AdminColumn::text('reviews', 'Reviews')
                ->setWidth('30px'),

            $news = AdminColumnEditable::checkbox('news','Yes', 'No')->setLabel('News'),

            /*$activity_at = AdminColumn::datetime('activity_at', 'Last activity')
                ->setFormat('d-m-Y')
                ->setWidth('50px'),*/
        ]);

        $control = $display->getColumns()->getControlColumn();

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $url = url('admin/forum_topics/show');
            return $url.'/'.$model->getKey(); // Генерация ссылки
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return $model->title; // Генерация текста на кнопке
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        $control->addButton($link);

        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setOperator('contains')->setPlaceholder('Title'),
            AdminColumnFilter::select(ForumSection::class, 'title')->setPlaceholder('Section')->setColumnName('forum_section_id'),
            null,
            null,
            null,
            null,
            null,
        ]);
        $display->getColumnFilters()->setPlacement('table.header');

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

        $form->setItems([
            /*Init FormElement*/

            $sections = AdminFormElement::select('forum_section_id', 'Section', ForumSection::class)->setDisplay('title')->required(),

            $title = AdminFormElement::text('title', 'Title')
                ->setValidationRules(['required', 'max:255']),
            $preview_img = AdminFormElement::image('preview_img', 'Preview images'),
            $preview_content = AdminFormElement::wysiwyg('preview_content', 'Preview', 'simplemde')->disableFilter(),
            $content = AdminFormElement::wysiwyg('content', 'Content', 'simplemde')->disableFilter(),
            $start_on = AdminFormElement::date('start_on', 'Publish from')->setFormat('Y-m-d')->required(),
            $news = AdminFormElement::checkbox('news', 'Display in the news'),
            $author = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),

            $rating = AdminFormElement::hidden('rating')->setDefaultValue(0),

        ]);
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
