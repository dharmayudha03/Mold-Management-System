<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListCodeItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function setCodeItem(): HasMany
    {
        return $this->hasMany(SetCodeItem::class, 'list_code_item_id');
    }

    public function cavCodeItem(): HasMany
    {
        return $this->hasMany(CavCodeItem::class, 'list_code_item_id');
    }

    public function codeItem(): HasMany
    {
        return $this->hasMany(CodeItem::class, 'list_code_item_id');
    }

    public function penomoranRak(): HasMany
    {
        return $this->hasMany(PenomoranRak::class, 'list_code_item_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'list_code_item_id');
    }

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'list_code_item_id');
    }

    public function formRepairCetakan(): HasMany
    {
        return $this->hasMany(FormRepairCetakan::class, 'list_code_item_id');
    }

    public function cetakanNaik(): HasMany
    {
        return $this->hasMany(CetakanNaik::class, 'list_code_item_id');
    }

    public function historyCetakan(): HasMany
    {
        return $this->hasMany(HistoryCetakan::class, 'list_code_item_id');
    }

    public function formMjo(): HasMany
    {
        return $this->hasMany(FormMjo::class, 'list_code_item_id');
    }

    public function formSchedule(): HasMany
    {
        return $this->hasMany(FormSchedule::class, 'list_code_item_id');
    }

    public function listRak(): HasMany
    {
        return $this->hasMany(ListRak::class, 'list_code_item_id');
    }

    public function listNoRak(): HasMany
    {
        return $this->hasMany(ListNoRak::class, 'list_code_item_id');
    }
}
