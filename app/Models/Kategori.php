<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'kategori_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'kategori_id');
    }

    public function formSchedule(): HasMany
    {
        return $this->hasMany(FormSchedule::class, 'kategori_id');
    }

}
