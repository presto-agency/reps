<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Models\Tag;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ChatPicture
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\ChatPicture $model
 *
 */
class ChatPicture extends Section
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
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->setOrder([[0, 'desc']])
            ->paginate(10);


        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('50px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('100px'),

            $image = AdminColumn::image(function ($model) {
                if ( ! empty($model->image)
                    && PathHelper::checkFileExists($model->image)
                ) {
                    return asset($model->image);
                }
            })->setWidth('100px'),
            $comment = AdminColumn::text('comment', 'Comment')
                ->setWidth('150px'),

            $charactor = AdminColumn::text('charactor', 'Charactor')
                ->setWidth('50px'),

            $tags = AdminColumn::lists('tags.display_name', 'Tags'),
            /*$tag = AdminColumn::text('tag', 'Tag')
                ->setWidth('50px')
                ->append(
                    AdminColumn::filter('tag')
                ),*/
            $date = AdminColumn::datetime('created_at', 'Date')
                ->setFormat('Y-m-d')->setWidth('100px'),

        ]);

        $display->setColumnFilters([
            null,
            null,
            null,
            null,
            AdminColumnFilter::text()->setOperator('contains')
                ->setPlaceholder('Charactor'),
            AdminColumnFilter::text()->setOperator('equal')
                ->setPlaceholder('Tag'),
            null,
        ]);

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
        $getData = $this->getModel()->select('image')->find($id);
        if ($getData) {
            $this->imageOldPath = $getData->image;
        }
        $form = AdminForm::panel();
        $form->setItems([
            /*Init FormElement*/
            $image = AdminFormElement::image('image', 'Image')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'
                        .PathHelper::checkUploadsFileAndPath("/chat/pictures",
                            $this->imageOldPath);
                })
                ->setValidationRules([
                    'required',
                    'max:2048',
                ])
                ->setUploadSettings([
                    'orientate' => [],
                    'resize'    => [
                        120,
                        120,
                        function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        },
                    ],
                ]),
            $comment = AdminFormElement::text('comment', 'Comment'),
            $charactor = AdminFormElement::text('charactor', 'Charactor')
                ->required(),
            $tag = AdminFormElement::multiselect('tags', 'Tags', Tag::class)
                ->setDisplay('display_name')->required(),
            $user = AdminFormElement::hidden('user_id')
                ->setDefaultValue(auth()->user()->id),

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
