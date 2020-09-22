<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Description
 * 
 * @property int $idDescription
 * @property int|null $idTicket
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ticket $ticket
 *
 * @package App\Models
 */
class Description extends Model
{
	protected $table = 'descriptions';
	protected $primaryKey = 'idDescription';

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
