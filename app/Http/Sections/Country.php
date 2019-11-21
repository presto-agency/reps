<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Section;


/**
 * Class Country
 *
 * @package App\Http\Sections
 */
class Country extends Section
{

    public $imageOldPath;
    protected $checkAccess = false;

    protected $alias = false;

    public function getIcon()
    {
        return parent::getIcon();
    }


    public function getTitle()
    {
        return 'Страны';
    }

    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \Exception
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->paginate(50);

        $display->setHtmlAttribute('class', 'table-info table-sm text-center ');

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID'),
            $name = AdminColumn::text('name', 'Название'),
            $code = AdminColumn::text('code', 'Код')
                ->setHtmlAttribute('class', 'hidden-sm ')
                ->setHtmlAttribute('title', 'Alpha-2 ISO 3166-1'),
            $flag = AdminColumn::image('flag', 'Флаг'),
            $count_using = AdminColumn::count('using', 'Используют'),
        ]);

        return $display;

    }

    /**
     * @param $id
     *
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onEdit($id)
    {
        $getData = $this->getModel()->select('flag')->find($id);
        if ($getData) {
            $this->imageOldPath = $getData->geta;
        }
        $form = AdminForm::panel();
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('name', 'Название')
                            ->setHtmlAttribute('placeholder', 'Название')
                            ->setValidationRules([
                                'required', 'min:2', 'max:255',
                            ]),
                        AdminFormElement::text('code', 'Код страны')
                            ->setHtmlAttribute('placeholder', 'Код страны')
                            ->setHtmlAttribute('title', 'Alpha-2 ISO 3166-1')
                            ->setValidationRules([
                                'required', 'min:2', 'max:10',
                            ]),
                    ];
                })->addColumn(function () {
                    return [
                        AdminFormElement::image('flag', 'Флаг')
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage'
                                    .PathHelper::checkUploadsFileAndPath("/images/countries/flags",
                                        $this->imageOldPath);
                            })
                            ->setValidationRules(['required', 'max:2048'])
                            ->setUploadSettings([
                                'orientate' => [],
                                'resize'    => [
                                    120, null, function ($constraint) {
                                        $constraint->upsize();
                                        $constraint->aspectRatio();
                                    },
                                ],
                            ]),
                    ];
                })
        );

        return $form;

    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @return bool
     */
    public function isDeletable($model)
    {
        return true;
    }

}
