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
use SleepingOwl\Admin\Contracts\Display\Extension\FilterInterface;
use SleepingOwl\Admin\Display\DisplayDatatablesAsync;
use SleepingOwl\Admin\Exceptions\FilterOperatorException;
use SleepingOwl\Admin\Section;

/**
 * Class UserActivityLog
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 * @property \App\Models\UserActivityLog $model
 *
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

    public $types;
    /**
     * @return DisplayDatatablesAsync
     * @throws FilterOperatorException
     */
    public function onDisplay()
    {

        $getData = $this->getModel();
        if ($getData) {
            $this->types = $getData::$eventType;
        }
        $display = AdminDisplay::datatablesAsync()
            ->setDatatableAttributes(['bInfo' => false])
            ->setHtmlAttribute('class', 'table-info text-center')
            ->with(['users'])
            ->paginate(25);
        $display->setApply(function ($query) {
            $query->orderBy('time', 'desc');
        });
        $display->setColumns([
            $type = AdminColumn::text('type', 'Событие')
                ->setWidth(150),
            $user_id = AdminColumn::relatedLink('users.name', 'Пользователь')
                ->setWidth(200),
            $time = AdminColumn::datetime('time', 'Время')
                ->setWidth(250),

            $ip = AdminColumn::text('ip', 'IP')
                ->setWidth(150),

            $parameters = AdminColumn::custom('Описание', function ($model) {
                return $this->getEventTitle($model);
            })->setHtmlAttribute('class', 'text-left'),
        ]);

        $display->setColumnFilters([
            $type = AdminColumnFilter::select()
                ->setOptions($this->types)
                ->setOperator(FilterInterface::EQUAL)
                ->setPlaceholder('Все события')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $user_id = AdminColumnFilter::text()
                ->setOperator(FilterInterface::CONTAINS)
                ->setPlaceholder('Пользователь')
                ->setHtmlAttributes(['style' => 'width: 100%']),
            $time = AdminColumnFilter::range()
                ->setFrom(AdminColumnFilter::date()->setPlaceholder('С')
                    ->setFormat('Y-m-d '))
                ->setTo(AdminColumnFilter::date()->setPlaceholder('По')
                    ->setFormat('Y-m-d'))
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
        $test  = json_decode($model->parameters);
        $test2 = ! empty($test->description) === true ? $test->description : '';

        return $test2;

    }

    private $forum_topics = 'forum_topics';
    private $usergallery = 'usergallery';
    private $replays = 'replays';

    /**
     * @param $name
     *
     * @return mixed
     */
    private function getTypeId($name)
    {
        return UserActivityType::where('name', $name)->value('id');
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    private function likeDescription($id)
    {
        //
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    private function uploadReplayDescription($id)
    {
        $user_replay = Replay::where('id', $id)->value('title');
        $for         = 'Replay ';
        if ( ! empty($user_replay)) {
            return $this->link($for, $this->replays, $id, $user_replay);
        }

        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    private function createPostDescription($id)
    {
        $for   = 'Пост ';
        $title = ForumTopic::where('id', $id)->value('title');
        if ( ! empty($title)) {
            return $this->link($for, $this->forum_topics, $id, $title);
        }

        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    private function uploadImageDescription($id)
    {
        $for  = 'Изображение ';
        $sign = UserGallery::where('id', $id)->value('sign');

        if ( ! empty($sign)) {
            return $this->link($for, $this->usergallery, $id, $sign);
        }

        return $this->link($for, null, null, null);
    }

    /**
     * @param $id
     *
     * @return bool|string
     */
    private function commentDescription($id)
    {
        $for  = 'Коментарий для ';
        $data = Comment::find($id);
        if ( ! empty($data)) {
            $commentable = $data->commentable;
            $showId      = $commentable->id;
            $className   = $this->getClassName($commentable);
            if ($className == 'Replay') {
                return $this->link($for, $this->replays, $showId,
                    $commentable->title);
            }
            if ($className == 'ForumTopic') {
                return $this->link($for, $this->forum_topics, $showId,
                    $commentable->title);
            }
            if ($className == 'UserGallery') {
                return $this->link($for, $this->usergallery, $showId,
                    $commentable->sign);
            }
        }

        return $this->link($for, null, null, null);
    }

    /**
     * @param $object
     *
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
     *
     * @return string
     */
    private function link($for, $urlPart, $id, $linkTitle)
    {
        $url  = url("admin/$urlPart/show/".$id);
        $link = "<a href='$url'>$linkTitle</a>";

        return $for.$link;
    }

}
