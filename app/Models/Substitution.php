<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Substitution
 * 
 * @property int $idSubstitution
 * @property int|null $idNot
 * @property int|null $idYes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Substitution extends Model
{
	protected $table = 'substitutions';
	protected $primaryKey = 'idSubstitution';

	protected $casts = [
		'idNot' => 'int',
		'idYes' => 'int'
	];

	protected $fillable = [
		'idNot',
		'idYes'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'idYes');
	}
}
