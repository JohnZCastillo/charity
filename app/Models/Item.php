<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'quantity',
        'status',
        'stock',
        'deleted'
    ];

    protected $casts = [
        'deleted' => 'boolean'
    ];

    protected $hidden = [
        'deleted',
    ];

    public function attachment(): HasOne
    {
        return $this->hasOne(ItemAttachment::class);
    }

}
