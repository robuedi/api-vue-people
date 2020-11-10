<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\PersonResource;
use App\Http\Resources\v1\PersonResourceCollection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Person;

class PersonsController extends Controller
{
    /**
     * @return PersonResourceCollection
     */
    public function index(Request $request) : PersonResourceCollection
    {
        // Set query builder
        $qb = Person::query();
        if($request->has('sortby')){
            //Handle default parameter of get with second argument
            $qb->orderBy($request->get('sortby'), $request->get('direction', 'ASC'));
        }

        return new PersonResourceCollection($qb->paginate()->appends(request()->query()));
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show($person)
    {
        try{
            $person = Person::findOrFail($person);
        }
        catch(\Exception $e)
        {
            return response()->json(['message'=> $e->getMessage()]);
        }

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
     * @param $person
     * @param Request $request
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function update($person, Request $request)
    {

        $request->validate([
            'first_name'    => 'max:255|min:1',
            'last_name'     => 'max:255|min:1',
            'phone'         => 'max:255|min:1',
            'email'         => 'max:255|min:1',
            'city'          => 'max:255|min:1'
        ]);

        try{
            $person = Person::findOrFail($person);
        }
        catch(\Exception $e)
        {
            return response()->json(['message'=> $e->getMessage()]);
        }

        $person->update($request->all());

        return new PersonResource($person);
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
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
