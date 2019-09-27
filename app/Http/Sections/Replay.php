<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;

use AdminDisplayFilter;
use AdminFormElement;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
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
        $replay = \App\Models\Replay::class;

        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center small')
            ->paginate(10);
        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Replay::class),
            AdminDisplayFilter::related('type_id')->setModel(\App\Models\Replay::class),
        ]);
        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $user_id = AdminColumn::relatedLink('users.name', 'User'),

            $user_replay = AdminColumn::text('user_replay', 'Replay<br/><small>(title)</small>'),

            $map_id = AdminColumn::relatedLink('maps.name', 'Map'),

            $country = AdminColumn::custom('Country', function ($replay) {
                return "{$replay->firstCountries->name}" . '<br/><small>vs</small><br/>' . "{$replay->secondCountries->name}";
            }),

            $race = AdminColumn::custom('Race', function ($replay) {
                return "{$replay->firstRaces->title}" . '<br/><small>vs</small><br/>' . "{$replay->secondRaces->title}";
            }),

            $type_id = AdminColumn::text('types.title', 'Type')
                ->append(AdminColumn::filter('type_id'))
                ->setWidth(100),

            $comments_count = AdminColumn::text('comments_count', 'Comment')
                ->setWidth(105),

            $user_rating = AdminColumn::relatedLink('user_rating', 'User<br/><small>(rating)</small>')
                ->setWidth(65),

            $rating = AdminColumn::custom('Raiting', function ($replay) {
                $positive = $replay->negative_count;
                $negative = $replay->positive_count;
                $result = $positive - $negative;

                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';
                return "{$thumbsUp}" . "({$positive})" . '<br/>' . "{$equals}" . "({$result})" . '<br/>' . "{$thumbsDown}" . "({$negative})";
            })->setWidth(10),

            $approved = AdminColumnEditable::checkbox('approved')->setLabel('Approved')
                ->append(AdminColumn::filter('approved'))
                ->setWidth(100),

        ]);

        $display->setColumnFilters([
            $id = null,
            $user_id = AdminColumnFilter::text()->setOperator('contains')
                ->setPlaceholder('User'),
            $user_replay = AdminColumnFilter::text()->setOperator('contains')
                ->setPlaceholder('Replay'),
            $map_id = AdminColumnFilter::select($this->map())
                ->setColumnName('map_id')
                ->setPlaceholder('Select'),
            $country = AdminColumnFilter::select($this->country())
                ->setColumnName('first_country_id')
                ->setColumnName('second_country_id')
                ->setPlaceholder('Select'),
            $race = AdminColumnFilter::select($this->race())
                ->setColumnName('first_race')
                ->setColumnName('second_race')
                ->setPlaceholder('Select'),

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
        $form = AdminForm::panel();

        $form->addHeader([
            AdminFormElement::columns()
                ->addColumn([
                    $user_replay = AdminFormElement::text('user_replay', 'Replay title')
                        ->setValidationRules(['required', 'string',  'between:4,255'])
                ], 3)->addColumn([
                    $type_id = AdminFormElement::select('type_id', 'Type', $this->type())
                        ->setValidationRules(['required', 'string'])
                ], 3)->addColumn([
                    $map_id = AdminFormElement::select('map_id', 'Map', $this->map())
                        ->setValidationRules(['required', 'string'])
                ])
        ]);
        $form->setItems(
            AdminFormElement::columns()
                ->addColumn(function () {
                    return [

                        $first_race = AdminFormElement::select('first_race', 'First race', $this->race())
                            ->setValidationRules(['required', 'string']),

                        $first_country_id = AdminFormElement::select('first_country_id', 'First country', $this->country())
                            ->setValidationRules(['required', 'string']),

                        $first_location = AdminFormElement::text('first_location', 'First location')
                            ->setValidationRules(['nullable', 'numeric', 'max:255'])
                            ->setValueSkipped(function () {
                                return is_null(request('first_location'));
                            }),
                        $first_name = AdminFormElement::text('first_name', 'First name')
                            ->setValidationRules(['nullable', 'string', 'alpha_dash', 'max:255']),

                        $first_apm = AdminFormElement::text('first_apm', 'First APM')
                            ->setValidationRules(['nullable', 'numeric', 'between:1,255']),

                    ];
                })->addColumn(function () {
                    return [

                        $first_race = AdminFormElement::select('second_race', 'Second race', $this->race())
                            ->setValidationRules(['required', 'string']),

                        $first_country_id = AdminFormElement::select('second_country_id', 'Second country', $this->country())
                            ->setValidationRules(['required', 'string']),

                        $first_location = AdminFormElement::text('second_location', 'Second location')
                            ->setValidationRules(['nullable', 'numeric', 'min:1'])
                            ->setValueSkipped(function () {
                                return is_null(request('second_location'));
                            }),

                        $first_name = AdminFormElement::text('second_name', 'Second name')
                            ->setValidationRules(['nullable', 'string', 'alpha_dash', 'max:255']),

                        $first_apm = AdminFormElement::text('second_apm', 'Second APM')
                            ->setValidationRules(['nullable', 'numeric', 'between:1,255']),

                    ];
                })
        );

        $form->addBody([

            $file = AdminFormElement::file('file', 'File')
                ->setValidationRules(['required', 'file', 'max:10000'])
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/replay/file';
                })->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                }),
            $date = AdminFormElement::date('start_date', 'Date start')->setFormat('d-m-Y'),

            $content = AdminFormElement::wysiwyg('content', 'Content')
                ->setValidationRules(['nullable', 'string', 'between:1,1000']),

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

    private $user, $map, $country, $race, $type;

    private function user()
    {

        foreach (\App\User::select('id', 'name')->get() as $key => $item) {
            $this->user[$item->id] = $item->name;
        }
        return $this->user;
    }

    private function map()
    {
        foreach (\App\Models\ReplayMap::select('id', 'name')->get() as $key => $item) {
            $this->map[$item->id] = $item->name;
        }
        return $this->map;
    }

    private function country()
    {
        foreach (\App\Models\Country::select('id', 'name')->get() as $key => $item) {
            $this->country[$item->id] = $item->name;
        }
        return $this->country;
    }


    private function race()
    {
        foreach (\App\Models\Race::select('id', 'title')->get() as $key => $item) {
            $this->race[$item->id] = $item->title;
        }
        return $this->race;
    }

    private function type()
    {

        foreach (\App\Models\ReplayType::select('id', 'title')->get() as $key => $item) {
            $this->type[$item->id] = $item->title;
        }
        return $this->type;
    }
}
