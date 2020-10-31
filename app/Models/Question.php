<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * 
 * @property int $idQuestion
 * @property string $question
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $idPoll
 * 
 * @property Poll $poll
 *
 * @package App\Models
 */
class Question extends Model
{
	protected $table = 'questions';
	protected $primaryKey = 'idQuestion';

	protected $casts = [
		'active' => 'bool',
		'idPoll' => 'int'
	];

	protected $fillable = [
		'question',
		'active',
		'idPoll'
	];

	public function poll()
	{
		return $this->belongsTo(Poll::class, 'idPoll');
	}
}
