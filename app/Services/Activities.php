<?php
namespace App\Services;
use App\Models\Acitivity;

class Acitivities{
    public function getAcitivities()
    {
        $acitivities = Acitivity::get();
        $acitivitiesArray['']= 'Selecciona un departamento';
        foreach($acitivities as $acitivity){
            $acitivitiesArray[$acitivity->idAcitivity] = $acitivity->acitivityName;
        }
        return $acitivitiesArray;
    }


}