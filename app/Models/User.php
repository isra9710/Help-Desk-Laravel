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
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int|null $idTypeU
 * @property int|null $idDepartment
 * @property Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property Department $department
 * @property Typesu $typesu
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
		'idTypeU' => 'int',
		'idDepartment' => 'int',
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
		'firstname',
		'lastname',
		'username',
		'email',
		'password',
		'idTypeU',
		'idDepartment',
		'email_verified_at',
		'remember_token',
		'created_by',
		'updated_by'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'idDepartment');
	}

	public function typesu()
	{
		return $this->belongsTo(Typesu::class, 'idTypeU');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idUser');
	}
}
