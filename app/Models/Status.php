<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * 
 * @property int $idStatus
 * @property string $statusName
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Ticket[] $tickets
 *
 * @package App\Models
 */
class Status extends Model
{
	protected $table = 'status';
	protected $primaryKey = 'idStatus';

	protected $fillable = [
		'statusName'
	];

	public function tickets()
	{
		return $this->hasMany(Ticket::class, 'idStatus');
	}
}
