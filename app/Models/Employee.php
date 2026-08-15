<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class Employee extends Model implements Authenticatable
{
    use AuthenticatableTrait;

    protected $fillable = ['username', 'password', 'company_id'];
    protected $hidden = ['password'];
}