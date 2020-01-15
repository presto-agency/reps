<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class TournamentsMapPool
 *
 * @property \App\Models\TourneyListsMapPool $model
 */
class TournamentsMapPool extends Section
{

    /**
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


    public function onDisplay()
    {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('100px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::image(function ($model) {
                if ( ! empty($model->map->url) && PathHelper::checkFileExists($model->map->url)
                ) {
                    return $model->map->url;
                } else {
                    return 'images/default/map/nominimap.png';
                }
            })->setLabel('Map'),
            AdminColumn::text('map.name', 'Map name')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('map', function ($q) use ($search) {
                            return $q->where('name', 'like', "%$search%");
                        });
                    }
                }),
            AdminColumn::text('tourney.name', 'Tourney name')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('tourney', function ($q) use ($search) {
                            return $q->where('name', 'like', "%$search%");
                        });
                    }
                }),

        ];

        $display = AdminDisplay::datatables()
            ->setName('TournamentsMapPoolDataTables')
            ->setOrder([[0, 'desc']])
            ->with('map', 'tourney')
            ->setDisplaySearch(false)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');


        $display->setColumnFilters([

            null,
            null,
            AdminColumnFilter::select()
                ->setOptions((new \App\Models\ReplayMap())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название карты')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            AdminColumnFilter::select()
                ->setOptions((new \App\Models\TourneyList())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Название турнира')
                ->setHtmlAttributes(['style' => 'width: 100%']),

        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::select('map_id')
                ->setValidationRules([
                    'exists:replay_maps,id',
                ])
                ->setOptions((new \App\Models\ReplayMap())->orderByDesc('id')->pluck('name', 'id')->toArray())
                ->setLabel('Карта'),
            AdminFormElement::select('tourney_id')
                ->setValidationRules([
                    'exists:tourney_lists,id',
                ])
                ->setOptions((new \App\Models\TourneyList())->orderByDesc('id')->pluck('name', 'id')->toArray())
                ->setLabel('Турнир'),
        ]);
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return AdminForm::panel()->addBody([
            AdminFormElement::select('map_id')
                ->setValidationRules([
                    'required',
                    'exists:replay_maps,id',
                ])
                ->setOptions((new \App\Models\ReplayMap())->orderByDesc('id')->pluck('name', 'id')->toArray())
                ->setLabel('Карта'),
            AdminFormElement::select('tourney_id')
                ->setValidationRules([
                    'required',
                    'exists:tourney_lists,id',
                ])
                ->setOptions((new \App\Models\TourneyList())->orderByDesc('id')->pluck('name', 'id')->toArray())
                ->setLabel('Турнир'),
        ]);
    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
        // remove if unused
    }

}
