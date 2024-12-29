<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class BusinessOwner extends Authenticatable
{



	/**
     * The attributes that are mass assignable.
     *
     * @var string
     */
	//use Notifiable;

	protected $guard = "businessowners";

	protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

	//use user id of admin
	protected $primaryKey = 'id';

	//public $table = true;

}
