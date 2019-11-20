<?php

namespace App\Http\Sections;

use AdminFormElement;
use AdminForm;
use AdminColumnEditable;
use AdminDisplay;
use AdminColumn;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ChatSmile
 *
 * @property \App\Models\ChatSmile $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ChatSmile extends Section
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

    public function getIcon()
    {
        return parent::getIcon();
    }

    public function getTitle()
    {
        return 'Smiles';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->paginate(50);
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });


        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px'),

            $image = AdminColumn::image(function ($model) {
                    if (!empty($model->image) && PathHelper::checkFileExists($model->image)) {
                        return asset($model->image);
                    }
                })->setWidth('100px'),
            $title = AdminColumn::text('comment', 'Comment')
                ->setWidth('60px'),

            $position = AdminColumn::text('charactor', 'Charactor')
                ->setWidth('50px'),

            $date = AdminColumn::datetime('created_at', 'Date')->setFormat('Y-m-d')->setWidth('20px'),

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
        $form->setItems([
            /*Init FormElement*/
            $image = AdminFormElement::image('image', 'Image')
                ->setUploadPath(function (UploadedFile $file){
                    return 'storage' . PathHelper::checkUploadsFileAndPath("/chat/smiles",$this->getModelValue()->getAttribute('image'));
                })
                ->setValidationRules([
                    'required',
                    'max:2048'
                ])
                ->setUploadSettings([
                    'orientate' => [],
                    'resize'    => [
                        24,
                        24,
                        function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        }
                    ],
                ]),
            $comment = AdminFormElement::text('comment', 'Comment'),
            $charactor = AdminFormElement::text('charactor', 'Charactor')->required(),
            $user = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),

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
