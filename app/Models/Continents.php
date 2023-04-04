<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Continents extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function countries(): HasMany
    {
        return $this->hasMany(Countries::class, 'iso_code_continent', 'iso_code');
    }
}
