<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }

    public function Position()
    {
        return $this->belongsTo(Item::class);
    }

    public function Order()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeSearchByPositionAndItemName($query, $positionId, $search)
    {
        $query->when($positionId ?? false, function ($query, $positionId) use ($search) {
            return $query->where('position_id', $positionId)
                ->whereHas('item', function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('code', 'like', "%$search%")
                        ->orWhere('part_number', 'like', "%$search%");
                });
        });
        // return $query->where('position_id', $positionId)
        //              ->whereHas('item', function ($query) use ($itemName) {
        //                  $query->where('name', 'like', "%$itemName%");
        //              });
        // $query->when($category ?? false, function ($query, $category) {
        //     return $query->whereHas('item.category', function ($query) use ($category) {
        //         $query->where('name', $category);
        //     });
        // });
    }
}
