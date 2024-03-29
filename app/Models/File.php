<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * 
 * @property int $idFile
 * @property int $idTicket
 * @property string|null $directoryFile
 * @property string $fileDescription
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Ticket $ticket
 *
 * @package App\Models
 */
class File extends Model
{
	protected $table = 'files';
	protected $primaryKey = 'idFile';

	protected $casts = [
		'idTicket' => 'int'
	];

	protected $fillable = [
		'idTicket',
		'directoryFile',
		'fileDescription'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class, 'idTicket');
	}
}
