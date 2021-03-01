<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v2\PersonResource;
use App\Models\Person;

class PersonsController extends Controller
{
    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Person $person)
    {
        return PersonResource::make($person);
    }
}
