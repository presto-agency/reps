<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;

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
        return 'fas fa-user';
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
            ->setHtmlAttribute('class', 'table-info table-sm text-center small')
            ->paginate(10);
        $display->setApply(function ($query) {
            $query->orderBy('id', 'desc');
        });
        $display->setFilters([
            AdminDisplayFilter::related('role_id')->setModel(\App\Models\Role::class),
            AdminDisplayFilter::related('ban')->setModel(\App\User::class),
            AdminDisplayFilter::related('email_verified_at')->setModel(\App\User::class),
        ]);

        $display->with('roles', 'countries');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id'),

            $avatar = AdminColumn::image('avatar', 'Avatar'),

            $role_id = AdminColumn::text('roles.title', 'Role'),

            $name = AdminColumn::text('name', 'Name'),

            $email = AdminColumn::text('email', 'Email'),

            $country_id = AdminColumn::relatedLink('countries.name', 'Country'),

            $rating = AdminColumn::text('rating', '<small>Rating</small>')
                ->setWidth(100),

            $count_topic = AdminColumn::text('count_topic', '<small>Topic</small>')
                ->setWidth(100),

            $count_replay = AdminColumn::text('count_replay', '<small>Replay</small>')
                ->setWidth(100),

            $count_picture = AdminColumn::text('count_picture', '<small>Picture</small>')
                ->setWidth(100),

            $count_comment = AdminColumn::text('count_comment', '<small>Comment</small>')
                ->setWidth(100),

            $email_verified_at = AdminColumn::custom('<small>Email<br/>check</small>', function (\App\User $user) {
                return !empty($user->email_verified_at) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->append(AdminColumn::filter('email_verified_at'))
                ->setWidth(70),

            $ban = AdminColumnEditable::checkbox('ban')->setLabel('<small>Ban</small>')
                ->append(AdminColumn::filter('ban'))
                ->setWidth(70),

            $activity_at = AdminColumn::datetime('activity_at', '<small>Last<br/>activity</small>')
                ->setHtmlAttribute('class', 'small')
                ->setFormat('d-m-Y H:i:s')
                ->setWidth(100),
        ]);

        $display->setColumnFilters([
            $id = AdminColumnFilter::text()->setOperator('contains'),
            $avatar = null,
            $role_id = AdminColumnFilter::select($this->role())
                ->setColumnName('role_id')
                ->setPlaceholder('Select'),
            $name = AdminColumnFilter::text()->setOperator('contains')
                ->setPlaceholder('Name'),
            $email = AdminColumnFilter::text()->setOperator('contains')
                ->setPlaceholder('Email'),
            $country = AdminColumnFilter::select($this->country())
                ->setColumnName('country_id')
                ->setPlaceholder('Select'),
            $rating = null,
            $count_topic = null,
            $count_replay = null,
            $count_picture = null,
            $count_comment = null,
        ]);
        $display->getColumnFilters()->setPlacement('table.header');
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
                ->setHtmlAttribute('autocomplete', 'off')
                ->setHtmlAttribute('type', 'email')
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

            $role_id = AdminFormElement::select('role_id', 'Role', $this->role())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Country', $this->country())
                ->setValidationRules(['nullable'])
                ->setValueSkipped(function () {
                    return is_null(request('country_id'));
                }),
            $race_id = AdminFormElement::select('race_id', 'Race', $this->race())
                ->setDisplay('title')
                ->setValidationRules(['nullable'])
                ->setValueSkipped(function () {
                    return is_null(request('race_id'));
                }),
            $password = AdminFormElement::password('password', 'Password')
                ->setHtmlAttribute('autocomplete', 'off')
                ->setValidationRules(['between:8,50', empty($id) ? 'required' : 'nullable'])
                ->allowEmptyValue(),

            $passwordConfirm = AdminFormElement::password('password_confirmation', 'Password Confirm')
                ->setHtmlAttribute('autocomplete', 'off')
                ->setValueSkipped(true)
                ->setValidationRules('same:password'),

            $ban = AdminFormElement::checkbox('ban', 'Ban'),
        ]);


        return $display;
    }


    /**
     * @return FormInterface
     */
    public function onCreate()
    {

        return $this->onEdit('');
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

    private $country, $role, $race;

    public function country()
    {
        foreach (\App\Models\Country::select('id', 'name')->get() as $key => $item) {
            $this->country[$item->id] = $item->name;
        }
        return $this->country;
    }

    public function role()
    {
        foreach (\App\Models\Role::select('id', 'title')->get() as $key => $item) {
            $this->role[$item->id] = $item->title;
        }
        return $this->role;
    }

    public function race()
    {
        foreach (\App\Models\Race::select('id', 'title')->get() as $key => $item) {
            $this->race[$item->id] = $item->title;
        }
        return $this->race;
    }

}
