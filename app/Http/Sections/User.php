<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnEditable;
use AdminColumnFilter;
use AdminDisplay;
use AdminDisplayFilter;
use AdminForm;
use AdminFormElement;
use App\Models\{Country, Race, Role};
use Carbon\Carbon;
use checkFile;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Display\ControlLink;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Section;

/**
 * Class User
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\User $model
 *
 */
class User extends Section
{

    public $imageOldPath;
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;

    protected $alias = false;

    protected $title = 'Список';


    /**
     * @return DisplayDatatablesAsync
     * @throws Exception
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatables()
            ->setName('usertables')
            ->setOrder([[0, 'desc']])
            ->setDisplaySearch(false)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
            ->setHtmlAttribute('class', 'text-center small')
            ->with(
                [
                    'roles', 'countries',
                ]
            )
            ->paginate(5);

        $display->setFilters(
            AdminDisplayFilter::related('ban')
                ->setModel(\App\User::class)
        );

        $display->setColumns([
                $id = AdminColumn::text('id', 'ID')->setWidth('85px'),

                $avatar = AdminColumn::image(function ($model) {
                    return $model->avatarOrDefault();
                })->setLabel('Аватар'),

                $role_id = AdminColumn::text('roles.title', 'Роль')
                    ->setWidth('150px'),

                $name = AdminColumn::text('name', 'Имя'),

                $email = AdminColumn::email('email', 'Почта'),

                $country_id = AdminColumn::relatedLink('countries.name', 'Страна')
                    ->setWidth('100px'),

                $rating = AdminColumn::custom('Рейтинг', function ($model) {
                    $thumbsUp   = '<span style="font-size: 1em; color: green;"><i class="fas fa-plus"></i></span>';
                    $equals     = '<i class="fas fa-equals"></i>';
                    $thumbsDown = '<span style="font-size: 1em; color: red;"><i class="fas fa-minus"></i></span>';

                    return $thumbsUp."$model->count_positive".
                        '<br/>'.$equals."$model->rating".
                        '<br/>'.$thumbsDown."$model->count_negative";
                }),

                $count_topic = AdminColumn::custom('Топики', function ($model) {
                    return $model->topicsCount();
                }),
                $count_replay = AdminColumn::custom('Реплеи', function ($model) {
                    return $model->replaysCount();
                }),
                $count_picture = AdminColumn::custom('Галерея', function ($model) {
                    return $model->imagesCount();
                }),
                $count_comment = AdminColumn::custom('Коментарии', function ($model) {
                    return $model->commentsCount();
                }),
                $email_verified_at = AdminColumn::custom('Почта', function ($model) {
                    return ! empty($model->email_verified_at) ? '<i class="fa fa-check"></i>'
                        : '<i class="fa fa-minus"></i>';
                })->setFilterCallback(function ($column, $query, $search) {
                    if ($search == 'yes') {
                        $query->whereNotNull('email_verified_at');
                    }
                    if ($search == 'no') {
                        $query->whereNull('email_verified_at');
                    }
                }),

                $gas_balance = AdminColumn::text('gas_balance', 'Gas'),

                $ban = AdminColumnEditable::checkbox('ban')
                    ->setLabel('Бан')
                    ->append(AdminColumn::filter('ban'))
                    ->setWidth('45px'),

                $activity_at = AdminColumn::datetime('activity_at', 'Last<br>activity')
                    ->setHtmlAttribute('class', 'small')
                    ->setFormat('d-m-Y H:i:s')
                    ->setWidth('75px'),
            ]
        );

        $display->setColumnFilters(
            [
                $id = AdminColumnFilter::text()
                    ->setOperator(FilterInterface::EQUAL)
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
                    ->setPlaceholder('Имя')
                    ->setHtmlAttributes(['style' => 'width: 100%']),
                $email = AdminColumnFilter::text()
                    ->setOperator(FilterInterface::CONTAINS)
                    ->setPlaceholder('Почта')
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
                    ->setHtmlAttributes(['style' => 'width: 100%']),
            ]
        );
        $display->getColumnFilters()->setPlacement('table.header');


        $control    = $display->getColumns()->getControlColumn();
        $buttonShow = $this->show();
        $control->addButton($buttonShow);

        $linkGas = new ControlLink(function ($model) {
            $url = asset('admin/gas_transactions');

            return $url.'?user_id='.$model->getKey();
        }, 'Газ', 50);
        $linkGas->hideText();
        $linkGas->setIcon('fa fa-eye');
        $linkGas->setHtmlAttribute('class', 'btn-info');
        $control->addButton($linkGas);

        return $display;
    }

    public $id;

    /**
     * @param  int  $id
     *
     * @return FormInterface
     */
    public function onEdit($id)
    {
        $this->id = $id;
        $getData  = $this->getModel()->select('avatar')->find($id);
        if ($getData) {
            $this->imageOldPath = $getData->avatar;
        }

        $display = AdminForm::panel();
        $display->setItems(
            [
                $avatar = AdminFormElement::image('avatar', 'Аватар')
                    ->setUploadPath(function (UploadedFile $file) {
                        $now   = \Carbon\Carbon::now();
                        $pathC = $now->format('F').$now->year;

                        return 'storage'.checkFile::checkUploadsFileAndPath("/images/users/avatars/{$pathC}",
                                $this->imageOldPath);
                    }
                    )
                    ->setValueSkipped(empty(request('avatar')))
                    ->setValidationRules(
                        [
                            'nullable',
                            'max:2048',
                            'mimes:jpeg,png,jpg,gif,svg',
                        ]
                    ),

                $email = AdminFormElement::text('email', 'Почта')
                    ->setHtmlAttribute('placeholder', 'Почта')
                    ->setHtmlAttribute('autocomplete', 'off')
                    ->setHtmlAttribute('maxlength', '30')
                    ->setHtmlAttribute('type', 'email')
                    ->setValidationRules([
                        'required',
                        'string',
                        'email',
                        'max:255',
                        'unique:users,email,'.$this->id,
                    ]),

                $name = AdminFormElement::text('name', 'Имя')
                    ->setHtmlAttribute('placeholder', 'Имя')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setHtmlAttribute('autocomplete', 'off')
                    ->setValidationRules(
                        [
                            'required',
                            'string',
                            'between:1,255',
                            'unique:users,name,'.$this->id,
                        ]
                    ),

                $birthday = AdminFormElement::date('birthday', 'День рождения')
                    ->setHtmlAttribute(
                        'placeholder',
                        Carbon::now()->format('d-m-Y')
                    )
                    ->setValidationRules(
                        [
                            'nullable',
                            'date_format:d-m-Y',
                        ]
                    ),

                $homepage = AdminFormElement::text('homepage', 'Homepage')
                    ->setHtmlAttribute('placeholder', 'Homepage')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setValidationRules(
                        [
                            'nullable',
                            'string',
                            'between:1,255',
                        ]
                    ),

                $discord = AdminFormElement::text('isq', 'Discord')
                    ->setHtmlAttribute('placeholder', 'Discord')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setValidationRules(
                        [
                            'nullable',
                            'string',
                            'between:1,255',
                        ]
                    ),

                $skype = AdminFormElement::text('skype', 'Skype')
                    ->setHtmlAttribute('placeholder', 'Skype')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setValidationRules(
                        [
                            'nullable',
                            'string',
                            'between:1,255',
                        ]
                    ),

                $vk_link = AdminFormElement::text('vk_link', 'Vkontakte')
                    ->setHtmlAttribute('placeholder', 'Vkontakte')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setValidationRules(
                        [
                            'nullable',
                            'string',
                            'between:1,255',
                        ]
                    ),

                $fb_link = AdminFormElement::text('fb_link', 'Facebook')
                    ->setHtmlAttribute('placeholder', 'Facebook')
                    ->setHtmlAttribute('maxlength', '255')
                    ->setHtmlAttribute('minlength', '1')
                    ->setValidationRules(
                        [
                            'nullable',
                            'string',
                            'between:1,255',
                        ]
                    ),


                $role_id = AdminFormElement::select('role_id', 'Роль')
                    ->setOptions($this->getRoles())
                    ->setDisplay('title')
                    ->setValidationRules(['required', 'exists:roles,id']),

                $country_id = AdminFormElement::select('country_id', 'Страна')
                    ->setOptions(
                        (new Country())->pluck('name', 'id')->toArray()
                    )
                    ->setDisplay('name')
                    ->setValidationRules(['nullable', 'exists:countries,id']),

                $race_id = AdminFormElement::select('race_id', 'Раса')
                    ->setOptions((new Race())->pluck('title', 'id')->toArray())
                    ->setValidationRules(['nullable', 'exists:races,id'])
                    ->setDisplay('title'),

                $ban = AdminFormElement::checkbox('ban', 'Ban')
                    ->setHtmlAttribute(
                        'title',
                        'Внимание! Если пользователь в бане он не сможет зайти'
                    ),
            ]
        );

        return $display;
    }


