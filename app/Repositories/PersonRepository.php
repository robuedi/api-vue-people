<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Support\Facades\Log;

class PersonRepository
{
    public function create()
    {
        return Person::create(request()->all());
    }

    public function update(Person $person)
    {
        $person->update(request()->all());

        return $person;
    }

    public function delete(Person $person)
    {
        $person->delete();

        return $person;
    }

    public function getAllPaginate()
    {
        $query = Person::query();

        //apply sort
        if(request()->has('sortby'))
        {
            $query->orderBy(request()->get('sortby'), request()->get('direction', 'ASC'));
        }

        return $query->paginate()->appends(request()->query());
    }
}
