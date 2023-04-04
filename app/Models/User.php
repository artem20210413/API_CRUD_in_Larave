<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * @package App\Models
 * @property integer id
 * @property string name
 * @property string email
 * @property string iso_code_country
 * @property integer verified
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'users_projects');
    }

    public function projectsByAuth(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'author_id', 'id');
    }

    public function country(): HasOne
    {
        return $this->hasOne(Countries::class, 'iso_code', 'iso_code_country');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

}
