<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

use Sofa\Eloquence\Eloquence; // base trait
use Sofa\Eloquence\Mappable; // extension trait
use Sofa\Eloquence\Mutable; // extension trait

class User extends Authenticatable
{
    use Notifiable, Eloquence, Mappable, Mutable;

    protected $table        =   'accounts';
    protected $primaryKey   =   'ACCTCODE';
    public $timestamps = false;

    protected $maps = [
      // simple alias
      'account_code'    => 'ACCTCODE',
      'username'        => 'USERNAME',
      'password'        => 'PASSWORD',
      'token'           => 'TOKEN',
      'account_type'    => 'ACCTTYPE',
      'account_name'    => 'ACCTNAME',
      'area_code'       => 'AREACODE',
      'terms'           => 'TERMS',
      'address'         => 'ADDRESS'
    ]; 

    /**
     * Attributes getter mutators @ Eloquence\Mutable
     *
     * @var array
     */
    protected $getterMutators = [
        'account_name'     => 'trim',
        'address'          => 'trim',
        'username'         => 'strtolower|ucwords'
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /*----------  logic  ----------*/
    public static function findByUsername($username){
        return  static::where('USERNAME',$username)
                    ->where('ACCTTYPE','C') //filter by C = Customer
                    ->first();
    }

    public static function findByToken($token){
        return  static::where('TOKEN',$token) 
                    ->first();
    }

    public static function generateToken($username){
        $now            =   Carbon::now(); 
        $token          =   md5($username.$now);
        return $token;
    }

    public static function isValidToken($token){
        return  static::where('token',$token)->first();
    }

    public static function getDeliveryDetails($token){
        return  static::select('ADDRESS')->where('TOKEN',$token)->first();
    }
    public static function getPersonalDetails($token){
        return  static::select('ACCTNAME')->where('TOKEN',$token)->first();
    } 

    public function getScAttribute() // $this->sc
    {   
        $locType    = "{$this->LOCATION_TYPE}"; 
        $surcharge  = "{$this->SURCHARGE}";
        //dd($surcharge,$locType);
        if($locType == 'M' || $locType == 'm'){
            $surcharge = 0;
        }

        return $surcharge;
    }
}
