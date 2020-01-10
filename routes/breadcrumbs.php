<?php

/***
 *
 * HOME
 *
 */
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Главная', route('home.index'));
});

/***
 *
 * >-----FORUM SECTION INDEX
 *
 */
Breadcrumbs::register('forum-sections-index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Темы форума', route('forum.index'));
});

/***
 *
 * >-----FORUM SECTION INDEX-----FORUM SECTION SHOW
 *
 */
Breadcrumbs::register('forum-sections-show', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('forum-sections-index');
    $breadcrumbs->push('Тема', route('forum.show', $forum));
});

/***
 *
 * >-----FORUM SECTION SHOW-----FORUM TOPIC SHOW
 *
 */
Breadcrumbs::register('forum-topic-show', function ($breadcrumbs, $forum) {
    $breadcrumbs->parent('forum-sections-show', $forum);
    $breadcrumbs->push('Пост');
});

/***
 *
 * >-----NEWS INDEX
 *
 */
Breadcrumbs::register('topic-news-index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Новости', route('news.index'));
});

/***
 *
 * >-----FORUM NEWS INDEX-----FORUM NEWS SHOW
 *
 */
Breadcrumbs::register('topic-news-show', function ($breadcrumbs) {
    $breadcrumbs->parent('topic-news-index');
    $breadcrumbs->push('Новость');
});
/***
 *
 * >-----REPLAY INDEX
 *
 */
Breadcrumbs::register('replay-index', function ($breadcrumbs, $type) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Реплеи', route('replay.index', [
        'type' => $type,
    ]));
});

/***
 *
 * >-----REPLAY INDEX-----REPLAY SHOW
 *
 */

Breadcrumbs::register('replay-show', function ($breadcrumbs, $type) {
    $breadcrumbs->parent('replay-index', $type);
    $breadcrumbs->push('Реплей');
});

/***
 *
 * >-----REPLAY SEARCH
 *
 */
Breadcrumbs::register('replay-search', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Поиск по реплеям');
});


Breadcrumbs::register('tournament', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Турниры', route('tournament.index'));
});
Breadcrumbs::register('tournament-show', function ($breadcrumbs) {
    $breadcrumbs->parent('tournament');
    $breadcrumbs->push('Турнир', route('tournament.show', ['tournament' => request('tournament')]));
});


/***
 *
 * >-----BEST INDEX
 *
 */

Breadcrumbs::register('best', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Лучшие');
});

/***
 *
 * >-----GALLERY INDEX
 *
 */
Breadcrumbs::register('gallery-index', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Все картинки', route('galleries.index'));
});

/***
 *
 * >-----GALLERY INDEX----->GALLERY SHOW
 *
 */
Breadcrumbs::register('gallery-show', function ($breadcrumbs) {
    $breadcrumbs->parent('gallery-index');
    $breadcrumbs->push('Картинка');
});


/***
 *
 * >-----USER PROFILE-----USER PROFILE SHOW
 *
 */

Breadcrumbs::register('user-profile-show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Профиль пользователя', route('user_profile', [
        'id' => $id,
    ]));
});
/***
 *
 * >-----USER PROFILE-----USER PROFILE EDIT
 *
 */
Breadcrumbs::register('user-edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Настройки пользователя');
});

Breadcrumbs::register('user-friends', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Мои друзья', route('user.friends_list.by_id', [
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

Breadcrumbs::register('user-topic-rating-list', function ($breadcrumbs, $id, $userId) {
    $breadcrumbs->parent('user-topics', $userId);
    $breadcrumbs->push('Информация',
        route('forum.topic.get_rating', [
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
Breadcrumbs::register('user-topics-edit', function ($breadcrumbs, $id, $user_topic) {
    $breadcrumbs->parent('user-topics', $id);
    $breadcrumbs->push('Редактировать тему пользователя', route('user-topics.edit', [
        'id'         => $id,
        'user_topic' => $user_topic,
    ]));
});

/***
 *
 * >-----USER PROFILE----->USER REPLAY INDEX
 *
 */
Breadcrumbs::register('user-replay-index', function ($breadcrumbs, $id, $type) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Реплеи пользователя', route('user-replay.index', [
        'id'   => $id,
        'type' => $type,
    ]));
});
/***
 *
 * >-----USER REPLAY INDEX----->USER REPLAY CREATE
 *
 */
Breadcrumbs::register('user-replay-create', function ($breadcrumbs, $id, $type) {
    $breadcrumbs->parent('user-replay-index', $id, $type);
    $breadcrumbs->push('Создать новый Replay');
});
/***
 *
 * >-----USER REPLAY INDEX----->USER REPLAY EDIT
 *
 */
Breadcrumbs::register('user-replay-edit', function ($breadcrumbs, $id, $type) {
    $breadcrumbs->parent('user-replay-index', $id, $type);
    $breadcrumbs->push('Редактировать Replay');
});

/***
 *
 * >-----USER PROFILE----->USER GALLERY INDEX
 *
 */

Breadcrumbs::register('user-gallery-index', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-profile-show', $id);
    $breadcrumbs->push('Галерея', route('user-gallery.index', [
        'id' => $id,
    ]));
});

/***
 *
 * >-----USER GALLERY INDEX----->USER GALLERY SHOW
 *
 */
Breadcrumbs::register('user-gallery-show', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('user-gallery-index', $id);
    $breadcrumbs->push('Просмотр картинки');
});


