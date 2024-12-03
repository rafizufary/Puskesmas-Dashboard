<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     * 
     * 
     */
    //menentukan table dan fill mana saja yang akan di masukan ke database

     protected $table = 'users';
         
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'id_poli',
        'created_at',
        'update_at',

    ];

    
    protected $hidden = [
        'password',
    ];

    const CREATED_AT = 'created_at';
    const UPDATE_AT = 'update_at';


    public function poli()
    {
        return $this->belongsTo(Poli::class,'id_poli');
    }

}
