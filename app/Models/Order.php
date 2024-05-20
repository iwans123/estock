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

    public function scopeSearch($query, $searchItem, $positionId)
    {
        // return $query->whereHas('stock.item', function ($query) use ($searchItem) {
        //     $query->where('name', 'like', "%$searchItem%");
        // });

        $query->when($positionId ?? false, function ($query, $positionId) use ($searchItem) {
            return $query->whereHas('stock', function ($query) use ($positionId, $searchItem) {
                $query->where('position_id', $positionId)
                    ->whereHas('item', function ($query) use ($searchItem) {
                        $query->where('name', 'like', "%$searchItem%")
                            ->orWhere('code', 'like', "%$searchItem%")
                            ->orWhere('part_number', 'like', "%$searchItem%");
                    });
            });
        });
    }
}
