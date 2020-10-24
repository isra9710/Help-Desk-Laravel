<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $status = new Status();
        $status->statusName ="Abierto";
        $status->save();
        $status = new Status();
        $status->statusName ="En proceso";
        $status->save();
        $status = new Status();
        $status->statusName ="Cancelado";
        $status->save();
        $status = new Status();
        $status->statusName ="Cerrado";
        $status->save();
        $status = new Status();
        $status->statusName ="Cerrado en reapertura";
        $status->save();
        $status = new Status();
        $status->statusName ="Vencido";
        $status->save();
        $status = new Status();
        $status->statusName ="Vencido en reapertura";
        $status->save();
    }
}
