<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * 
 * @property int $idMessage
 * @property int $idTicket
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ticket $ticket
 *
 * @package App\Models
 */
class Message extends Model
{
	protected $table = 'messages';
	protected $primaryKey = 'idMessage';

	protected $casts = [
		'idTicket' => 'int'
	];

	protected $fillable = [
		'idTicket',
		'text'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'idTicket');
	}
}
