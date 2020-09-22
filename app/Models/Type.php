<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 * 
 * @property int $idType
 * @property int|null $idPriority
 * @property int|null $idDepartment
 * @property string $nameType
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Department $department
 * @property Priority $priority
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Type extends Model
{
	protected $table = 'types';
	protected $primaryKey = 'idType';

	protected $casts = [
		'idPriority' => 'int',
		'idDepartment' => 'int'
	];

	protected $fillable = [
		'idPriority',
		'idDepartment',
		'nameType'
	];

	public function department()
	{
		return $this->belongsTo(Department::class, 'idDepartment');
	}

	public function priority()
	{
		return $this->belongsTo(Priority::class, 'idPriority');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idType');
	}
}
