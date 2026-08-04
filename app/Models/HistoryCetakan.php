<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryCetakan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listCodeItem(): BelongsTo
    {
        return $this->belongsTo(ListCodeItem::class, 'list_code_item_id');
    }

    public function cavCodeItem(): BelongsTo
    {
        return $this->belongsTo(CavCodeItem::class, 'cav_code_item_id');
    }

    public function setCodeItem(): BelongsTo
    {
        return $this->belongsTo(SetCodeItem::class, 'set_code_item_id');
    }
}
