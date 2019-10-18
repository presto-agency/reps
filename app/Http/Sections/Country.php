<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
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
            ->paginate(50);

        $display->setHtmlAttribute('class', 'table-info table-sm text-center ');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'asc');
        });
        $display->setColumns([

            $id = AdminColumn::text('id', 'ID'),

            $name = AdminColumn::text('name', 'Название'),

            $code = AdminColumn::text('code', 'Код')
                ->setHtmlAttribute('class', 'hidden-sm ')
                ->setHtmlAttribute('title', 'Alpha-2 ISO 3166-1'),

            $flag = AdminColumn::image('flag', 'Флаг'),

            $using = AdminColumn::custom('Используют', function ($model) {
                return \App\Models\Country::withCount('using')->where('name', $model->name)->value('using_count');
            })
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
                        AdminFormElement::text('name', 'Название')
                            ->setHtmlAttribute('placeholder', 'Название')
                            ->setValidationRules(['required', 'min:2', 'max:255']),
                        AdminFormElement::text('code', 'Код страны')
                            ->setHtmlAttribute('placeholder', 'Код страны')
                            ->setHtmlAttribute('title', 'Alpha-2 ISO 3166-1')
                            ->setValidationRules(['required', 'min:2', 'max:10']),
                    ];
                })->addColumn(function () {
                    return [
                        AdminFormElement::image('flag', 'Флаг')
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
