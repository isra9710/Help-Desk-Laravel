<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Poll
 * 
 * @property int $idPoll
 * @property int|null $idTicket
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ticket $ticket
 *
 * @package App\Models
 */
class Poll extends Model
{
	protected $table = 'polls';
	protected $primaryKey = 'idPoll';

	protected $casts = [
		'idTicket' => 'int'
	];

	protected $fillable = [
		'idTicket'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'idTicket');
	}
}
