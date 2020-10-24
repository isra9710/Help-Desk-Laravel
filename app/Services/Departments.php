<?php
namespace App\Services;
use App\Models\Department;

class Departments{
    public function getDepartments()
    {
        $departments = Department::get();
        $departmentsArray['']= 'Selecciona un departamento';
        foreach($departments as $department){
            $departmentsArray[$department->idDepartment] = $department->departmentName;
        }
        return $departmentsArray;
    }


}