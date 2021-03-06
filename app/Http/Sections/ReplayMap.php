<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ReplayMap
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\ReplayMap $model
 *
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
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center ')
            ->setOrder([[0, 'desc']])
            ->paginate(10);

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $url = AdminColumn::image(function ($model) {
                if ( ! empty($model->url) && PathHelper::checkFileExists($model->url)
                ) {
                    return $model->url;
                } else {
                    return 'images/default/map/nominimap.png';
                }
            })->setLabel('Картинка карты')->setWidth(10),

            $name = AdminColumn::text('name', 'Название карты'),

        ]);
        $display->setColumnFilters([

            $id = null,
            $url = null,
            $name = AdminColumnFilter::select()
                ->setOptions((new \App\Models\ReplayMap())->pluck('name',
                    'name')->toArray())
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

    public $imageOldPath;

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $getData = $this->getModel()->select('url')->find($id);
        if ($getData) {
            $this->imageOldPath = $getData->url;
        }

        $display = AdminForm::panel();
        $display->setItems([

            $picture = AdminFormElement::image('url', 'Картинка карты')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'
                        .PathHelper::checkUploadsFileAndPath("/images/replays/maps",
                            $this->imageOldPath);
                })
                ->setValidationRules([
                    'required',
                    'mimes:jpeg,png,jpg',
                    'max:2048',
                ])->setUploadSettings([
                    'orientate' => [],
                    'resize'    => [
                        256,
                        256,
                        function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        },
                    ],
                ])
            ,

            $name = AdminFormElement::text('name', 'Название карты')
                ->setHtmlAttribute('placeholder', 'Название карты')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'required',
                    'string',
                    'between:1,255',
                ]),
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
