<?php


Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Главная', route('home.index'));
});

Breadcrumbs::register('forum-index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Форум', route('forum.index'));
});

Breadcrumbs::register('forum-show', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('forum-index');
    $breadcrumbs->push('Раздел', route('forum.show', $forum));
});

Breadcrumbs::register('topic-show', function ($breadcrumbs, $topic, $forumId) {
    $breadcrumbs->parent('forum-show', $forumId);
    $breadcrumbs->push('Тема', route('topic.show', $topic));
});

Breadcrumbs::register('replay', function ($breadcrumbs, $type) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Реплеи', route('replay.index', [
        'type' => $type,
    ]));
});

Breadcrumbs::register('replay-show', function ($breadcrumbs, $replay, $type) {
    $breadcrumbs->parent('replay', $type);
    $breadcrumbs->push('Реплей', route('replay.show', [
        'replay' => $replay,
        'type'   => $type,
    ]));
});


Breadcrumbs::register('news', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Новости', route('news.index'));
});
Breadcrumbs::register('topic-news-show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('news');
    $breadcrumbs->push('Новость', route('news.show', ['news' => $id]));
});

Breadcrumbs::register('tournament', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Турниры', route('tournament.index'));
});
Breadcrumbs::register('tournament-show', function ($breadcrumbs) {
    $breadcrumbs->parent('tournament');
    $breadcrumbs->push('Турнир',
        route('tournament.show', ['id' => request('tournament')]));
});

Breadcrumbs::register('best', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Лучшие', route('best.index'));
});
Breadcrumbs::register('gallery-index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Все галереи', route('galleries.index'));
});
Breadcrumbs::register('gallery-show', function ($breadcrumbs, $gallery) {
    $breadcrumbs->parent('gallery-index');
    $breadcrumbs->push('Картинка',
        route('galleries.show', ['gallery' => $gallery]));
});


/***
 *
 * -----USER CABINET-----
 *
 */

Breadcrumbs::register('user-profile-show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Личный кабинет', route('user_profile', [
        'id' => $id,
    ]));
});
Breadcrumbs::register('user-friends', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Мои друзья', route('user.friends_list.by_id', [
        'id' => $id,
    ]));
});
Breadcrumbs::register('user-edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Настройки пользователя', route('edit_profile', [
        'id' => $id,
    ]));
});

Breadcrumbs::register('user-rating-list', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Репутация пользователя',
        route('user-rating-list.index', [
            'id' => $id,
        ]));
});

Breadcrumbs::register('user-topic-rating-list', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Информация',
        route('user-topic-rating-list.index', [
            'id' => $id,
        ]));
});

Breadcrumbs::register('user-comments', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Посты пользователя', route('user-comments.index', [
        'id' => $id,
    ]));
});

Breadcrumbs::register('user-topics', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Темы пользователя', route('user-topics.index', [
        'id' => $id,
    ]));
});
Breadcrumbs::register('user-topics-create', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-topics', $id);
    $breadcrumbs->push('Создать тему', route('user-topics.create', [
        'id' => $id,
    ]));
});
Breadcrumbs::register('user-topics-edit',
    function ($breadcrumbs, $id, $user_topic) {
        $breadcrumbs->parent('user-topics', $id);
        $breadcrumbs->push('Редактировать тему пользователя',
            route('user-topics.edit', [
                'id'         => $id,
                'user_topic' => $user_topic,
            ]));
    });

Breadcrumbs::register('user-replay', function ($breadcrumbs, $id, $type) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Реплеи пользователя',
        asset(url("user/$id/user-replay/?type=$type")));
});

Breadcrumbs::register('user-replay-create',
    function ($breadcrumbs, $id, $user_replay, $type) {
        $breadcrumbs->parent('user-replay', $id, $type);
        $breadcrumbs->push('Реплей пользователя', route('user-replay.create', [
            'id'          => $id,
            'user_replay' => $user_replay,
        ]));
    });

Breadcrumbs::register('user-replay-edit',
    function ($breadcrumbs, $id, $user_replay, $type) {
        $breadcrumbs->parent('user-replay', $id, $type);
        $breadcrumbs->push('Реплей пользователя', route('user-replay.edit', [
            'id'          => $id,
            'user_replay' => $user_replay,
        ]));
    });

Breadcrumbs::register('user-replay-show',
    function ($breadcrumbs, $id, $user_replay, $type) {
        $breadcrumbs->parent('user-replay', $id, $type);
        $breadcrumbs->push('Реплей пользователя', route('user-replay.show', [
            'id'          => $id,
            'user_replay' => $user_replay,
        ]));
    });


Breadcrumbs::register('user-gallery-index', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Галерея', route('user-gallery.index', [
        'id' => $id,
    ]));
});

Breadcrumbs::register('user-gallery-show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-gallery-index', $id);
    $breadcrumbs->push('Картинка');
});

