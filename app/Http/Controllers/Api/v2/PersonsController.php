<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Http\Resources\v2\PersonResource;

class PersonsController extends Controller
{
    private $person;

    public function __construct(Person $person){
        $this->person = $person;
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show($person)
    {
        try{
            $person = $this->person->findOrFail($person);
        }
        catch(\Exception $e)
        {
            return response()->json(['message'=> $e->getMessage()]);
        }

        return new PersonResource($person);
    }
}
