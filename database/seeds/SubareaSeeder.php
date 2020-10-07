<?php
use App\Models\Subarea;

use Illuminate\Database\Seeder;

class SubareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $subarea = new Subarea();
        $subarea->subareaName ="Sistemas";
        $subarea->idDepartment=1;
        $subarea->save();
        $subarea = new Subarea();
        $subarea->subareaName ="Soporte técnico";
        $subarea->idDepartment=1;
        $subarea->save();
        $subarea = new Subarea();
        $subarea->subareaName ="Administrativas";
        $subarea->idDepartment=1;
        $subarea->save();
        $subarea = new Subarea();
        $subarea->subareaName ="Limpieza";
        $subarea->idDepartment=2;
        $subarea->save();
        $subarea = new Subarea();
        $subarea->subareaName ="Transporte";
        $subarea->idDepartment=2;
        $subarea->save();
        $subarea = new Subarea();
        $subarea->subareaName ="Centro de copiado";
        $subarea->idDepartment=2;
        $subarea->save();
    }
}
