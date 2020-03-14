<?php


namespace App\Observers;

use App\Models\Admin\Product;
use Illuminate\Support\Carbon;

class AdminProductObserver
{
    public function creating(Product $product)
    {
        $this->setAlias($product);
    }

    /**Set Alias for new Product*/
    public function setAlias(Product $product)
    {
        if (empty($product->alias)){
            $product->alias = \Str::slug($product->title);
            $check = Product::where('alias', '=', $product->alias)->exists();
            if ($check){
                $product->alias = \Str::slug($product->title) . time();
            }
        }
    }

    /**Set Published Product*/
    public function saving(Product $product)
    {
        $this->setPublishedAt($product);
    }

    public function setPublishedAt(Product $product)
    {
        $needSetPublished = empty($product->updated_at) || !empty($product->updated_at);
        if ($needSetPublished){
            $product->updated_at = Carbon::now();
        }

    }
}
