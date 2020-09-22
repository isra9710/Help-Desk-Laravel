<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Typesu
 * 
 * @property int $idTypeU
 * @property string $typeUser
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Typesu extends Model
{
	protected $table = 'typesu';
	protected $primaryKey = 'idTypeU';

	protected $fillable = [
		'typeUser'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'idTypeU');
	}
}
