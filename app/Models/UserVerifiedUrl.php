<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class UserVerifiedUrl
 * @package App\Models
 * @property int user_id
 * @property string guid
 * @property int action
 */
class UserVerifiedUrl extends Model
{
    use HasFactory;

    public function user():HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
