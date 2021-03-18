<?php

namespace App\Models;

use App\Services\ImageService\ResizeImage;
use App\User;
use Carbon\Carbon;
use checkFile;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Log;
use Str;
use Symfony\Component\HttpFoundation\File\File;

class ForumTopic extends Model
{

    protected $fillable
        = [
            'title', 'forum_section_id', 'reviews', 'rating',
            'preview_content', 'preview_img', 'content',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'seo_og_image',
        ];
    protected $guarded = ['user_id', 'commented_at', 'hide', 'news', 'start_on', 'fixing', 'important'];

    public static function getSeoIconData(ForumTopic $model): array
    {
        $img = 'images/logo.png';
        if (!empty($model->preview_img) && checkFile::checkFileExists($model->preview_img)) {
            $img = $model->preview_img;
        }
        $icon = $img;
        if (!empty($model->seo_og_image) && checkFile::checkFileExists($model->seo_og_image)) {
            $icon = $model->seo_og_image;
        }

        return [
            'path' => asset($icon),
            'type' => 'image/'.\File::extension($icon),
        ];
    }

    /**
     * @param $path
     * @return string
     */
    public static function getOgIconPath($path): string
    {
        $filePath = '';
        if (!empty($path) && \File::exists($path)) {
            try {
                $file = new File($path);
                $now = Carbon::now();
                $pathC = $now->format('F').$now->year;
                $filePath = ResizeImage::resizeImg($file, 400, 300, true, "images/topics/og/{$pathC}/");
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $filePath;
    }

    public static function setPreviewImgForList($path): string
    {
        $filePath = '';
        if (!empty($path) && \File::exists($path)) {
            try {
                $file = new File($path);
                $now = Carbon::now();
                $pathC = $now->format('F').$now->year;
                $filePath = ResizeImage::resizeImg($file, 500, null, true, "images/topics/{$pathC}/preview/", true);
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        return $filePath;
    }

    public function forumSection()
    {
        return $this->belongsTo(ForumSection::class, 'forum_section_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * @return HasMany
     */
    public function positive()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_FORUM_TOPIC)
            ->where('rating', 1);
    }

    /**
     * @return HasMany
     */
    public function negative()
    {
        return $this->hasMany('App\Models\UserReputation', 'object_id')
            ->where('relation', UserReputation::RELATION_FORUM_TOPIC)
            ->where('rating', '-1');
    }

    /**
     * @return string
     */
    public function getSeoTitle(): string
    {
        return !empty($this->seo_title) ? $this->seo_title : $this->getTitle();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return Str::limit($this->title, 65, '');
    }

    /**
     * @return string
     */
    public function getSeoKeywords(): string
    {
        return !empty($this->seo_keywords) ? $this->seo_keywords : $this->getTitle();
    }

    /**
     * @return string
     */
    public function getSeoDescription(): string
    {
        return !empty($this->seo_description) ? $this->seo_description : $this->getTitle();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function getLastFixNewsWithNews()
    {
        $newsFix = ForumTopic::getLastWithParamsNews(false, true, true, 3);
        $newsFixCount = abs($newsFix->count() - 5);

        $newsNormal = ForumTopic::getLastWithParamsNews(false, false, true, 3 + $newsFixCount);

        return $newsFix->merge($newsNormal);

    }


    /**
     * @param $hide
     * @param $fixing
     * @param $news
     * @param $extraLimit
     * @return \Illuminate\Support\Collection
     */
    public static function getLastWithParamsNews($hide, $fixing, $news, $extraLimit)
    {
        $data = collect();
        $extra = 0;
        $lastId = null;

        $item = ForumTopic::query()
            ->orderByDesc('id')
            ->where('hide', $hide)
            ->where('fixing', $fixing)
            ->where('news', $news)
            ->where('important', false)
            ->first();
        if (!is_null($item)) {
            $lastId = $item->id;
            $data->push($item);
        }

        if (!is_null($lastId)) {
            while ($extra <= $extraLimit) {

                $item = ForumTopic::query()
                    ->orderByDesc('id')
                    ->where('id', '<', $lastId)
                    ->where('hide', $hide)
                    ->where('fixing', $fixing)
                    ->where('news', $news)
                    ->where('important', false)
                    ->first();

                if (!is_null($item)) {
                    $lastId = $item->id;
                    $data->push($item);
                }
                $extra++;
            }
        }


        return $data;
    }

    public static function getLastWithParamsNewsIndex($hide, $fixing, $news, $extraLimit)
    {
        $data = collect();

        if ($extraLimit === 0) {
            return $data;
        }

        $extra = 1;
        $lastId = null;
        $item = ForumTopic::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('hide', $hide)
            ->where('fixing', $fixing)
            ->where('news', $news)
            ->where('important', false)
            ->withCount('comments')
            ->orderByDesc('id')
            ->first();
        if (!is_null($item)) {
            $lastId = $item->id;
            $data->push($item);
        }

        if (!is_null($lastId) && ($extraLimit > 1)) {
            $extraLimit = $extraLimit - 1;
            while ($extra <= $extraLimit) {

                $item = ForumTopic::with('author:id,name,avatar')
                    ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
                    ->where('id', '<', $lastId)
                    ->where('hide', $hide)
                    ->where('fixing', $fixing)
                    ->where('news', $news)
                    ->where('important', false)
                    ->withCount('comments')
                    ->orderByDesc('id')
                    ->first();

                if (!is_null($item)) {
                    $lastId = $item->id;
                    $data->push($item);
                }
                $extra++;
            }
        }


        return $data;
    }

    public static function getLastImportantNews($take)
    {
        if ($take === 0) {
            return collect();
        }

        return self::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('hide', false)
            ->where('news', true)
            ->where('fixing', false)
            ->where('important', true)
            ->withCount('comments')
            ->orderByDesc('id')
            ->take($take)
            ->get();

    }
}
