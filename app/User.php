<?php

namespace App;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function boardsByMe(): HasMany
    {
        return $this->hasMany(Board::class, 'user_id');
    }

    public function boards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class,'board_user');
    }

    public function myTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', "email_verified_at"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
