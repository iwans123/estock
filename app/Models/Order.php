<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function scopeSearch($query, $searchItem)
    {
        return $query->whereHas('stock.item', function ($query) use ($searchItem) {
            $query->where('name', 'like', "%$searchItem%");
        });
    }
}
