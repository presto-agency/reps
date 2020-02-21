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
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Section;

/**
 * Class ForumTopics
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property ForumTopic $model
 *
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
    protected $title = 'Посты';

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
            ->with([
                'forumSection',
                'author',
                'comments',
            ])
            ->setDatatableAttributes(['bInfo' => true])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->setOrder([[0, 'desc']])
            ->paginate(10);
        $display->setFilters(
            AdminDisplayFilter::related('forum_section_id')
                ->setModel(ForumSection::class),
            AdminDisplayFilter::related('user_id')->setModel(User::class)
        );

        $display->setColumns([

            $id = AdminColumn::text('id', 'ID')
                ->setWidth('100px'),
            $title = AdminColumn::text(function ($model) {
                return clean($model->title);
            }, 'Название')->setFilterCallback(function ($column, $query, $search) {
                if ($search) {
                    return $query->where('title', 'LIKE', "%{$search}%");
                }
            })->setWidth('300px')
                ->setHtmlAttribute('class', 'text-left'),
            $section = AdminColumn::text('forumSection.title', 'Раздел')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('100px'),
            $author = AdminColumn::text('author.name', 'Автор')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('author',
                            function ($q) use ($search) {
                                return $q->where('name', 'LIKE', "%{$search}%");
                            });
                    }
                })->setWidth('100px'),
            $rating = AdminColumn::text('rating', 'Рейтинг')
                ->setWidth('100px'),
            $comments_count = AdminColumn::count('comments', 'Комментарии')
                ->setWidth('120px'),
            $reviews = AdminColumn::text('reviews', 'Просмотры')
                ->setWidth('100px'),
            $news = AdminColumnEditable::checkbox('news', 'Да', 'Нет')
                ->setWidth('100px')->setLabel('Новость'),
            $fixing = AdminColumnEditable::checkbox('fixing', 'Да', 'Нет')
                ->setWidth('150px')->setLabel('Зафиксировать<br>на главной'),
            $hide = AdminColumnEditable::checkbox('hide', 'Да', 'Нет')->setLabel('Скрыть'),

        ]);

        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);

        $display->setColumnFilters([
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('ID')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select(ForumSection::class, 'title')
                ->setHtmlAttributes(['style' => 'width: 100%'])
                ->setPlaceholder('Раздел')
                ->setColumnName('forum_section_id'),
            AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Автор')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            null,
            null,
            null,
            null,
            null,
            null,
        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    public $imageOldPath;

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $getData = $this->getModel()->select('preview_img')->find($id);
        if ($getData) {
            $this->imageOldPath = $getData->preview_img;
        }
        $form = AdminForm::panel();
        $form->setItems([
            /*Init FormElement*/
            $title = AdminFormElement::text('title', 'Название:')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setValidationRules([
                    'required',
                    'between:1,255',
                    'string',
                ]),
            $sections_id = AdminFormElement::select('forum_section_id', 'Раздел:', ForumSection::class)
                ->setValidationRules([
                    'required',
                    'exists:forum_sections,id',
                ])
                ->setDisplay('title'),
            $user_id = AdminFormElement::select('user_id', 'Автор')
                ->setOptions((new User())->pluck('name', 'id')->toArray())
                ->setValidationRules([
                    'nullable',
                    'exists:users,id',
                ]),
            $preview_img = AdminFormElement::image('preview_img', 'Загрузить картинку превью')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'.PathHelper::checkUploadsFileAndPath("/images/topics", $this->imageOldPath);
                })
                ->setValidationRules([
                    'nullable',
                    'max:2048',
                ]),
            $preview_content = AdminFormElement::wysiwyg('preview_content', 'Краткое содержание')
                ->setHtmlAttribute('placeholder', 'Краткое содержание')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,10000',
                ])
                ->disableFilter(),
            $content = AdminFormElement::wysiwyg('content', 'Содержание:')
                ->setHtmlAttribute('placeholder', 'Содержание')
                ->setValidationRules([
                    'required',
                    'string',
                    'between:3,50000',
                ])
                ->disableFilter(),
            $start_on = AdminFormElement::date('start_on', 'Опубликовать с:')
                ->setHtmlAttribute('placeholder',
                    Carbon::now()->format('Y-m-d'))
                ->setValidationRules(['nullable'])
                ->setFormat('Y-m-d'),
            $news = AdminFormElement::checkbox('news', 'Отображать в новостях')
                ->setValidationRules(['boolean']),
            $fixing = AdminFormElement::checkbox('fixing', 'Зафиксировать на главной')
                ->setValidationRules(['boolean']),
            $hide = AdminFormElement::checkbox('hide', 'Скрыть')
                ->setValidationRules(['boolean']),

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
     *
     * @return ControlLink
     */
    public function show($display)
    {
        $link = new ControlLink(function (Model $model) {
            return url('admin/forum_topics/'.$model->getKey().'/show');
        }, function (Model $model) {
            return $model->title;
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
