<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use App\User;

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
        return 'ReplayMap';
    }

    public function initialize()
    {
        $this->addToNavigation(3);
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info text-center')
            ->setDisplaySearch(true)
            ->paginate(10);

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $url = AdminColumn::image('url', 'Image'),

            $name = AdminColumn::text('name', 'Map name'),

        ]);
        $display->setColumnFilters([

            $id = null,

            $url = null,

            $name= AdminColumnFilter::select($this->map())
                ->setColumnName('name')
                ->setPlaceholder('Select map name'),
        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
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

            $picture = AdminFormElement::image('url', 'Url')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/replay/map';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                })
                ->setValidationRules(['required']),

            $name = AdminFormElement::text('name', 'Name')
                ->setValidationRules(['required', 'string', 'max:255']),
        ]);
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

    private $map;

    public function map()
    {
        $countries = \App\Models\ReplayMap::select('id', 'name')->get();
        foreach ($countries as $key => $item) {
            $this->map[$item->id] = $item->name;
        }
        return $this->map;
    }
}
