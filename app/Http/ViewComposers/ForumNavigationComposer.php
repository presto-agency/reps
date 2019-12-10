<?php
/**
 * Created by PhpStorm.
 * User: MAX
 * Date: 18.10.2019
 * Time: 10:14
 */

namespace App\Http\ViewComposers;

use App\Models\ForumSection;
use Illuminate\View\View;

class ForumNavigationComposer
{
    public function compose(View $view)
    {
        return $view->with('sectionItems', ForumSection::active()->get());
    }
}