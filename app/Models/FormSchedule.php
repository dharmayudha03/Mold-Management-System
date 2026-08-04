<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class FormSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function detailUser(): BelongsTo
    {
        return $this->belongsTo(DetailUser::class, 'detail_user_id');
    }

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

    public function listMesin(): BelongsTo
    {
        return $this->belongsTo(ListMesin::class, 'list_mesin_id');
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function formSetupCetakans()
    {
        return $this->hasMany(FormSetupCetakan::class, 'form_schedule_id');
    }

    public function formSandblastings()
    {
        return $this->hasMany(FormSandblasting::class, 'form_schedule_id');
    }
}
