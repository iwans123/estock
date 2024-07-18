<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function Stock()
    {
        return $this->hasMany(Stock::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter($query, $search)
    {
        $query->when($search ?? false, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                ->orWhere('code', 'like', "%$search%")
                ->orWhere('part_number', 'like', "%$search%");
        });
    }

    public static function generatePartNumber($prefix)
    {
        // Ambil part number terakhir dengan prefix yang diberikan
        $lastPartNumber = self::where('code', 'LIKE', $prefix . '-%')
            ->orderByRaw('CAST(RIGHT(code, 3) AS UNSIGNED) DESC')
            ->first();

        if ($lastPartNumber) {
            // Ambil angka terakhir dari part number dan increment
            $lastNumber = (int) substr($lastPartNumber->code, strrpos($lastPartNumber->code, '-') + 1);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika tidak ada part number dengan prefix tersebut, mulai dari 1
            $newNumber = 1;
        }

        // Format part number baru
        return $prefix . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
