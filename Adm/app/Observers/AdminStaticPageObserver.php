<?php


namespace App\Observers;

use App\Models\Admin\StaticPage;
use Illuminate\Support\Carbon;

class AdminStaticPageObserver
{
    public function creating(StaticPage $staticpage)
    {
        $this->setAlias($staticpage);
    }

    /**Set Alias for new StaticPage*/
    public function setAlias(StaticPage $staticpage)
    {
        if (empty($staticpage->alias)){
            $staticpage->alias = \Str::slug($staticpage->title);
            $check = StaticPage::where('alias', '=', $staticpage->alias)->exists();
            if ($check){
                $staticpage->alias = \Str::slug($staticpage->title) . time();
            }
        }
    }

    /**Set Published StaticPage*/
    public function saving(StaticPage $staticpage)
    {
        $this->setPublishedAt($staticpage);
    }

    public function setPublishedAt(StaticPage $staticpage)
    {
        $needSetPublished = empty($staticpage->updated_at) || !empty($staticpage->updated_at);
        if ($needSetPublished){
            $staticpage->updated_at = Carbon::now();
        }

    }
}