    //    /**
    //     * @return FormInterface
    //     */
    //    public function onCreate()
    //    {
    //
    //        return $this->onEdit('');
    //    }

    /**
     * @return void
     */
    public function onDelete($id)
    {
    }

    /**
     * @return void
     */
    public function onRestore($id)
    {
        // remove if unused
    }

    /**
     * @var
     */
    private $emailVr;

    /**
     * @return array
     */
    public function emailVr()
    {
        $this->emailVr = [
            'all' => 'Все',
            'yes' => 'Да',
            'no'  => 'Нет',

        ];

        return $this->emailVr;
    }

    public $roles;

    /**
     * @return mixed
     */
    public function getRoles()
    {
        $this->roles = (new Role())->pluck('title', 'id')->toArray();
        if (auth()->user()->superAdminRole() === true) {
            return $this->roles;
        } else {
            if (($key1 = array_search('Супер-админ', $this->roles)) !== false) {
                unset($this->roles[$key1]);
            }
            if (($key2 = array_search('Админ', $this->roles)) !== false) {
                unset($this->roles[$key2]);
            }

            return $this->roles;
        }
    }

    /**
     * @return ControlLink
     */
    public function show()
    {
        $link = new ControlLink(
            function (
                Model $model
            ) {
                //            return asset('/admin/users/'.$model->getKey().'/send-email-create');
                return route(
                    'admin.user.email-send.create',
                    ['id' => $model->getKey()]
                );
            }, 'Написать Email', 50
        );
        $link->hideText();
        $link->setIcon('far fa-envelope-open');
        $link->setHtmlAttribute('class', 'btn-info');

        return $link;
    }

}
