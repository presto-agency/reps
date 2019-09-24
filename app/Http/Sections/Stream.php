<?php

namespace App\Http\Sections;

use AdminDisplay;
use AdminColumn;
use AdminForm;
use AdminFormElement;
use App\Models\Country;
use App\Models\Race;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
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
     * @return DisplayInterface
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(50);

        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'desc');
        });

        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),
            $user_id = AdminColumn::relatedLink('users.name', 'User name')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('100px'),
            $title = AdminColumn::text('title', 'Title')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('50px'),
            $approved = AdminColumn::custom('Approved<br/>', function ($instance) {
                return $instance->active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px'),
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

            $user_id = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id)
                ->setValidationRules(['required', 'min:1']),

            $title = AdminFormElement::text('title', 'Title')
                ->setValidationRules(['required', 'max:255', 'string']),

            $race_id = AdminFormElement::select('race_id', 'Race', Race::class)
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $content = AdminFormElement::wysiwyg('content', 'Content')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Country', Country::class)
                ->setDisplay('name')
                ->setValidationRules(['nullable']),

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
