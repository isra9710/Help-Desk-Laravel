<?php
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $department = new Department();
        $department->departmentName ="Planeación y desarrollo";
        $department->departmentDescription="X";
        $department->save();
        $department = new Department();
        $department->departmentName ="Servicios generales";
        $department->departmentDescription="X";
        $department->save();
    }
}
