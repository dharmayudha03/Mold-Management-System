<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mesin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function listMesin(): BelongsTo
    {
        return $this->belongsTo(ListMesin::class, 'list_mesin_id');
    }

    public function nameMesin(): BelongsTo
    {
        return $this->belongsTo(NameMesin::class, 'name_mesin_id');
    }

    public function classMesin(): BelongsTo
    {
        return $this->belongsTo(ClassMesin::class, 'class_mesin_id');
    }
}
