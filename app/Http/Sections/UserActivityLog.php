<?php

namespace App\Http\Sections;

use App\Models\UserActivityType;
use App\User;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;
use AdminDisplay;
use AdminColumn;
use AdminColumnFilter;

/**
 * Class UserActivityLog
 *
 * @property \App\Models\UserActivityLog $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserActivityLog extends Section
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
        return 'fas fa-use';
    }

    public function getTitle()
    {
        return 'Лог активности';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center ')
            ->paginate(10);

        $display->with('users', 'types');

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->setColumns([
            $type = AdminColumn::relatedLink('types.name', 'Type'),

            $user_id = AdminColumn::relatedLink('users.name', 'Name'),

            $time = AdminColumn::datetime('time', 'time')->setFormat('d-m-Y')
                ->setWidth(85),

            $ip = AdminColumn::text('ip', 'Ip'),

            $parameters = AdminColumn::text('parameters', 'Parameters')
                ->setWidth(500),
        ]);

        $display->setColumnFilters([
            $type = AdminColumnFilter::select($this->type())
                ->setColumnName('type_id')
                ->setPlaceholder('Select type'),
            $user_id = AdminColumnFilter::select(User::class)
                ->setColumnName('user_id')
                ->setDisplay('name')
                ->setPlaceholder('Select name')
            ,
            $time = null,
            $ip = AdminColumnFilter::text()->setPlaceholder('Ip'),
            $parameters = null,


        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    private $type;

    public function type()
    {
        $countries = UserActivityType::select('id', 'name')->get();
        foreach ($countries as $key => $item) {
            $this->type[$item->id] = $item->name;
        }
        return $this->type;
    }
}
