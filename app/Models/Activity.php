<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * 
 * @property int $idActivity
 * @property string $activityName
 * @property int $idSubarea
 * @property int $idPriority
 * @property string $activityDescription
 * @property int $days
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Priority $priority
 * @property Subarea $subarea
 * @property Collection|Assignment[] $assignments
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Activity extends Model
{
	protected $table = 'activities';
	protected $primaryKey = 'idActivity';

	protected $casts = [
		'idSubarea' => 'int',
		'idPriority' => 'int',
		'days' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'activityName',
		'idSubarea',
		'idPriority',
		'activityDescription',
		'days',
		'active'
	];

	public function priority()
	{
		return $this->belongsTo(Priority::class, 'idPriority');
	}

	public function subarea()
	{
		return $this->belongsTo(Subarea::class, 'idSubarea');
	}

	public function assignments()
	{
		return $this->hasMany(Assignment::class, 'idActivity');
	}

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idActivity');
	}
}
