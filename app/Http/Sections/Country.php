<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminNavigation;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;


/**
 * Class Country
 *
 * @property \App\Models\Country $model
 *
 * @see https://sleepingowladmin.ru/#/ru/model_configuration_section
 */
class Country extends Section implements Initializable
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
     * Initialize class.
     */
    public function initialize()
    {

        $page = AdminNavigation::getPages()->findById('parent-general');

        $page->addPage(
            $this->makePage(100)->setIcon('fa fa-lightbulb-o')
        );
    }


    /**
     * @param $id
     * @return mixed
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(true)
            ->paginate(50);
        $display->setHtmlAttribute('class', 'table-info table-hover');
        $display->setFilters(
            AdminDisplayFilter::related('name')->setModel(Country::class)
        );


        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')
                ->setHtmlAttribute('class', 'hidden-sm '),
            $name = AdminColumn::text('name', 'Name')
                ->setHtmlAttribute('class', 'hidden-sm '),
            $code = AdminColumn::text('code', 'Code')
                ->setHtmlAttribute('class', 'hidden-sm '),
            $flag = AdminColumn::image('flag', 'Flag')
                ->setHtmlAttribute('class', 'hidden-sm')
                ->setWidth('100px'),
        ]);

        return $display;

    }

    protected $id;

    /**
     * @param int|null $id
     * @param array $payload
     *
     * @return FormInterface
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
                                return 'storage/flags';
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
     * @return FormInterface
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
