<?php

namespace App\Http\Sections;

use AdminColumnEditable;
use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use App\Models\Country;
use App\Models\Race;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class Stream
 *
 * @property \App\Models\Stream $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class Stream extends Section implements Initializable
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
        return 'fa fa-globe';
    }

    public function getTitle()
    {
        return 'Stream';
    }

    public function initialize()
    {
        $this->addToNavigation(3);
    }

    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \Exception
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center ')
            ->paginate(10);
        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Stream::class),
        ]);
        $display->with('users');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),
            $user_id = AdminColumn::relatedLink('users.name', 'User'),

            $title = AdminColumn::text('title', 'Title'),

            $approved = AdminColumnEditable::checkbox('approved')->setLabel('Approved')
                ->append(AdminColumn::filter('approved'))
                ->setWidth(100),
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
        $display = AdminForm::panel();
        $display->setItems([

            $user_id = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),

            $title = AdminFormElement::text('title', 'Title')
                ->setValidationRules(['required', 'max:255', 'string']),

            $race_id = AdminFormElement::select('race_id', 'Race', $this->race())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $content = AdminFormElement::wysiwyg('content', 'Content')
                ->setValidationRules(['nullable']),

            $country_id = AdminFormElement::select('country_id', 'Country', $this->country())
                ->setDisplay('name')
                ->setValidationRules(['required']),

            $stream_url = AdminFormElement::text('stream_url', 'Stream url')
                ->setValidationRules(['nullable', 'max:255', 'string']),

            $approved = AdminFormElement::checkbox('approved', 'Approved'),


        ]);

        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        return $this->onEdit('');
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

}
