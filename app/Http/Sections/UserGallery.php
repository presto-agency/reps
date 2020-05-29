<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Services\ServiceAssistants\PathHelper;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Section;

/**
 * Class UserGallery
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\UserGallery $model
 *
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

    protected $title = 'Галереи';


    /**
     * @return DisplayDatatablesAsync
     * @throws Exception
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->with(['users','comments'])
            ->setOrder([[0, 'desc']])
            ->paginate(10);

        $display->setFilters(AdminDisplayFilter::related('for_adults')->setModel(\App\Models\UserGallery::class));

        $display->setColumns([
            AdminColumn::text('id', 'ID')->setWidth('100px'),
            AdminColumn::image(function ($model) {
                return $model->pictureOrDefault();
            })->setLabel('Изображение'),
            AdminColumn::relatedLink('users.name', 'Пользователь')->setWidth('200px'),
            AdminColumn::text(function ($model) {
                return clean($model->sign);
            })->setLabel('Подпись')->setHtmlAttribute('class', 'text-left'),
            AdminColumnEditable::checkbox('for_adults')
                ->setLabel('18+')
                ->append(AdminColumn::filter('for_adults')),
            AdminColumn::custom('Рейтинг', function ($model) {
                $thumbsUp   = '<span style="font-size: 1em; color: green;"><i class="far fa-thumbs-up"></i></span>';
                $equals     = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="far fa-thumbs-down"></i></span>';

                return $thumbsUp.$model->positive_count.
                    '<br/>'.$equals.($model->positive_count - $model->negative_count).
                    '<br/>'.$thumbsDown.$model->negative_count;
            }),
            $comments_count = AdminColumn::count('comments', 'Количество<br>коментариев')
                ->setWidth('115px'),
        ]);

        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show();
        $control->addButton($buttonShow);

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
            $picture = AdminColumn::image('picture', 'Изображение')
                ->setImageWidth('450px'),
            $sign = AdminFormElement::text('sign', 'Подпись')
                ->setHtmlAttribute('placeholder', 'Подпись')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),
            $for_adults = AdminFormElement::checkbox('for_adults', '18+')
                ->setValidationRules([
                    'boolean',
                ]),
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
            $picture = AdminFormElement::image('picture', 'Изображение')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'.PathHelper::checkUploadsFileAndPath('/images/users/galleries');
                })->setValidationRules([
                    'required',
                    'max:2048',
                ]),
            $sign = AdminFormElement::text('sign', 'Подпись')
                ->setHtmlAttribute('placeholder', 'Подпись')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),
            $for_adults = AdminFormElement::checkbox('for_adults', '18+')
                ->setValidationRules([
                    'boolean',
                ]),
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
     * @return ControlLink
     */
    public function show()
    {
        $link = new ControlLink(function (Model $model) {
            return asset('admin/user_galleries/show/'.$model->getKey());
        }, 'Просмотреть');
        $link->hideText();
        $link->setIcon('fa fa-eye');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
