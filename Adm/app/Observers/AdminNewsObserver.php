<?php

namespace App\Observers;

use App\Models\Admin\News;
use Illuminate\Support\Carbon;

class AdminNewsObserver
{
    public function creating(News $news)
    {
        $this->setAlias($news);
    }

    /**Set Alias for new News*/
    public function setAlias(News $news)
    {
        if (empty($news->alias)){
            $news->alias = \Str::slug($news->title);
            $check = News::where('alias', '=', $news->alias)->exists();
            if ($check){
                $news->alias = \Str::slug($news->title) . time();
            }
        }
    }

    /**Set Published News*/
    public function saving(News $news)
    {
        $this->setPublishedAt($news);
    }

    public function setPublishedAt(News $news)
    {
        $needSetPublished = empty($news->updated_at) || !empty($news->updated_at);
        if ($needSetPublished){
            $news->updated_at = Carbon::now();
        }

    }
}
