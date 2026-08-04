<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenomoranRak extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listCodeItem(): BelongsTo
    {
        return $this->belongsTo(ListCodeItem::class, 'list_code_item_id');
    }

    public function setCodeItem(): BelongsTo
    {
        return $this->belongsTo(SetCodeItem::class, 'set_code_item_id');
    }

    public function cavCodeItem(): BelongsTo
    {
        return $this->belongsTo(CavCodeItem::class, 'cav_code_item_id');
    }

    public function listRak(): BelongsTo
    {
        return $this->belongsTo(ListRak::class, 'list_rak_id');
    }

    public function listNoRak(): BelongsTo
    {
        return $this->belongsTo(ListNoRak::class, 'list_no_rak_id');
    }
}
