<?php

namespace Artisticbird\Cookies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookieDetail extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function categories(){
        return $this->hasOne('App\Models\CookieCategory','id','category_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
