<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use AdminNavigation;
use App\Models\Country;
use App\Models\Race;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Section;

/**
 * Class User
 *
 * @property \App\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class User extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $alias;


    public function initialize()
    {

        $page = AdminNavigation::getPages()->findById('parent-users');

        $page->addPage(
            $this->makePage(100)
        );

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
        $display->setFilters(
            AdminDisplayFilter::related('role_id')->setModel(Role::class),
            AdminDisplayFilter::related('country_id')->setModel(Country::class)
        );

        $display->setColumns([
            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),
            $avatar = AdminColumn::image('avatar', 'Avatar')
                ->setWidth('50px'),
            $name = AdminColumn::text('name', 'Name')->setWidth('50px'),
            $email = AdminColumn::text('email', 'Email')->setWidth('50px'),
            $role_id = AdminColumn::relatedLink('roles.title', 'Role')
                ->append(AdminColumn::filter('role_id'))
                ->setWidth('50px'),
            $country_id = AdminColumn::relatedLink('countries.name', 'Country')
                ->append(AdminColumn::filter('country_id'))
                ->setWidth('50px'),
            $rating = AdminColumn::text('rating', 'Rating')->setWidth('50px'),
            $count_topic = AdminColumn::text('count_topic', 'Topic')->setWidth('50px'),
            $count_replay = AdminColumn::text('count_replay', 'Replay')->setWidth('50px'),
            $count_picture = AdminColumn::text('count_picture', 'Picture')->setWidth('50px'),
            $count_comment = AdminColumn::text('count_comment', 'Comment')->setWidth('50px'),
            $email_check = AdminColumn::custom('Email check<br/>', function ($instance) {
                return $instance->active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px'),
            $ban = AdminColumnEditable::checkbox('ban', 'Ban')
                ->setWidth('10px'),
            $activity_at = AdminColumnEditable::datetime('activity_at', 'Last activity')
                ->setWidth('50px'),
        ]);

        $display->setColumnFilters([
            $id = null, // Не ищем по первому столбцу
            $avatar = null,
            $name = null,
            $email = null,
            $role = AdminColumnFilter::select(Role::class, 'Title')
                ->setDisplay('title')
                ->setPlaceholder('Select role')
                ->setColumnName('role_id'),

            $Country = AdminColumnFilter::select(Country::class, 'Name')
                ->setDisplay('name')
                ->setPlaceholder('Select country')
                ->setColumnName('country_id'),


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
            $avatar = AdminFormElement::image('avatar', 'Avatar')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/avatars';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                })->setValidationRules(['nullable']),
            $email = AdminFormElement::text('email', 'email')
                ->addValidationRule($id ? 'unique:users,email,' . $id : 'unique:users')
                ->setValidationRules(['required', 'max:255']),
            $name = AdminFormElement::text('name', 'Name')->setValidationRules(['required', 'max:255']),
            $birthday = AdminFormElement::date('birthday', 'Birthday')
                ->setValidationRules(['nullable', 'date_format:d-m-Y']),
            $homepage = AdminFormElement::text('homepage', 'Homepage')
                ->setValidationRules(['nullable', 'max:255']),
            $discord = AdminFormElement::text('isq', 'Discord')   // поменять миграцыю потом на discord
            ->setValidationRules(['nullable', 'max:255']),
            $skype = AdminFormElement::text('skype', 'Skype')
                ->setValidationRules(['nullable', 'max:255']),
            $vk_link = AdminFormElement::text('vk_link', 'Vkontakte')
                ->setValidationRules(['nullable', 'max:255', 'url']),
            $fb_link = AdminFormElement::text('fb_link', 'Facebook')
                ->setValidationRules(['nullable', 'max:255', 'url']),
            $role = AdminFormElement::select('role_id', 'Role', Role::class)->setDisplay('title')
                ->setValueSkipped(function () {
                    return is_null(request('role_id'));
                }),
            $Country = AdminFormElement::select('country_id', 'Country', Country::class)->setDisplay('name')
                ->setValueSkipped(function () {
                    return is_null(request('country_id'));
                }),
            $race = AdminFormElement::select('race_id', 'Race', Race::class)->setDisplay('title')
                ->setValueSkipped(function () {
                    return is_null(request('race_id'));
                }),

            $password = AdminFormElement::password('password', 'Password')
                ->setValidationRules(['nullable', 'string', 'min:8', 'max:255'])
                ->setValueSkipped(function () {
                    return is_null(request('password'));
                })
                ->hashWithBcrypt(),
            $passwordConfirm = AdminFormElement::password('password_confirm', 'Password Confirm')
                ->addValidationRule('same:password')
                ->setValueSkipped(true)
        ]);
        return $display;
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
