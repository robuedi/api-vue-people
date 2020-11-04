<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonResource;
use App\Http\Resources\PersonResourceCollection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Person;

class PersonsController extends Controller
{
    /**
     * @return PersonResourceCollection
     */
    public function index() : PersonResourceCollection
    {
        return new PersonResourceCollection(Person::paginate());
    }

    /**
     * @param Person $person
     * @return PersonResource
     */
    public function show(Person $person) : PersonResource
    {
        return new PersonResource($person);
    }

    /**
     * @param Request $request
     * @return PersonResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|max:255|min:1',
            'last_name'     => 'required|max:255|min:1',
            'phone'         => 'required|max:255|min:1',
            'email'         => 'required|max:255|min:1',
            'city'          => 'required|max:255|min:1'
        ]);

        $person = Person::create($request->all());

        return new PersonResource($person);
    }

    /**
     * @param Person $person
     * @param Request $request
     * @return PersonResource
     */
    public function update(Person $person, Request $request) : PersonResource
    {

        $request->validate([
            'first_name'    => 'max:255|min:1',
            'last_name'     => 'max:255|min:1',
            'phone'         => 'max:255|min:1',
            'email'         => 'max:255|min:1',
            'city'          => 'max:255|min:1'
        ]);

        $person->update($request->all());

        return new PersonResource($person);
    }

    /**
     * @param Person $person
     * @return PersonResource
     */
    public function destroy($person)
    {
        try{
            $person = Person::findOrFail($person);
        }
        catch(\Exception $e)
        {
            return response()->json(['message'=> $e->getMessage()]);
        }

        $person->delete();

        return new PersonResource($person);
    }

}
