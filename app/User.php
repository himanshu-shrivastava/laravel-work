<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'auth_source', 'auth_id'
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
     * Get the user details using auth id
     * @param $authId
     * @return array
     */
    public static function getUserDetails($authId){
        if(!$authId){
            return [];
        }

        return self::where('auth_id', '=', $authId)->first();
    }

    /**
     * Update detail using Auth Id
     * @param $authId
     * @param $inputData
     * @return bool
     */
    public static function updateUserDetail($authId, $inputData){

        if(!$authId || !count($inputData)){
            return false;
        }

        return self::where('auth_id', $authId)->update($inputData);
    }
}
