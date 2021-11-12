<?php

namespace App\Models;

use App\Constants\ProductConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'information',
        'price',
        'is_selling',
        'owner_id',
        'shop_id',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function category()
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function imageFirst()
    {
        return $this->belongsTo(Image::class, 'image1');
    }

    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2');
    }

    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3');
    }

    public function imageFourth()
    {
        return $this->belongsTo(Image::class, 'image4');
    }

    public function getImages()
    {
        return
            Image::where('id', $this->image1)
            ->orWhere('id', $this->image2)
            ->orWhere('id', $this->image3)
            ->orWhere('id', $this->image4)
            ->get();
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'carts')
            ->withPivot(['id', 'quantity'])
            ->withTimestamps();
    }

    public function scopeAvailableItems($query)
    {
        $stocks = DB::table('t_stocks')
            ->select('product_id', DB::raw('sum(quantity) as quantity'))
            ->groupBy('product_id')
            ->having('quantity', '>', 1);

        return $query
            ->joinSub($stocks, 'stocks', function ($join) {
                $join->on('products.id', '=', 'stocks.product_id');
            })
            ->join('shops', 'shops.id', '=', 'products.shop_id')
            ->join('secondary_categories', 'secondary_categories.id', '=', 'products.secondary_category_id')
            ->join('images', 'images.id', '=', 'products.image1')
            ->where('shops.is_selling', true)
            ->where('products.is_selling', true)
            ->select(
                'products.id',
                'products.name as name',
                'products.price',
                'products.information',
                'secondary_categories.name as categoryName',
                'images.filename'
            );
    }

    public function scopeSortOrder($query, $sotrOrder = ProductConstant::NEWER)
    {
        switch ($sotrOrder) {
            case ProductConstant::NEWER:
                return $query->orderBy('products.created_at', 'desc');
                break;
            case ProductConstant::OLDER:
                return $query->orderBy('products.created_at');
                break;
            case ProductConstant::CHEAPER:
                return $query->orderBy('price');
                break;
            case ProductConstant::HIGHER:
                return $query->orderBy('price', 'desc');
                break;
        }
    }

    public function scopeSelectCategory($query, $categoryId = 0)
    {
        if ($categoryId === 0) {
            return $query;
        }
        return $query->where('secondary_category_id', $categoryId);
    }
}
