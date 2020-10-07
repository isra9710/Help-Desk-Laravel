<?php
use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $priority = new Priority();
        $priority->priorityName ="Alta";
        $priority->save();
        $priority = new Priority();
        $priority->priorityName ="Media";
        $priority->save();
        $priority = new Priority();
        $priority->priorityName ="Baja";
        $priority->save();
    }
}
