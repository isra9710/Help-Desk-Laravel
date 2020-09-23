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
		$user->username="Israel";
		$user->email="rcio172619@upemor.edu.mx";
		$user->password=bcrypt(123456);
		$user->extension="777";
		$user->idRole=1;
		$user->idDepartment=1;
		$user->status=TRUE;
        $user -> save();
        factory('App\Models\User',50)->create();
    }
}
