<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Project
 * @package App\Models
 * @property integer id
 * @property string name
 * @property integer author_id
 */
class Project extends Model
{
    use HasFactory;

    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }
    public function users():BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_projects');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'projects_labels');
    }
}
