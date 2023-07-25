<?php

namespace Artisticbird\Cookies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table="userdetails";
    protected $guarded=[];
}
