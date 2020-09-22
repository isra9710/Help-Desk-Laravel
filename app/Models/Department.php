<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $idDepartment
 * @property string $departmentName
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Type[] $types
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	protected $primaryKey = 'idDepartment';

	protected $fillable = [
		'departmentName'
	];

	public function types()
	{
		return $this->hasMany(Type::class, 'idDepartment');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'idDepartment');
	}
}
