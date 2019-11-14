<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ReplayMap
 *
 * @property \App\Models\ReplayMap $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class ReplayMap extends Section
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $alias = false;

    public function getIcon()
    {
        return 'fab fa-replyd';
    }

    public function getTitle()
    {
        return 'Карты';
    }

    public function initialize()
    {
        $this->addToNavigation(3);
    }


    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center ')
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });
        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $url = AdminColumn::image('url', 'Картинка карты'),

            $name = AdminColumn::text('name', 'Название карты'),

        ]);
        $display->setColumnFilters([

            $id = null,
            $url = null,
            $name = AdminColumnFilter::select()
                ->setOptions((new \App\Models\ReplayMap())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название карты')
                ->setHtmlAttributes(['style' => 'width: 100%']),

        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit(null);
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $display = AdminForm::panel();
        $display->setItems([

            $picture = AdminFormElement::image('url', 'Картинка карты')
                ->setUploadPath(function (UploadedFile $file) {
                    return PathHelper::checkUploadStoragePath("/images/replays/maps");
                })
                ->setValidationRules(['required',
                                      'max:2048']),

            $name = AdminFormElement::text('name', 'Название карты')
                ->setHtmlAttribute('placeholder', 'Название карты')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required',
                                      'string',
                                      'between:1,255']),
        ]);
        return $display;
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
