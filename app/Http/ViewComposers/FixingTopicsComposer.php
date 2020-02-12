<?php


namespace App\Http\ViewComposers;


use App\Models\ForumTopic;
use Illuminate\View\View;

class FixingTopicsComposer
{

    private $fixingNews;

    public function __construct()
    {
        $this->fixingNews = $this->news();
    }

    public function compose(View $view)
    {
        $view->with('fixingNews', $this->fixingNews);
    }
    private function news()
    {
        return ForumTopic::with('author:id,name,avatar')
            ->select(['id', 'title', 'preview_img', 'preview_content', 'reviews', 'user_id', 'news', 'created_at',])
            ->where('preview', false)
            ->where('fixing', true)
            ->withCount('comments')
            ->latest()
            ->get();
    }
}
