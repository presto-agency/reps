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
        return 'fa fa-video';
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

        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);

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

            $title = AdminFormElement::text('title', 'Title')
                ->setValidationRules(['required', 'max:255', 'string']),

            $race_id = AdminFormElement::select('race_id', 'Race')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $content = AdminFormElement::wysiwyg('content', 'Content')
                ->setValidationRules(['nullable']),
            $country_id = AdminFormElement::select('country_id', 'Country')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
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

    /**
     * @param $display
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show($display)
    {

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $url = url('admin/streams/show');
            return $url . '/' . $model->getKey();
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
