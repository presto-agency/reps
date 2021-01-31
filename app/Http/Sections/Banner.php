<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Banner
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\Banner $model
 *
 */
class Banner extends Section implements Initializable
{

    protected $model;
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */

    /**
     * @var string
     */
    protected $alias;

    public function getIcon()
    {
        return 'fa fa-film';
    }

    public function getTitle()
    {
        return 'Banners';
    }

    public function initialize()
    {
        $this->addToNavigation(7);
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
            ->paginate(10);

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')
                ->setWidth('100px'),

            $image = AdminColumn::image('image', 'Image'),

            $title = AdminColumn::text('title', 'Title')
                ->setWidth('300px'),

            $url = AdminColumn::text('url_redirect', 'URL'),

            $isActive = AdminColumnEditable::checkbox('is_active', 'Yes', 'No')
                ->setLabel('Active')->setWidth('75px'),

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
            $image = AdminFormElement::image('image', 'Image')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'.PathHelper::checkUploadsFileAndPath("/banners", $this->imageOldPath);
                })
                ->setValidationRules([
                    'required',
                    'mimes:jpeg,png,jpg',
                    'max:5120',
                ]),
            $title = AdminFormElement::text('title', 'Title')->required(),
            $url = AdminFormElement::text('url_redirect', 'URL')->required(),
            $isActive = AdminFormElement::checkbox('is_active', 'Active'),
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
