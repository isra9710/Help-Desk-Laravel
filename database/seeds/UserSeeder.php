<?php

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new User();
		$user->name = "Israel";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="Israel";
		$user->email="rcio172619@upemor.edu.mx";
		$user->password=bcrypt(123456);
		$user->extension="777";
		$user->idRole=1;
		$user->idDepartment=1;
		$user->status=TRUE;
        $user -> save();
        $user = new User();
		$user->name = "Veronica";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="vero98";
		$user->email="vero@gmail.com";
		$user->password=bcrypt(123456);
		$user->extension="777";
		$user->idRole=2;
		$user->idDepartment=1;
		$user->status=TRUE;
        $user -> save();
    
        $user = new User();
		$user->name = "Rodrigo";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="rod97";
		$user->email="rod@gmail.com";
		$user->password=bcrypt(123456);
		$user->extension="72277";
		$user->idRole=3;
		$user->idDepartment=1;
		$user->status=TRUE;
        $user -> save();
        
        $user = new User();
		$user->name = "Noe";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="noe77";
		$user->email="noe@gmail.com";
		$user->password=bcrypt(123456);
		$user->extension="7717";
		$user->idRole=4;
		$user->idDepartment=1;
		$user->status=TRUE;
		$user -> save();
		
		$user = new User();
		$user->name = "Fabi";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="fabi78";
		$user->email="fab@gmail.com";
		$user->password=bcrypt(123456);
		$user->extension="7717";
		$user->idRole=5;
		$user->idDepartment=NULL;
		$user->status=TRUE;
		$user -> save();
		
		$user = new User();
		$user->name = "Carlos";
		$user->fathersLastName="X";
		$user->mothersLastName="X";
		$user->username="Car79";
		$user->email="car@gmail.com";
		$user->password=bcrypt(123456);
		$user->extension="7717";
		$user->idRole=4;
		$user->idDepartment=1;
		$user->status=TRUE;
        $user -> save();
		factory('App\Models\User',150)->create();
    }
}
