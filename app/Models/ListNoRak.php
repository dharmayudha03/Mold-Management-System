<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListNoRak extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function listRak(): BelongsTo
    {
        return $this->belongsTo(ListRak::class, 'list_rak_id');
    }

    public function listCodeItem(): BelongsTo
    {
        return $this->belongsTo(ListCodeItem::class, 'list_code_item_id');
    }

}
