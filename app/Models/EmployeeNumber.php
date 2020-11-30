<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeNumber
 * 
 * @property int $idEmployeeNumber
 * @property int $employeeNumber
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class EmployeeNumber extends Model
{
	protected $table = 'employee_numbers';
	protected $primaryKey = 'idEmployeeNumber';

	protected $casts = [
		'employeeNumber' => 'int'
	];

	protected $fillable = [
		'employeeNumber'
	];
}
