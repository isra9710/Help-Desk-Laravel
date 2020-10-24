<?php
use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $activity = new Activity();
        $activity->activityName ="Histoclin";
        $activity->idPriority=1;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Scodap";
        $activity->idPriority=2;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="NOI";
        $activity->idPriority=3;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Ris";
        $activity->idPriority=2;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Pacs";
        $activity->idPriority=3;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Otros";
        $activity->idPriority=3;
        $activity->idSubarea =1;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="No Breaks";
        $activity->idPriority=1;
        $activity->idSubarea =2;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Computadora";
        $activity->idPriority=1;
        $activity->idSubarea =2;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Impresora";
        $activity->idPriority=3;
        $activity->idSubarea =2;
        $activity->days= 1;
        $activity->save();

        $activity = new Activity();
        $activity->activityName ="Solicitud de clave";
        $activity->idPriority=1;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Revisión de cámaras";
        $activity->idPriority=1;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Difusión";
        $activity->idPriority=3;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Alta de correo";
        $activity->idPriority=2;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Solicitud de capacitación";
        $activity->idPriority=1;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Desbloqueo de página web";
        $activity->idPriority=2;
        $activity->idSubarea =3;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Limpieza del área";
        $activity->idPriority=2;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Movimiento de mobiliario";
        $activity->idPriority=2;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Solicitud de Desinfección Patógena y/o Fumigación";
        $activity->idPriority=1;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Exhaustivo no programado";
        $activity->idPriority=2;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Revisión de dispensador de agua";
        $activity->idPriority=2;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Solicitud de acomodo de mobiliario sesión médica y eventos";
        $activity->idPriority=1;
        $activity->idSubarea =4;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Mensajería";
        $activity->idPriority=2;
        $activity->idSubarea =5;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Ambulancia";
        $activity->idPriority=1;
        $activity->idSubarea =5;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Vehículo oficial";
        $activity->idPriority=1;
        $activity->idSubarea =5;
        $activity->days= 1;
        $activity->save();


        $activity = new Activity();
        $activity->activityName ="Copias";
        $activity->idPriority=3;
        $activity->idSubarea =6;
        $activity->days= 1;
        $activity->save();



        $activity = new Activity();
        $activity->activityName ="Engargolados";
        $activity->idPriority=3;
        $activity->idSubarea =6;
        $activity->days= 1;
        $activity->save();
    }
}
