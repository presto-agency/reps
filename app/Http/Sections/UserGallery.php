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
     * @var bool
     */
    protected $checkAccess = false;
    /**
     * @var bool
     */
    protected $alias = false;

    /**
     * @return string
     */
    public function getIcon()
    {
        return parent::getIcon();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Галерея';
    }


    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \Exception
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

        $display->with('users','comments');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(50),

            $picture = AdminColumn::image('picture', 'Изображение'),

            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь'),

            $sign = AdminColumn::text('sign', 'Подпись'),

            $for_adults = AdminColumnEditable::checkbox('for_adults')->setLabel('18+')
                ->setWidth(50)
                ->append(AdminColumn::filter('for_adults')),

            $rating = AdminColumn::custom('Рейтинг', function ($model) {
                $positive = $model->negative_count;
                $negative = $model->positive_count;
                $result = $positive - $negative;
                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';
                return "{$thumbsUp}" . "({$positive})" . '<br/>' . "{$equals}" . "({$result})" . '<br/>' . "{$thumbsDown}" . "({$negative})";
            })->setWidth(10),

            $comments_count = AdminColumn::custom('Комментариев', function ($model) {
                return "{$model->comments->count()}";
            })->setWidth(100),

        ]);

        $control = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show();
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
            $sign = AdminFormElement::text('sign', 'Подпись')
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

            $picture = AdminFormElement::image('picture', 'Картинка')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/image/user/gallery';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                })
                ->setValidationRules(['required']),

            $sign = AdminFormElement::text('sign', 'Подпись')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $for_adults = AdminFormElement::checkbox('for_adults', '18+'),
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
     * @return \SleepingOwl\Admin\Display\ControlLink
     */
    public function show()
    {

        $link = new \SleepingOwl\Admin\Display\ControlLink(function (\Illuminate\Database\Eloquent\Model $model) {
            $url = url('admin/user_galleries/show/'. $model->getKey());
            return $url;
        }, function (\Illuminate\Database\Eloquent\Model $model) {
            return 'Просмотреть';
        }, 50);
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }
}
