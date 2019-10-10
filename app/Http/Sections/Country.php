<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;


/**
 * Class Country
 * @package App\Http\Sections
 */
class Country extends Section
{

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
            ->paginate(10);

        $display->setHtmlAttribute('class', 'table-info table-sm text-center ');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setHtmlAttribute('class', 'hidden-sm '),

            $name = AdminColumn::text('name', 'Name')
                ->setHtmlAttribute('class', 'hidden-sm '),

            $code = AdminColumn::text('code', 'Code')
                ->setHtmlAttribute('class', 'hidden-sm '),

            $flag = AdminColumn::image('flag', 'Flag')
                ->setHtmlAttribute('class', 'hidden-sm'),
        ]);

        return $display;

    }

    /**
     * @param $id
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Exception
     */
    public function onEdit($id)
    {

        $form = AdminForm::panel();
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [
                        AdminFormElement::text('name', 'First Name')->setValidationRules(['required', 'min:2', 'max:60']),
                        AdminFormElement::text('code', 'Last Name')->setValidationRules(['required', 'min:2', 'max:5']),
                    ];
                })->addColumn(function () {
                    return [
                        AdminFormElement::image('flag', 'Flag')
                            ->setUploadPath(function (UploadedFile $file) {
                                return 'storage/image/county/flag';
                            })
                            ->setUploadFileName(function (UploadedFile $file) {
                                return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                            }),
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
