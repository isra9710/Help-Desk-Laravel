<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Class User
 * 
 * @property int $idUser
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $extension
 * @property int|null $idRole
 * @property int|null $idDepartment
 * @property bool $status
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property Department $department
 * @property Role $role
 * @property Collection|Assignment[] $assignments
 * @property Collection|Substitution[] $substitutions
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';
	protected $primaryKey = 'idUser';
	public $timestamps = false;
	use Notifiable;

	protected $casts = [
		'idRole' => 'int',
		'idDepartment' => 'int',
		'status' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'username',
		'email',
		'password',
		'extension',
		'idRole',
		'idDepartment',
		'status',
		'email_verified_at',
		'remember_token',
		'created_by',
		'updated_by'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'idDepartment');
	}

	public function role()
	{
		return $this->belongsTo(Role::class, 'idRole');
	}

	public function assignments()
	{
		return $this->hasMany(Assignment::class, 'idUser');
	}

	public function substitutions()
	{
		return $this->hasMany(Substitution::class, 'idYes');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idTechnician');
	}

	public function hasAnyRole($role){
		if ($this->hasRole($role)){
			return true;
		}
		return false;
	}


	public function hasRole($role){
		if($this->role()->where('roleName',$role)->first()){
			return true;
		}
		return false;
	}


	public function atuthorizeRole($role){
		if($this->hasAnyRole($role)){
			return true;
		}
		abort(401,'No tienes autorización para entrar a esta sección');
	}
	
}
