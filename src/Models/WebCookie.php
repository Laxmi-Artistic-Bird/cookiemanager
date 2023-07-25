<?php

namespace Artisticbird\Cookies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebCookie extends Model
{
    use HasFactory;

    public function getDomain(){
        return $this->hasOne('Artisticbird\Cookies\Models\UserDetail','id','domain_id');
    }
}
