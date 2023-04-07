<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Countries
 * @package App\Models
 * @property integer id
 * @property integer iso_code_continent
 * @property integer integer
 * @property string name
 */
class Countries extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function continents():BelongsTo
    {
        return $this->belongsTo(Continents::class, 'iso_code_continent', 'iso_code');
    }
}
