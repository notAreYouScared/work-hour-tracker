<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillTrade extends Model
{
    protected $fillable = ['name', 'slug'];

    public function hourSections(): HasMany
    {
        return $this->hasMany(HourSection::class);
    }
}
