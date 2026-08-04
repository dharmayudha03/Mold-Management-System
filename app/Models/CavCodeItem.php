<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CavCodeItem extends Model
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

    public function codeItem(): HasMany
    {
        return $this->hasMany(CodeItem::class, 'cav_code_item_id');
    }

    public function formRepairCetakan(): HasMany
    {
        return $this->hasMany(FormRepairCetakan::class, 'cav_code_item_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'cav_code_item_id');
    }

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'cav_code_item_id');
    }

    public function cetakanNaik(): HasMany
    {
        return $this->hasMany(CetakanNaik::class, 'cav_code_item_id');
    }

    public function historyCetakan(): HasMany
    {
        return $this->hasMany(HistoryCetakan::class, 'cav_code_item_id');
    }

    public function formMjo(): HasMany
    {
        return $this->hasMany(FormMjo::class, 'cav_code_item_id');
    }

    public function penomoranRak(): HasMany
    {
        return $this->hasMany(PenomoranRak::class, 'cav_code_item_id');
    }


}
