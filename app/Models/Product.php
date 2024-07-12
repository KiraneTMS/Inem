<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = ['user_id', 'category_id', 'path_photo', 'product_code', 'name', 'product_desc', 'merk', 'variety', 'weight', 'ongkir'];

    protected $appends = ['jumlah_stok', 'jumlah_pilihan', 'jumlah_harga'];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function varieties()
    {
        return $this->hasOne(Variety::class, 'product_id', 'id');
    }

    public function prices()
    {
        return $this->hasOne(Price::class, 'product_id', 'id');
    }

    public function stocks()
    {
        return $this->hasOne(Stock::class, 'product_id', 'id');
    }

    public function statuses()
    {
        return $this->hasOne(Status::class, 'product_id', 'id');
    }

    public function stocksHistory()
    {
        return $this->hasMany(StocksHistory::class);
    }


}
