<?php

namespace App\Observers;

use App\Models\Admin\Category;

class AdminCategoryObserver
{
    /*Set unique alias to new Category*/
    public function creating(Category $category)
    {
        $this->setAlias($category);
    }

    /*Set unique alias to new Category*/
    public function updating(Category $category)
    {
        $this->setAlias($category);
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
    public function setAlias(Category $category){
        if (empty($category->alias)){
            $category->alias = \Str::slug($category->title) . rand(10, 999);
        }
    }
}
