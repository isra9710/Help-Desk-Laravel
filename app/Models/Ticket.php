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
 * @property string|null $employeeNumber
 * @property int|null $idTechnician
 * @property int|null $idStatus
 * @property int|null $idActivity
 * @property Carbon $startDate
 * @property Carbon $limitDate
 * @property Carbon|null $closeDate
 * @property string|null $ticketDescription
 * @property bool|null $doubt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Activity $activity
 * @property Status $status
 * @property User $user
 * @property Collection|File[] $files
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
		'idTechnician' => 'int',
		'idStatus' => 'int',
		'idActivity' => 'int',
		'doubt' => 'bool'
	];

	protected $dates = [
		'startDate',
		'limitDate',
		'closeDate'
	];

	protected $fillable = [
		'employeeNumber',
		'idTechnician',
		'idStatus',
		'idActivity',
		'startDate',
		'limitDate',
		'closeDate',
		'ticketDescription',
		'doubt'
	];

	public function activity()
	{
		return $this->belongsTo(Activity::class, 'idActivity');
	}

	public function status()
	{
		return $this->belongsTo(Status::class, 'idStatus');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idTechnician');
	}

	public function files()
	{
		return $this->hasMany(File::class, 'idTicket');
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
