<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;  // ← SHTO KËTË
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;  // ← SHTO KËTË

class Company extends Model implements Authenticatable  // ← NDRYSHOJI
{
    use AuthenticatableTrait;  // ← SHTO KËTË

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];
}