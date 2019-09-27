<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class UserGallery
 *
 * @property \App\Models\UserGallery $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserGallery extends Section
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
        return 'fas fa-user';
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
            ->setDisplaySearch(false)
            ->setHtmlAttribute('class', 'table-info table-sm text-center')
            ->paginate(10);

        $display->setFilters([
            AdminDisplayFilter::related('for_adults')->setModel(\App\Models\UserGallery::class),
        ]);

        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });

        $display->with('users');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $picture = AdminColumn::image('picture', 'Picture'),

            $user_id = AdminColumn::relatedLink('users.name', 'User name'),

            $sign = AdminColumn::text('sign', 'Sign'),

            $for_adults = AdminColumnEditable::checkbox('for_adults')->setLabel('18+')
                ->setWidth(50)
                ->append(AdminColumn::filter('for_adults')),

            $negative_count = AdminColumn::text('negative_count', 'Rating<br/><small>(negative)</small>')
                ->setWidth(74),
            $positive_count = AdminColumn::text('positive_count', 'Rating<br/><small>(positive)</small>')
                ->setWidth(70),
            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth(70),
            $comments_count = AdminColumn::text('comments_count', 'Count<br/><small>(comments)</small>')
                ->setWidth(90),

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
            $sign = AdminFormElement::text('sign', 'Sign')
                ->setValidationRules(['nullable', 'string', 'max:255']),
        ]);
        return $display;
    }

    /**
     * @return FormInterface
     */
    public function onCreate()
    {
        $display = AdminForm::panel();
        $display->setItems([

            $user_id = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id),

            $picture = AdminFormElement::image('picture', 'Picture')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/gallery';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                })
                ->setValidationRules(['required']),

            $sign = AdminFormElement::text('sign', 'Sign')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $for_adults = AdminFormElement::checkbox('for_adults', 'For adults(18+)'),
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
}
