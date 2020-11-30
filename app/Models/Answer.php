<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * 
 * @property int $idAnswer
 * @property int $idPoll
 * @property int $idQuestion
 * @property int $score
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Poll $poll
 * @property Question $question
 *
 * @package App\Models
 */
class Answer extends Model
{
	protected $table = 'answers';
	protected $primaryKey = 'idAnswer';

	protected $casts = [
		'idPoll' => 'int',
		'idQuestion' => 'int',
		'score' => 'int'
	];

	protected $fillable = [
		'idPoll',
		'idQuestion',
		'score'
	];

	public function poll()
	{
		return $this->belongsTo(Poll::class, 'idPoll');
	}

	public function question()
	{
		return $this->belongsTo(Question::class, 'idQuestion');
	}
}
