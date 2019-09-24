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
            ->paginate(50);

        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'desc');
        });

        $display->setColumns([
            $type = AdminColumn::relatedLink('types.name', 'Type'),
            $user_id = AdminColumn::relatedLink('users.name', 'Name'),
            $time = AdminColumn::datetime('time', 'time')->setFormat('d-m-Y'),
            $ip = AdminColumn::text('ip', 'Ip'),
            $parameters = AdminColumn::text('parameters', 'Parameters'),
        ]);

        $display->setColumnFilters([
            $type = AdminColumnFilter::select(UserActivityType::class)
                ->setColumnName('type_id')
                ->setDisplay('name')
                ->setPlaceholder('Select role'),
            $user_id = AdminColumnFilter::select(User::class)
                ->setColumnName('user_id')
                ->setDisplay('name')
                ->setPlaceholder('Select name')
            ,
            $time = null,
//              TODO:: Фильтры  на дату с/по, в админке поломаны 23.09.2019
//            $time = AdminColumnFilter::range()->setFrom(
//                AdminColumnFilter::date()->setPlaceholder('From Date')->setFormat('d-m-Y')
//            )->setTo(
//                AdminColumnFilter::date()->setPlaceholder('To Date')->setFormat('d-m-Y')
//            ),
            $ip = AdminColumnFilter::text()->setPlaceholder('Ip'),
            $parameters = null,


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
