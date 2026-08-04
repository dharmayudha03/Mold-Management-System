<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormRepairCetakan extends Model
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

    public function detailUser(): BelongsTo
    {
        return $this->belongsTo(DetailUser::class, 'detail_user_id');
    }

    public function formMjo(): HasMany
    {
        return $this->hasMany(FormMjo::class, 'form_repair_cetakan_id');
    }

    public function latestMjo()
    {
        return $this->hasOne(FormMjo::class, 'form_repair_cetakan_id')->latestOfMany();
    }

    public function getMasalahAttribute()
    {
        return $this->attributes['problem'] ?? '';
    }

    public function getTindakanAttribute()
    {
        return $this->attributes['tindakan'] ?? '';
    }

    public function getAnalisaAttribute()
    {
        return $this->attributes['analisa'] ?? '';
    }
}
