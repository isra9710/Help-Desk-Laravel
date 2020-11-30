<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $idQuestion
 * @property string $question
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Answer[] $answers
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';
	protected $primaryKey = 'idQuestion';

	protected $casts = [
		'active' => 'bool'
	];

	protected $fillable = [
		'question',
		'active'
	];

	public function answers()
	{
		return $this->hasMany(Answer::class, 'idQuestion');
	}
}
