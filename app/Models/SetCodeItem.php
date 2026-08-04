<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SetCodeItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function listCodeItem(): BelongsTo
    {
        return $this->belongsTo(ListCodeItem::class, 'list_code_item_id');
    }

    public function cavCodeItem(): HasMany
    {
        return $this->hasMany(CavCodeItem::class, 'set_code_item_id');
    }

    public function codeItem(): HasMany
    {
        return $this->hasMany(CodeItem::class, 'set_code_item_id');
    }

    public function penomoranRak(): HasMany
    {
        return $this->hasMany(PenomoranRak::class, 'set_code_item_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'set_code_item_id');
    }

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'set_code_item_id');
    }

    public function cetakanNaik(): HasMany
    {
        return $this->hasMany(CetakanNaik::class, 'set_code_item_id');
    }

    public function historyCetakan(): HasMany
    {
        return $this->hasMany(HistoryCetakan::class, 'set_code_item_id');
    }

    public function formMjo(): HasMany
    {
        return $this->hasMany(FormMjo::class, 'set_code_item_id');
    }

    public function formRepairCetakan(): HasMany
    {
        return $this->hasMany(FormRepairCetakan::class, 'set_code_item_id');
    }

}
