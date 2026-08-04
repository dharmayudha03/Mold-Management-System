<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListMesin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nameMesin(): HasMany
    {
        return $this->hasMany(NameMesin::class, 'list_mesin_id');
    }

    public function classMesin(): HasMany
    {
        return $this->hasMany(ClassMesin::class, 'list_mesin_id');
    }

    public function mesin(): HasMany
    {
        return $this->hasMany(Mesin::class, 'list_mesin_id');
    }

    public function formSandblasting(): HasMany
    {
        return $this->hasMany(FormSandblasting::class, 'list_mesin_id');
    }

    public function formSetupCetakan(): HasMany
    {
        return $this->hasMany(FormSetupCetakan::class, 'list_mesin_id');
    }

    public function cetakanNaik(): HasMany
    {
        return $this->hasMany(CetakanNaik::class, 'list_mesin_id');
    }

    public function formSchedule(): HasMany
    {
        return $this->hasMany(FormSchedule::class, 'list_mesin_id');
    }

}
