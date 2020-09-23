<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role();
        $role->roleName = "Administrador";
        $role -> save();


        $role = new Role();
        $role->roleName ="Coordinador";
        $role -> save();
        

        $role = new Role();
        $role->roleName = "Asistente";
        $role -> save();
        
        
        $role = new Role();
        $role->roleName = "Agente";
        $role -> save();


        $role = new Role();
        $role->roleName = "Usuario";
        $role -> save();
        
        
        $role = new Role();
        $role->roleName = "Invitado";
        $role -> save();
    }
}
