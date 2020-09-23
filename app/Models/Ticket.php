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
 * @property int|null $idStaff
 * @property int|null $idTechnician
 * @property int|null $idStatus
 * @property Carbon $startDate
 * @property Carbon $limitDate
 * @property string $firstPhoto
 * @property string $secondPhoto
 * @property bool|null $doubt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * 
 * @property User $user
 * @property Status $status
 * @property Collection|Message[] $messages
 * @property Collection|Poll[] $polls
 *
 * @package App\Models
 */
class Ticket extends Model
{
	protected $table = 'tickets';
	protected $primaryKey = 'idTicket';

	protected $casts = [
		'idStaff' => 'int',
		'idTechnician' => 'int',
		'idStatus' => 'int',
		'doubt' => 'bool',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'startDate',
		'limitDate'
	];

	protected $fillable = [
		'idStaff',
		'idTechnician',
		'idStatus',
		'startDate',
		'limitDate',
		'firstPhoto',
		'secondPhoto',
		'doubt',
		'created_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idTechnician');
	}

	public function status()
	{
		return $this->belongsTo(Status::class, 'idStatus');
	}

	public function messages()
	{
		return $this->hasMany(Message::class, 'idTicket');
	}

	public function polls()
	{
		return $this->hasMany(Poll::class, 'idTicket');
	}
}
