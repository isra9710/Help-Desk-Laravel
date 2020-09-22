<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ticket
 * 
 * @property int $idTicket
 * @property int|null $idType
 * @property int|null $idStatus
 * @property int|null $idUser
 * @property Carbon $startDate
 * @property Carbon $limitDate
 * @property string $firstPhoto
 * @property string $secondPhoto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property Status $status
 * @property Type $type
 * @property User $user
 * @property Collection|Description[] $descriptions
 * @property Collection|Poll[] $polls
 *
 * @package App\Models
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'idTicket';

	protected $casts = [
		'idType' => 'int',
		'idStatus' => 'int',
		'idUser' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'startDate',
		'limitDate'
	];

	protected $fillable = [
		'idType',
		'idStatus',
		'idUser',
		'startDate',
		'limitDate',
		'firstPhoto',
		'secondPhoto',
		'created_by',
		'updated_by'
	];

	public function status()
	{
		return $this->belongsTo(Status::class, 'idStatus');
	}

	public function type()
	{
		return $this->belongsTo(Type::class, 'idType');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idUser');
	}

	public function descriptions()
	{
		return $this->hasMany(Description::class, 'idTicket');
	}

	public function polls()
	{
		return $this->hasMany(Poll::class, 'idTicket');
	}
}
