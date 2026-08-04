<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;


class DetailUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function formRepairCetakan(): HasMany
    {
        return $this->hasMany(FormRepairCetakan::class, 'detail_user_id');
    }

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'detail_user_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'detail_user_id');
    }

    public function formMjo(): HasMany
    {
        return $this->hasMany(FormMjo::class, 'detail_user_id');
    }

}
