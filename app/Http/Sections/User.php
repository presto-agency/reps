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
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
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
        return 'Список';
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
            AdminDisplayFilter::related('ban')->setModel(\App\User::class),
        ]);

        $display->with('roles', 'countries');

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(70),

            $avatar = AdminColumn::image('avatar', 'Аватар'),

            $role_id = AdminColumn::text('roles.title', 'Роль'),

            $name = AdminColumn::text('name', 'Имя'),

            $email = AdminColumn::text('email', 'Почта'),

            $country_id = AdminColumn::relatedLink('countries.name', 'Страна')
                ->setWidth(120),

            $rating = AdminColumn::custom('Рейтинг', function ($model) {
                $positive = $model->negative_count;
                $negative = $model->positive_count;
                $result = $positive - $negative;
                $thumbsUp = '<span style="font-size: 1em; color: green;"><i class="fas fa-plus"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="fas fa-minus"></i></span>';
                return "{$thumbsUp}" . "({$positive})" . '<br/>' . "{$equals}" . "({$result})" . '<br/>' . "{$thumbsDown}" . "({$negative})";
            })->setWidth(10),

            $count_topic = AdminColumn::text('count_topic', '<small>Темы</small>')
                ->setWidth(45),

            $count_replay = AdminColumn::text('count_replay', '<small>Replay</small>')
                ->setWidth(50),

            $count_picture = AdminColumn::text('count_picture', '<small>Гале<br/>рея</small>')
                ->setWidth(40),

            $count_comment = AdminColumn::text('count_comment', '<small>Коме<br/>нтарии</small>')
                ->setWidth(55),

            $email_verified_at = AdminColumn::custom('<small>Почта</small>', function ($model) {
                return !empty($model->email_verified_at) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-minus"></i>';
            })->setFilterCallback(function ($column, $query, $search) {
                if ($search == 1) {
                    $query->whereNotNull('email_verified_at');
                }
                if ($search == 0) {
                    $query->whereNull('email_verified_at');
                }
                if (empty($search)) {
                    $query->get();
                }

            })->setWidth(10),

            $ban = AdminColumnEditable::checkbox('ban')->setLabel('<small>Бан</small>')
                ->append(AdminColumn::filter('ban'))
                ->setWidth(10),

            $activity_at = AdminColumn::datetime('activity_at', '<small>Акти<br/>вность</small>')
                ->setHtmlAttribute('class', 'small')
                ->setFormat('d-m-Y H:i:s')
                ->setWidth(50),
        ]);

        $display->setColumnFilters([
            $id = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('ID')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $avatar = null,
            $role_id = AdminColumnFilter::select()
                ->setOptions((new Role())->pluck('title', 'title')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все роли')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $name = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Name')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $email = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Email')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $country = AdminColumnFilter::select()
                ->setOptions((new Country())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все страны')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $rating = null,
            $count_topic = null,
            $count_replay = null,
            $count_picture = null,
            $count_comment = null,
            $email_verified_at = AdminColumnFilter::select()
                ->setOptions($this->emailVr())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все')
                ->setHtmlAttributes(['style' => 'width: 100%']),
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
                    return 'storage/image/user/avatar';
                })
                ->setUploadFileName(function (UploadedFile $file) {
                    return uniqid() . Carbon::now()->timestamp . '.' . $file->getClientOriginalExtension();
                }),

            $email = AdminFormElement::text('email', 'Email')
                ->setHtmlAttribute('autocomplete', 'off')
                ->setHtmlAttribute('type', 'email')
                ->setValidationRules(['required', 'email', 'max:255', 'unique:users,email,' . $id]),

            $name = AdminFormElement::text('name', 'Name')
                ->setValidationRules(['required', 'max:255', 'alpha_dash', 'unique:users,name,' . $id]),

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

    private $role, $country, $race, $emailVr;

    public function role()
    {
        foreach (Role::get(['id', 'title']) as $item) {
            $this->role[$item->id] = $item->title;
        }
        return $this->role;
    }

    public function country()
    {
        foreach (Country::get(['id', 'name']) as $item) {
            $this->country[$item->id] = $item->name;
        }
        return $this->country;
    }

    public function race()
    {
        foreach (Race::get(['id', 'title']) as $item) {
            $this->race[$item->id] = $item->title;
        }
        return $this->race;
    }

    public function emailVr()
    {
        $this->emailVr = [
            1 => 'Да',
            0 => 'Нет',
        ];
        return $this->emailVr;
    }

}
