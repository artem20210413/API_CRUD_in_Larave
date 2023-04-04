<?php


namespace App\Http\Controllers\Entities;


use App\Http\Controllers\Controller;
use App\Services\Entities\ContinentsService;

class ContinentsController extends Controller
{

    public function all(ContinentsService $continentsService)
    {
        return $continentsService->all();
    }
}
