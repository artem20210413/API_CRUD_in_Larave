<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Label
 * @package App\Models
 * @property integer id
 * @property string name
 * @property integer author_id
 */
class Label extends Model
{
    use HasFactory;

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'projects_labels');
    }
}
