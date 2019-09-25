<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(false)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderBy('created_at', 'desc');
        });
        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),
            $picture = AdminColumn::image('picture', 'Picture')
                ->setHtmlAttribute('class', 'hidden-sm'),
            $user_id = AdminColumn::relatedLink('users.name', 'User name')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('100px'),
            $sign = AdminColumn::text('sign', 'Sign')
                ->setHtmlAttribute('class', 'text-left')
                ->setWidth('200px'),
            $for_adults = AdminColumnEditable::checkbox('for_adults', '18+')
                ->setWidth('10px'),
            $negative_count = AdminColumn::text('negative_count', 'Negative Rating')
                ->setWidth('10px'),
            $positive_count = AdminColumn::text('positive_count', 'Positive Rating')
                ->setWidth('10px'),
            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth('10px'),
            $comments_count = AdminColumn::text('comments_count', 'Comments')
                ->setWidth('10px'),

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

            $picture = AdminFormElement::image('picture', 'Picture')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/gallery';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                })
                ->setValidationRules(['required']),

            $user_id = AdminFormElement::hidden('user_id')->setDefaultValue(auth()->user()->id)
                ->setValidationRules(['required', 'min:1']),

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
