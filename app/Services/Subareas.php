<?php
namespace App\Services;
use App\Models\Subarea;

class Subareas{
    public function getSubareas()
    {
        $subareas = Subarea::get();
        $subareasArray['']= 'Selecciona un departamento';
        foreach($subareas as $subarea){
            $subareasArray[$subarea->idSubarea] = $subarea->subareaName;
        }
        return $subareasArray;
    }


}