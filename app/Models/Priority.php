<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority
 * 
 * @property int $idPriority
 * @property string $priorityName
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Type[] $types
 *
 * @package App\Models
 */
class Priority extends Model
{
	protected $table = 'priorities';
	protected $primaryKey = 'idPriority';

	protected $fillable = [
		'priorityName'
	];

	public function types()
	{
		return $this->hasMany(Type::class, 'idPriority');
	}
}
