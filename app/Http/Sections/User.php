<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\Country;
use App\Models\Race;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Section;

/**
 * Class User
 *
 * @property \App\User $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class User extends Section
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
        return parent::getIcon();
    }

    public function getTitle()
    {
        return parent::getTitle();
    }

    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \Exception
     */
    public function onDisplay()
    {

        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setDisplaySearch(true)
            ->setHtmlAttribute('class', 'table-info table-hover text-center')
            ->paginate(50);

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth('15px'),

            $avatar = AdminColumn::image('avatar', 'Avatar')
                ->setWidth('50px'),

            $name = AdminColumn::text('name', 'Name')
                ->setWidth('50px'),

            $email = AdminColumn::text('email', 'Email')
                ->setWidth('50px'),

            $role_id = AdminColumn::text('roles.title', 'Role')
                ->setWidth('50px'),

            $country_id = AdminColumn::relatedLink('countries.name', 'Country')
                ->setWidth('50px'),

            $rating = AdminColumn::text('rating', 'Rating')
                ->setWidth('50px'),

            $count_topic = AdminColumn::text('count_topic', 'Topic')
                ->setWidth('50px'),

            $count_replay = AdminColumn::text('count_replay', 'Replay')
                ->setWidth('50px'),

            $count_picture = AdminColumn::text('count_picture', 'Picture')
                ->setWidth('50px'),

            $count_comment = AdminColumn::text('count_comment', 'Comment')
                ->setWidth('50px'),

            $email_check = AdminColumn::custom('Email check<br/>', function ($instance) {
                return $instance->active ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setWidth('10px'),

            $ban = AdminColumnEditable::checkbox('ban', 'Ban')
                ->setWidth('10px'),

            $activity_at = AdminColumn::datetime('activity_at', 'Last activity')
                ->setFormat('d-m-Y')
                ->setWidth('50px'),
        ]);

        $display->setColumnFilters([
            $id = null,
            $avatar = null,
            $name = null,
            $email = null,
            $role = AdminColumnFilter::select(Role::class, 'Title')
                ->setDisplay('title')
                ->setColumnName('role_id')
                ->setPlaceholder('Select role'),

            $Country = AdminColumnFilter::select(Country::class, 'Name')
                ->setDisplay('name')
                ->setColumnName('country_id')
                ->setPlaceholder('Select country'),


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
            /*Init FormElement*/

            $avatar = AdminFormElement::image('avatar', 'Avatar')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage/avatars';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                }),

            $email = AdminFormElement::text('email', 'Email')
                ->setValidationRules(['required', 'email', 'max:30', 'unique:users,email,' . $id]),

            $name = AdminFormElement::text('name', 'Name')
                ->setValidationRules(['required', 'string', 'alpha_dash', 'unique:users,name,' . $id]),

            $birthday = AdminFormElement::date('birthday', 'Birthday')
                ->setValidationRules(['nullable', 'date_format:d-m-Y']),

            $homepage = AdminFormElement::text('homepage', 'Homepage')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $discord = AdminFormElement::text('isq', 'Discord')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $skype = AdminFormElement::text('skype', 'Skype')
                ->setValidationRules(['nullable', 'string', 'max:255']),

            $vk_link = AdminFormElement::text('vk_link', 'Vkontakte')
                ->setValidationRules(['nullable', 'string', 'max:255', 'url']),

            $fb_link = AdminFormElement::text('fb_link', 'Facebook')
                ->setValidationRules(['nullable', 'string', 'max:255', 'url']),

            $role_id = AdminFormElement::select('role_id', 'Role', Role::class)
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Country', Country::class)
                ->setDisplay('name')
                ->setValidationRules(['nullable'])
                ->setValueSkipped(function () {
                    return is_null(request('country_id'));
                }),
            $race_id = AdminFormElement::select('race_id', 'Race', Race::class)
                ->setDisplay('title')
                ->setValidationRules(['nullable'])
                ->setValueSkipped(function () {
                    return is_null(request('race_id'));
                }),
            $password = AdminFormElement::password('password', 'Password')
                ->setValidationRules(['between:8,50', empty($id) ? 'required' : 'nullable'])
                ->setValueSkipped(function () {
                    return is_null(request('password'));
                }),

            $passwordConfirm = AdminFormElement::password('password_confirmation', 'Password Confirm')
                ->setValueSkipped(true)
                ->setValidationRules('same:password'),
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
