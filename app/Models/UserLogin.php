<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserLogin extends Authenticatable
{
    use HasFactory;

    public static function findByIdAndAccessToken ($id, $access_token)
    {
        $user = self::query()->where('id',$id)->where('access_token',$access_token)->first();
        if($user == NULL){
            return response()->json([
               'status' => 0,
               'message' => 'Access Token Not Found'
            ]);
        }
        return $user;
    }

    protected $guard = 'user';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];


}
