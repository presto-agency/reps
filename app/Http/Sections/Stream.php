<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Http\ViewComposers\StreamIframeComposer;
use App\Models\{Country, Race};
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
            ->paginate(25);
        $display->setFilters([
            AdminDisplayFilter::related('approved')->setModel(\App\Models\Stream::class),
        ]);

        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });
        $display->setColumns([

            $id = AdminColumn::text('id', 'ID'),
            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь'),
            $title = AdminColumn::text('title', 'Название'),
            $approved = AdminColumnEditable::checkbox('approved')->setLabel('Подтвержден')
                ->append(AdminColumn::filter('approved'))
                ->setWidth(150),
            $online = AdminColumn::custom('Online', function ($model) {
                return $model->active == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            }),
            $service = AdminColumn::custom('Service', function ($model) {
                $parts = $this->parse_stream_url($model->stream_url);
                $host = !empty($parts['host']) === true ? $parts['host'] : 'Поле stream_url пустое';
                return $host;
            }),
        ]);

        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);

        return $display;
    }

    /**
     * @param $id
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Throwable
     */
    public function onEdit($id)
    {
        $display = AdminForm::panel();
        $display->setItems([

            $title = AdminFormElement::text('title', 'Название')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required',
                                      'string',
                                      'between:1,255']),

            $race_id = AdminFormElement::select('race_id', 'Первая раса')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Первая страна')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
                ->setDisplay('name')
                ->setValidationRules(['required']),

            $content = AdminFormElement::textarea('content', 'Комментарий')
                ->setValidationRules(['nullable',
                                      'string',
                                      'max:1000'])
                ->setHtmlAttribute('placeholder', 'Комментарий'),

            $approved = AdminFormElement::checkbox('approved', 'Подтвердить'),

            $stream_url = AdminFormElement::text('stream_url', 'Вставить url')
                ->setHtmlAttribute('placeholder', 'Вставить url')
                ->setValidationRules(['required',
                                      'max:1000',
                                      'url']),


        ]);

        if (!empty($id)) {
            $streamUrlIframe = \App\Models\Stream::where('id', $id)->value('stream_url_iframe');
            $display->setItems([
                \View::make('admin.stream.iframeInput', compact('streamUrlIframe'))->render(),
            ]);
        }

        return $display;
    }

    /**
     * @return \SleepingOwl\Admin\Form\FormPanel
     * @throws \Throwable
     */
    public function onCreate()
    {
        $display = AdminForm::panel();
        $display->setItems([

            $title = AdminFormElement::text('title', 'Название')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required',
                                      'string',
                                      'between:1,255']),

            $race_id = AdminFormElement::select('race_id', 'Первая раса')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Первая страна')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
                ->setDisplay('name')
                ->setValidationRules(['required']),

            $content = AdminFormElement::textarea('content', 'Комментарий')
                ->setValidationRules(['nullable',
                                      'string',
                                      'max:1000'])
                ->setHtmlAttribute('placeholder', 'Комментарий'),

            $approved = AdminFormElement::checkbox('approved', 'Подтвердить')
                ->setHtmlAttribute('checked', 'checked')
                ->setDefaultValue(true),

            $stream_url = AdminFormElement::text('stream_url', 'Вставить url')
                ->setHtmlAttribute('placeholder', 'Вставить url')
                ->setValidationRules(['required',
                                      'max:1000',
                                      'url']),
        ]);
        $display->setItems([
            \View::make('admin.stream.iframeInput')->render(),
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

    public function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }
}
