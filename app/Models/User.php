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
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * Class User
 * 
 * @property int $idUser
 * @property string $name
 * @property string $fathersLastName
 * @property string $mothersLastName
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $extension
 * @property int $idRole
 * @property int|null $idDepartment
 * @property bool $status
 * @property bool $active
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property Department $department
 * @property Role $role
 * @property Collection|Assignment[] $assignments
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable;
	protected $table = 'users';
	protected $primaryKey = 'idUser';
	public $timestamps = false;

	protected $casts = [
		'idRole' => 'int',
		'idDepartment' => 'int',
		'status' => 'bool',
		'active' => 'bool',
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
		'fathersLastName',
		'mothersLastName',
		'username',
		'email',
		'password',
		'extension',
		'idRole',
		'idDepartment',
		'status',
		'active',
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

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idTechnician');
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


	public function isAdministrator()
	{
		if (Auth()->user()->hasRole("Administrador")) {
			return true;
		 }
		return false;
	}
	

	public function isCoordinator()
	{
		if (Auth()->user()->hasRole("Coordinador")) {
			return true;
		 }
		return false;
	}


	public function isAssistant()
	{
		if (Auth()->user()->hasRole("Asistente")) {
			return true;
		 }
		return false;
	}


	public function isAgent()
	{
		if (Auth()->user()->hasRole("Agente")) {
			return true;
		 }
		return false;
	}


	public function isUser()
	{
		if (Auth()->user()->hasRole("Usuario")) {
			return true;
		 }
		return false;
	}
}
