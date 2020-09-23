<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subarea
 * 
 * @property int $idSubarea
 * @property string $subareaName
 * @property int|null $idDepartment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Department $department
 * @property Collection|Activity[] $activities
 *
 * @package App\Models
 */
class Subarea extends Model
{
	protected $table = 'subareas';
	protected $primaryKey = 'idSubarea';

	protected $casts = [
		'idDepartment' => 'int'
	];

	protected $fillable = [
		'subareaName',
		'idDepartment'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'idDepartment');
	}

	public function activities()
	{
		return $this->hasMany(Activity::class, 'idSubarea');
	}
}
