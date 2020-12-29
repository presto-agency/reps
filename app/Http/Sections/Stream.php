<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Http\ViewComposers\StreamIframeComposer;
use App\Models\{Country, Race};
use Exception;
use Illuminate\Database\Eloquent\Model;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Form\FormPanel;
use SleepingOwl\Admin\Section;
use Throwable;
use View;

/**
 * Class Stream
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\Stream $model
 *
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

    public function getTitle()
    {
        return 'Stream';
    }

    public function initialize()
    {
        $this->addToNavigation(3);
    }

    /**
     * @return DisplayDatatablesAsync
     * @throws Exception
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center ')
            ->with(['users'])
            ->setOrder([[0, 'desc']])
            ->paginate(25);
        $display->setFilters(AdminDisplayFilter::related('approved')->setModel(\App\Models\Stream::class));

        $display->setColumns([
            $id = AdminColumn::text('id', 'ID')->setWidth('100px'),
            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь')
                ->setWidth('300px'),
            $title = AdminColumn::text('title', 'Название')
                ->setHtmlAttribute('class', 'text-left'),
            $approved = AdminColumnEditable::checkbox('approved')
                ->setLabel('Подтвержден')
                ->append(AdminColumn::filter('approved'))
                ->setWidth('150px'),
            $online = AdminColumn::custom('Online', function ($model) {
                return $model->active == 1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            }),
            $service = AdminColumn::custom('Service', function ($model) {
                $parts = $this->parse_stream_url($model->stream_url);

                return !empty($parts['host']) === true ? $parts['host'] : 'Поле stream_url пустое';
            })->setWidth('150px'),
        ]);

        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show($display);
        $control->addButton($buttonShow);


        $display->setColumnFilters(
            [
                null,
                null,
                AdminColumnFilter::text()
                    ->setOperator(FilterInterface::CONTAINS)
                    ->setPlaceholder('Название')
                    ->setHtmlAttributes(['style' => 'width: 100%']),
            ]
        );
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    /**
     * @param $id
     *
     * @return FormPanel
     * @throws Throwable
     */
    public function onEdit($id)
    {
        $display = AdminForm::panel();
        $display->setItems([
            $title = AdminFormElement::text('title', 'Название')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'string',
                    'between:1,255',
                ]),
            $race_id = AdminFormElement::select('race_id', 'Первая раса')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setValidationRules([
                    'exists:races,id',
                ]),
            $country_id = AdminFormElement::select('country_id',
                'Первая страна')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
                ->setValidationRules([
                    'exists:countries,id',
                ]),
            $content = AdminFormElement::textarea('content', 'Описание')
                ->setHtmlAttribute('placeholder', 'Описание')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'max:1000',
                ]),
            $approved = AdminFormElement::checkbox('approved', 'Подтвердить')
                ->setValidationRules([
                    'boolean',
                ]),
            $stream_url = AdminFormElement::text('stream_url', 'Вставить Stream url')
                ->setHtmlAttribute('placeholder', 'Вставить Stream url')
                ->setValidationRules([
                    'max:1000',
                    'url',
                ]),
        ]);

//        $model = $this->getModel()->find($id);
//        AdminFormElement::html(function ($model) {
//                    $htmStart = '<h5>Defiler Data</h5><ul class="list-group small">';
//                    $htmlList = '';
//                    $dataDefiler = json_decode($model->data, true);
//                    if (isset($dataDefiler['defiler'])) {
//                        foreach ($dataDefiler['defiler'] as $key => $value) {
//                            $htmlList .= "<li class='list-group-item'><strong>$key</strong>:$value</li>";
//                        }
//                    }
//                    $htmlEnd = '</ul>';
//                    return "$htmStart$htmlList$htmlEnd";
//                }),

        $display->setItems([AdminFormElement::view('admin.stream.iframeInput', [], null),]);

        return $display;
    }

    /**
     * @return FormPanel
     * @throws Throwable
     */
    public function onCreate()
    {
        $display = AdminForm::panel();
        $display->setItems([
            $title = AdminFormElement::text('title', 'Название')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'required',
                    'string',
                    'between:1,255',
                ]),
            $race_id = AdminFormElement::select('race_id', 'Первая раса')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setValidationRules([
                    'required',
                    'exists:races,id',
                ]),
            $country_id = AdminFormElement::select('country_id', 'Первая страна')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
                ->setValidationRules([
                    'required',
                    'exists:countries,id',
                ]),
            $content = AdminFormElement::textarea('content', 'Описание')
                ->setHtmlAttribute('placeholder', 'Описание')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'max:1000',
                ]),
            $approved = AdminFormElement::checkbox('approved', 'Подтвердить')
                ->setValidationRules([
                    'boolean',
                ]),
            $stream_url = AdminFormElement::text('stream_url', 'Вставить Stream url')
                ->setHtmlAttribute('placeholder', 'Вставить Stream url')
                ->setValidationRules([
                    'required',
                    'max:1000',
                    'url',
                ]),
        ]);
        $display->setItems([
            View::make('admin.stream.iframeInput')->render(),
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
     *
     * @return ControlLink
     */
    private function show($display)
    {
        $link = new ControlLink(function (Model $model) {
            return asset('admin/streams/show/'.$model->getKey());
        }, 'Просмотреть');
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

    private function parse_stream_url($url)
    {
        return parse_url(htmlspecialchars_decode($url));
    }

}
