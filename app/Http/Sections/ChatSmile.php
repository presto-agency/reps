<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ChatSmile
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\ChatSmile $model
 *
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
            ->setOrder([[0, 'desc']])
            ->paginate(50);


        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('15px'),

            $user = AdminColumn::text('user.name', 'User')
                ->setHtmlAttribute('class', 'hidden-sm hidden-xs hidden-md')
                ->setWidth('50px'),

            $image = AdminColumn::image(function ($model) {
                return $model->imageOrDefault();
            })->setLabel('Image')->setWidth('100px'),
            $title = AdminColumn::text('comment', 'Comment')
                ->setWidth('60px'),

            $position = AdminColumn::text('charactor', 'Charactor')
                ->setWidth('50px'),

            $date = AdminColumn::datetime('created_at', 'Date')
                ->setFormat('Y-m-d')->setWidth('20px'),

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
            $image = AdminFormElement::file('image', 'Image')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'.PathHelper::checkUploadsFileAndPath("/chat/smiles", $this->imageOldPath);
                })
                ->setValidationRules([
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,gif',
                    'max:2048',
                ]),
            $comment = AdminFormElement::text('comment', 'Comment'),
            $charactor = AdminFormElement::text('charactor', 'Charactor')
                ->required(),
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
