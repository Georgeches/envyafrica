<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'brand', 'price', 'slug', 'sku', 'description', 'category_id', 'image', 'quantity'];

    public function product_images(): HasMany{
        return $this->hasMany(ProductImage::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute(){
        return $this->category->name ?? 'No category';
    }

    public function scopeFilter($query, $filters){
        //search, sort, category, maxprice, minprice
        if(isset($filters['search'])){
            $query->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] .'%')
                ->orWhere('brand', 'like', '%' . $filters['search'] .'%');
        }
        if(isset($filters['category'])){
            $query->where('category_id', 'like', '%' . $filters['category'] . '%');
        }
        if(isset($filters['sort'])){
            if($filters['sort'] == 'pricehl'){
                $query->orderBy('price', 'desc');
            }
            if($filters['sort'] == 'pricelh'){
                $query->orderBy('price');
            }
        }
        if(isset($filters['maxprice'])){
            $query->where('price', '<=', $filters['maxprice']);
        }
        if(isset($filters['minprice'])){
            $query->where('price', '>=', $filters['minprice']);
        }
    }

    public function alreadyInBag($id){
        $cart = session()->get('cart', []);
        foreach($cart as $i){
            if($i['id'] === $id){
                return true;
            }
        }
        return false;
    }
}
