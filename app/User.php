<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use App\Employee;
use App\Todo;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'position', 'email', 'bio', 'type', 'photo', 'password',
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


    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($user){
    //         $user->todo()->create([
    //             'title' => $user->email
    //         ]);
    //     });
    // }

    public function todo()
    {
        return $this->hasMany(Todo::class);
    }


    // public function employees()
    // {
    //     return $this->hasMany(Employee::class);
    // }
}
