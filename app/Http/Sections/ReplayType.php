<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class ReplayType
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\ReplayType $model
 *
 */
class ReplayType extends Section
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
        return 'fab fa-replyd';
    }

    public function getTitle()
    {
        return 'Типы';
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info')
            ->setOrder([[0, 'desc']])
            ->paginate(10);

        $display->setColumns([
            AdminColumn::text('title', 'Title'),
        ]);

        return $display;
    }

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $display = AdminForm::panel();

        $display->setItems([
            $title = AdminFormElement::text('title', 'Title')
                ->setHtmlAttribute('placeholder', 'Название')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules(['required', 'string', 'between:1,255']),
        ]);

        return $display;
    }

}
