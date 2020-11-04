<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Http\Resources\PersonResourceCollection;
use Illuminate\Http\Request;
use App\Models\Person;

class PersonsController extends Controller
{
    /**
     * @param Person $person
     * @return PersonResource
     */
    public function show(Person $person) : PersonResource
    {
        return new PersonResource($person);
    }

    public function index() : PersonResourceCollection
    {
        return new PersonResourceCollection(Person::paginate());
    }
}
