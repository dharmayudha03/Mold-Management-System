<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NameMesin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listMesin(): BelongsTo
    {
        return $this->belongsTo(ListMesin::class, 'list_mesin_id');
    }

    public function classMesin(): HasMany
    {
        return $this->hasMany(ClassMesin::class, 'name_mesin_id');
    }

    public function mesin(): HasMany
    {
        return $this->hasMany(Mesin::class, 'name_mesin_id');
    }

}
