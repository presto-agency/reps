<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use App\Models\Race;
use App\Models\ReplayMap;
use App\Models\Country;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class Replay
 *
 * @property \App\Models\Replay $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Replay extends Section
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
        return 'fas fa-reply';
    }

    public function getTitle()
    {
        return parent::getTitle();
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(10);

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),

            $user_id = AdminColumn::relatedLink('users.name', 'User')
                ->setWidth('70px'),

            $user_replay = AdminColumn::text('user_replay', 'User replay')
                ->setWidth('30px'),

            $map_id = AdminColumn::relatedLink('maps.name', 'Map')
                ->setWidth('70px'),

            $first_country_id = AdminColumn::text('firstCountries.name', 'first_country')
                ->setWidth('10px'),

            $second_country_id = AdminColumn::text('secondCountries.name', 'second_country')
                ->setWidth('10px'),

            $first_race = AdminColumn::text('firstRaces.title', 'first_race')
                ->setWidth('10px'),

            $second_race = AdminColumn::text('secondRaces.title', 'second_race')
                ->setWidth('10px'),

            $type_id = AdminColumn::text('types.title', 'Type')
                ->setWidth('10px'),

            $comments_count = AdminColumn::text('comments_count', 'Comments')
                ->setWidth('10px'),

            $user_rating = AdminColumn::relatedLink('user_rating', 'User rating')
                ->setWidth('10px'),

            $negative_count = AdminColumn::text('negative_count', 'negative_count')
                ->setWidth('10px'),
            $rating = AdminColumn::text('rating', 'rating')
                ->setWidth('10px'),
            $positive_count = AdminColumn::text('positive_count', 'positive_count')
                ->setWidth('10px'),

            $approved = AdminColumn::custom('Approved<br/>', function ($instance) {
                return $instance->active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px'),

        ]);

        $display->setColumnFilters([
            $id = null,
            $user_id = null,
            $user_replay = null,
            $map_id = AdminColumnFilter::select(ReplayMap::class)
                ->setDisplay('name')
                ->setColumnName('map_id')
                ->setPlaceholder('Select map'),
            $first_country_id = AdminColumnFilter::select(Country::class)
                ->setDisplay('name')
                ->setColumnName('first_country_id')
                ->setPlaceholder('Select country'),
            $second_country_id = AdminColumnFilter::select(Country::class)
                ->setDisplay('name')
                ->setColumnName('second_country_id')
                ->setPlaceholder('Select country'),
            $first_race = AdminColumnFilter::select(Race::class)
                ->setDisplay('title')
                ->setColumnName('first_race')
                ->setPlaceholder('Select race'),
            $second_race = AdminColumnFilter::select(Race::class)
                ->setDisplay('title')
                ->setColumnName('second_race')
                ->setPlaceholder('Select race'),

            $type_id = null,
            $comments_count = null,
            $user_rating = null,
            $negative_count = null,
            $rating = null,
            $positive_count = null,
            $approved = null,

        ]);

        return $display;
    }

    /**
     * @param int $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        // remove if unused
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
