<?php

namespace App\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use App\Models\Comment;
use App\Models\ForumTopic;
use App\Models\Replay;
use App\Models\UserActivityType;
use App\Models\UserGallery;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Section;

/**
 * Class UserActivityLog
 *
 * @property \App\Models\UserActivityLog $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class UserActivityLog extends Section
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
        return 'fas fa-use';
    }

    public function getTitle()
    {
        return 'Лог активности';
    }

    /**
     * @return \SleepingOwl\Admin\Display\DisplayDatatablesAsync
     * @throws \SleepingOwl\Admin\Exceptions\FilterOperatorException
     */
    public function onDisplay()
    {
        $display = AdminDisplay::datatablesAsync()
            ->setHtmlAttribute('class', 'table-info table-sm text-center')
            ->paginate(25);

        $display->with('types', 'users');
        $display->setApply(function ($query) {
            $query->orderByDesc('id');
        });

        $display->setColumns([
            $type = AdminColumn::text('types.name', 'Событие')
            ->setWidth(150),
            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь')
            ->setWidth(200),
            $time = AdminColumn::datetime('time', 'Время')
            ->setWidth(250),

            $ip = AdminColumn::text('ip',   'IP')
                ->setWidth(150),

            $parameters = AdminColumn::text('Описание', 'Описание'),

//            $parameters = AdminColumn::custom('Описание', function ($model) {
//                return $this->getEventTitle($model);
//            })->setHtmlAttribute('class', 'text-left')
//                ->setWidth(500),
        ]);

        $display->setColumnFilters([
            $type = AdminColumnFilter::select()
                ->setOptions((new UserActivityType())->pluck('name', 'name')->toArray())
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все события')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user_id = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $time = AdminColumnFilter::range()
                ->setFrom(AdminColumnFilter::date()->setPlaceholder('С')
                    ->setFormat('y-m-d '))
                ->setTo(AdminColumnFilter::date()->setPlaceholder('По')
                    ->setFormat('y-m-d'))
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $ip = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('IP')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $parameters = null,


        ]);
        $display->getColumnFilters()->setPlacement('table.header');

        return $display;
    }

    private function getEventTitle($model)
    {
        $parameters = $model->parameters;
//        if ($model->type_id == $this->getTypeId('Like')) {
//            /*Если лайк темы*/
//            return 'Лайк ' . ' Ник ' . 'для ' . 'Тайл темы';
//
//        /*Если лайк кментария*/
//            return 'Лайк коментария' . ' Ник ' . 'для ' . 'Тайл темы';
//        }
        if ($model->type_id == $this->getTypeId('Comment')) {
            return $this->commentDescription($parameters);
        }
        if ($model->type_id == $this->getTypeId('Create Post')) {
            return $this->createPostDescription($parameters);
        }
        if ($model->type_id == $this->getTypeId('Upload Replay')) {
            return $this->uploadReplayDescription($parameters);
        }
        if ($model->type_id == $this->getTypeId('Upload Image')) {
            return $this->uploadImageDescription($parameters);
        }

        return $parameters;

    }

    private $forum_topics = 'forum_topics';
    private $usergallery = 'usergallery';
    private $replays = 'replays';

    /**
     * @param $name
     * @return mixed
     */
    private function getTypeId($name)
    {
        return UserActivityType::where('name', $name)->value('id');
    }

    /**
     * @param $id
     * @return bool|string
     */
    private function likeDescription($id)
    {
        //
    }

    /**
     * @param $id
     * @return bool|string
     */
    private function uploadReplayDescription($id)
    {
        $user_replay = Replay::where('id', $id)->value('title');
        $for = 'Replay ';
        if (!empty($user_replay)) {
            return $this->link($for, $this->replays, $id, $user_replay);
        }
        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     * @return bool|string
     */
    private function createPostDescription($id)
    {
        $for = 'Пост ';
        $title = ForumTopic::where('id', $id)->value('title');
        if (!empty($title)) {
            return $this->link($for, $this->forum_topics, $id, $title);
        }
        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     * @return bool|string
     */
    private function uploadImageDescription($id)
    {
        $for = 'Изображение ';
        $sign = UserGallery::where('id', $id)->value('sign');

        if (!empty($sign)) {
            return $this->link($for, $this->usergallery, $id, $sign);
        }
        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     * @return bool|string
     */
    private function commentDescription($id)
    {
        $for = 'Коментарий для ';
        $data = Comment::find($id);
        if (!empty($data)) {
            $commentable = $data->commentable;
            $showId = $commentable->id;
            $className = $this->getClassName($commentable);
            if ($className == 'Replay') {
                return $this->link($for, $this->replays, $showId, $commentable->title);
            }
            if ($className == 'ForumTopic') {
                return $this->link($for, $this->forum_topics, $showId, $commentable->title);
            }
            if ($className == 'UserGallery') {
                return $this->link($for, $this->usergallery, $showId, $commentable->sign);
            }
        }
        return $this->link($for, null, null, null);
    }

    /**
     * @param $object
     * @return mixed
     */
    private function getClassName($object)
    {
        $parseObjectPath = explode('\\', get_class($object));
        return $getClassName = end($parseObjectPath);
    }

    /**
     * @param $for
     * @param $urlPart
     * @param $id
     * @param $linkTitle
     * @return string
     */
    private function link($for, $urlPart, $id, $linkTitle)
    {
        $url = url("admin/$urlPart/show/" . $id);
        $link = "<a href='$url'>$linkTitle</a>";
        return $for . $link;
    }
}
