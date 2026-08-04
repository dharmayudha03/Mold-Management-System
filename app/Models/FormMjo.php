<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormMjo extends Model
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

    public function listMesin(): BelongsTo
    {
        return $this->belongsTo(ListMesin::class, 'list_mesin_id');
    }

    public function formRepairCetakan(): BelongsTo
    {
        return $this->belongsTo(FormRepairCetakan::class, 'form_repair_cetakan_id');
    }

    public function getMasalahAttribute()
    {
        return $this->attributes['penanganan'] ?? '';
    }

    public function getTindakanAttribute()
    {
        return $this->attributes['tindakan'] ?? '';
    }
}
