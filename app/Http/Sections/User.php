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
use App\Services\ServiceAssistants\PathHelper;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
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

    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = true;

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
            ->with([
                'roles',
                'countries',
                'comments',
                'topics',
                'replays',
                'images',
            ])
            ->paginate(20);
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });
        $display->setFilters(
            AdminDisplayFilter::related('ban')->setModel(\App\User::class)
        );

        $display->setColumns([

            $id = AdminColumn::text('id', 'Id')
                ->setWidth(70),

            $avatar = AdminColumn::image(function ($model) {
                if ( ! empty($model->avatar)
                    && PathHelper::checkFileExists($model->avatar)
                ) {
                    return $model->avatar;
                } else {
                    return 'images/default/avatar/avatar.png';
                }
            })->setLabel('Аватар')->setWidth(10),

            $role_id = AdminColumn::text('roles.title', 'Роль'),

            $name = AdminColumn::text('name', 'Имя'),

            $email = AdminColumn::text('email', 'Почта'),

            $country_id = AdminColumn::relatedLink('countries.name', 'Страна')
                ->setWidth(120),

            $rating = AdminColumn::custom('Рейтинг', function ($model) {
                $thumbsUp
                        = '<span style="font-size: 1em; color: green;"><i class="fas fa-plus"></i></span>';
                $equals = '<i class="fas fa-equals"></i>';
                $thumbsDown
                        = '<span style="font-size: 1em; color: red;"><i class="fas fa-minus"></i></span>';

                return $thumbsUp.$model->positive_count.'<br/>'.$equals
                    .($model->positive_count - $model->negative_count).'<br/>'
                    .$thumbsDown.$model->negative_count;
            })->setWidth(10),

            $count_topic = AdminColumn::count('topics',
                '<small>Темы</small>')
                ->setWidth(45),

            $count_replay = AdminColumn::count('replays',
                '<small>Replay</small>')
                ->setWidth(50),

            $count_picture = AdminColumn::count('images',
                '<small>Гале<br/>рея</small>')
                ->setWidth(40),

            $count_comment = AdminColumn::count('comments',
                '<small>Коме<br/>нтарии</small>')
                ->setWidth(55),

            $email_verified_at = AdminColumn::custom('<small>Почта</small>',
                function ($model) {
                    return ! empty($model->email_verified_at)
                        ? '<i class="fa fa-check"></i>'
                        : '<i class="fa fa-minus"></i>';
                })->setFilterCallback(function ($column, $query, $search) {
                if ($search == 'yes') {
                    $query->whereNotNull('email_verified_at');
                }
                if ($search == 'no') {
                    $query->whereNull('email_verified_at');
                }


            })->setWidth(10),

            $ban = AdminColumnEditable::checkbox('ban')
                ->setLabel('<small>Бан</small>')
                ->append(AdminColumn::filter('ban'))
                ->setWidth(10),

            $activity_at = AdminColumn::datetime('activity_at',
                '<small>Акти<br/>вность</small>')
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
        ]);
        $display->getColumnFilters()->setPlacement('table.header');

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
            $avatar = AdminFormElement::image('avatar', 'Аватар')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'storage'
                        .PathHelper::checkUploadsFileAndPath("/images/users/avatars",
                            auth()->user()->avatar);
                })
                ->setValueSkipped(empty(request('avatar')))
                ->setValidationRules([
                    'nullable',
                    'max:2048',
                    'mimes:jpeg,png,jpg,gif,svg',
                ])->setUploadSettings([
                    'orientate' => [],
                    'resize'    => [
                        120,
                        120,
                        function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        },
                    ],
                ])

            ,

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
                    'unique:users,email,'.$id,
                ]),

            $name = AdminFormElement::text('name', 'Имя')
                ->setHtmlAttribute('placeholder', 'Имя')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '3')
                ->setHtmlAttribute('autocomplete', 'off')
                ->setValidationRules([
                    'required',
                    'string',
                    'between:3,30',
                    'unique:users,name,'.$id,
                    'regex:/^[\p{L}0-9,.)\-_\s]+$/u',
                ]),

            $birthday = AdminFormElement::date('birthday', 'День рождения')
                ->setHtmlAttribute('placeholder',
                    Carbon::now()->format('d-m-Y'))
                ->setValidationRules([
                    'nullable',
                    'date_format:d-m-Y',
                ]),

            $homepage = AdminFormElement::text('homepage', 'Homepage')
                ->setHtmlAttribute('placeholder', 'Homepage')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),

            $discord = AdminFormElement::text('isq', 'Discord')
                ->setHtmlAttribute('placeholder', 'Discord')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),

            $skype = AdminFormElement::text('skype', 'Skype')
                ->setHtmlAttribute('placeholder', 'Skype')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),

            $vk_link = AdminFormElement::text('vk_link', 'Vkontakte')
                ->setHtmlAttribute('placeholder', 'Vkontakte')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),

            $fb_link = AdminFormElement::text('fb_link', 'Facebook')
                ->setHtmlAttribute('placeholder', 'Facebook')
                ->setHtmlAttribute('maxlength', '255')
                ->setHtmlAttribute('minlength', '1')
                ->setValidationRules([
                    'nullable',
                    'string',
                    'between:1,255',
                ]),

            $role_id = AdminFormElement::select('role_id', 'Роль')
                ->setOptions($this->getRoles())
                ->setDisplay('title')
                ->setValidationRules(['required']),

            $country_id = AdminFormElement::select('country_id', 'Страна')
                ->setOptions((new Country())->pluck('name', 'id')->toArray())
                ->setDisplay('name'),

            $race_id = AdminFormElement::select('race_id', 'Раса')
                ->setOptions((new Race())->pluck('title', 'id')->toArray())
                ->setDisplay('title'),

            $ban = AdminFormElement::checkbox('ban', 'Ban')
                ->setHtmlAttribute('title',
                    'Внимание! Если пользователь в бане он не может залогиниться.'),
        ]);

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

    /**
     * @return mixed
     */
    public function getRoles()
    {
        if (auth()->user()->superAdminRoles() === true) {
            return (new Role())->pluck('title', 'id')->toArray();
        } else {
            $getData = (new Role())->pluck('title', 'id')->toArray();
            if (($key1 = array_search('Супер-админ', $getData)) !== false) {
                unset($getData[$key1]);
            }
            if (($key2 = array_search('админ', $getData)) !== false) {
                unset($getData[$key2]);
            }

            return $getData;
        }
    }

}
