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
use App\Services\ServiceAssistants\PathHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
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
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(10);
        $display->setFilters([
            AdminDisplayFilter::related('forum_section_id')->setModel(ForumSection::class),
            AdminDisplayFilter::related('user_id')->setModel(User::class),
        ]);
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });
        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),
            $title = AdminColumn::text('title', 'Название')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('100px'),
            $section = AdminColumn::text('forumSection.title', 'Раздел')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px')
                ->append(AdminColumn::filter('forum_section_id')),
            $author = AdminColumn::text('author.name', 'Автор')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px')
                ->append(AdminColumn::filter('user_id')),
            $rating = AdminColumn::text('rating', 'Рейтинг')
                ->setWidth('30px'),
            $comments_count = AdminColumn::count('comments', 'Комментарии')
                ->setWidth('15px'),
            $reviews = AdminColumn::text('reviews', 'Просмотры')
                ->setWidth('30px'),
            $news = AdminColumnEditable::checkbox('news', 'Да', 'Нет')->setLabel('Новость'),

        ]);

        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);

        $display->setColumnFilters([
            null,
            AdminColumnFilter::text()->setOperator('contains')
                ->setHtmlAttributes(['style' => 'width: 100%'])
                ->setPlaceholder('Title'),
            AdminColumnFilter::select(ForumSection::class, 'title')
                ->setHtmlAttributes(['style' => 'width: 100%'])
                ->setPlaceholder('Section')
                ->setColumnName('forum_section_id'),
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
            $title = AdminFormElement::text('title', 'Title')
                ->setHtmlAttribute('placeholder', 'Title')
                ->setValidationRules(['required',
                                      'between:1,255',
                                      'string']),
            $sections = AdminFormElement::select('forum_section_id', 'Section', ForumSection::class)
                ->setValidationRules(['required',
                                      'exists:forum_topics,id'])
                ->setDisplay('title'),
            $preview_img = AdminFormElement::image('preview_img', 'Preview images')
                ->setUploadPath(function (UploadedFile $file) use ($id) {
                    $filePath = \App\Models\ForumTopic::where('id', $id)->value('preview_img');
                    return 'storage' . PathHelper::checkUploadsFileAndPath("/images/topics", $filePath);
                })
                ->setValidationRules(['nullable',
                                      'max:2048']),
            $preview_content = AdminFormElement::wysiwyg('preview_content', 'Preview')
                ->setValidationRules(['required',
                                      'string',
                                      'between:1,1000'])
                ->disableFilter(),
            $content = AdminFormElement::wysiwyg('content', 'Content')
                ->setValidationRules(['required',
                                      'string',
                                      'between:3,50000'])
                ->disableFilter(),
            $start_on = AdminFormElement::date('start_on', 'Publish from')
                ->setHtmlAttribute('placeholder', Carbon::now()->format('Y-m-d'))
                ->setValidationRules(['required'])
                ->setFormat('Y-m-d'),
            $news = AdminFormElement::checkbox('news', 'Display in the news'),
            $author = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),
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

    /**
     * @param $display
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show($display)
    {
        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $id = $model->getKey();
            $url = url("admin/forum_topics/$id/show");
            return $url; // Генерация ссылки
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return $model->title; // Генерация текста на кнопке
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }
}
