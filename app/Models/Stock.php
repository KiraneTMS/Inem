<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        'product_id',
        'user_id',
        'stock_1',
        'stock_2',
        'stock_3',
        'stock_4',
        'stock_5',
        'stock_6',
        'stock_7',
    ];

    // protected $casts = [
    //     'stock_1' => 'integer',
    //     'stock_2' => 'integer',
    //     'stock_3' => 'integer',
    //     'stock_4' => 'integer',
    //     'stock_5' => 'integer',
    //     'stock_6' => 'integer',
    //     'stock_7' => 'integer',
    // ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stocksHistory()
    {
        return $this->hasMany(StockHistory::class);
    }

}
