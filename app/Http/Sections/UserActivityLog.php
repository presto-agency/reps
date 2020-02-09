<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Exceptions\FilterOperatorException;
use SleepingOwl\Admin\Section;

/**
 * Class UserActivityLog
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\UserActivityLog $model
 *
 */
class UserActivityLog extends Section implements Initializable
{

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    protected $alias = false;

    protected $title = 'Лог активности';

    protected $types;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        $this->types = \App\Models\UserActivityLog::$eventType;
    }

    /**
     * @return DisplayDatatablesAsync
     * @throws FilterOperatorException
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->with(['users'])
            ->paginate(25);
        $display->setApply(function ($query) {
            $query->orderBy('time', 'desc');
        });
        $display->setColumns([
            $type = AdminColumn::text('type', 'Событие')->setWidth('150px'),
            $user = AdminColumn::relatedLink('users.name', 'Пользователь')
                ->setFilterCallback(function ($column, $query, $search) {
                    if ($search) {
                        $query->whereHas('users', function ($q) use ($search) {
                            return $q->where('name', 'like', '%'.$search.'%');
                        });
                    }
                })->setWidth('200px'),
            $time = AdminColumn::datetime('time', 'Время')->setWidth('250px'),
            $ip = AdminColumn::text('ip', 'IP')->setWidth('150px'),
            $parameters = AdminColumn::custom('Описание', function ($model) {
                return $this->getEventTitle($model);
            })->setHtmlAttribute('class', 'text-left'),
        ]);

        $display->setColumnFilters([
            $type = AdminColumnFilter::select()
                ->setOptions($this->types)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все события')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $time = AdminColumnFilter::range()
                ->setFrom(AdminColumnFilter::date()->setPlaceholder('С')
                    ->setFormat('Y-m-d'))
                ->setTo(AdminColumnFilter::date()->setPlaceholder('По')
                    ->setFormat('Y-m-d'))
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $ip = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('IP')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $parameters = null,


        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    /**
     * @param $model
     *
     * @return string
     */
    private function getEventTitle($model)
    {
        $test = json_decode($model->parameters);

        return ! empty($test->description) === true ? $test->description : '';
    }

}
