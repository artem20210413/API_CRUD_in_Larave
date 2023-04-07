<?php


namespace App\Services\Entities;


use App\Models\Continents;

class ContinentsService
{
    public function all()
    {
        return Continents::all();
    }

}
