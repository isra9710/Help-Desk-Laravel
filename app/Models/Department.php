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
 * @property string $departmentDescription
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $active
 * 
 * @property Collection|Subarea[] $subareas
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';
	protected $primaryKey = 'idDepartment';

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'departmentName',
		'departmentDescription',
		'active'
	];

	public function subareas()
	{
		return $this->hasMany(Subarea::class, 'idDepartment');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'idDepartment');
	}
}
