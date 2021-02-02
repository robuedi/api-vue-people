<?php


namespace App\Http\Resources\v1;


use App\Models\Person;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonJSONResponse implements ResourceInterface
{
    public function getResource(Person $person)
    {
        return new PersonResource($person);
    }

    public function getResourceCollection(LengthAwarePaginator $person)
    {
        return new PersonResourceCollection($person);
    }
}
