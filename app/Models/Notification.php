<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $idNotification
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $data
 * @property Carbon|null $read_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';
	protected $primaryKey = 'idNotification';

	protected $casts = [
		'notifiable_id' => 'int'
	];

	protected $dates = [
		'read_at'
	];

	protected $fillable = [
		'type',
		'notifiable_type',
		'notifiable_id',
		'data',
		'read_at'
	];
}
