<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class FormSandblasting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'detail_user_id' => 'array',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function detailUser(): BelongsToMany
    {
        return $this->belongsToMany(DetailUser::class, 'detail_user_form_sandblasting');
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

    public function formSchedule(): BelongsTo
    {
        return $this->belongsTo(FormSchedule::class, 'form_schedule_id');
    }
}