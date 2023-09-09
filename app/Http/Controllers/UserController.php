<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Sanctum\HasApiTokens;
 
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
