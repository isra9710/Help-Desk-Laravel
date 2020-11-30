<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Assignment
 * 
 * @property int $idAssignment
 * @property int $idActivity
 * @property int $idUser
 * @property bool $temporary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Activity $activity
 * @property User $user
 *
 * @package App\Models
 */
class Assignment extends Model
{
	protected $table = 'assignments';
	protected $primaryKey = 'idAssignment';

	protected $casts = [
		'idActivity' => 'int',
		'idUser' => 'int',
		'temporary' => 'bool'
	];

	protected $fillable = [
		'idActivity',
		'idUser',
		'temporary'
	];

	public function activity()
	{
		return $this->belongsTo(Activity::class, 'idActivity');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'idUser');
	}
}
