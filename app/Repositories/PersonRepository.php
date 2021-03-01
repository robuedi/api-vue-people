<?php

namespace App\Repositories;

use App\Models\Person;
use Illuminate\Support\Facades\Log;

class PersonRepository implements PersonRepositoryInterface
{
    private float $version = 1;

    public function setVersion(float $version)
    {
        $this->version = $version;
        return $this;
    }

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

    public function index()
    {
        $query = Person::query();

        //apply sort
        if(request()->has('sort_by'))
        {
            $query->orderBy(request()->get('sort_by'), request()->get('order_by', 'ASC'));
        }

        //check for specific fields requested
        if(request()->has('fields'))
        {
            $query->select(explode(',', request()->get('fields')));
        }

        return $query->paginate()->appends(request()->query());
    }
}
