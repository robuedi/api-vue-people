<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PersonStoreRequest;
use App\Http\Requests\v1\PersonUpdateRequest;
use App\Http\Resources\PersonResourceCollectionContract;
use App\Http\Resources\PersonResourceContract;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Repositories\PersonRepository;

class PersonsController extends Controller
{
    private PersonRepository $person_repository;

    public function __construct(PersonRepository $person_repository)
    {
        $this->person_repository = $person_repository;
    }

    /**
     * @return PersonResourceCollection
     */
    public function index()
    {
        return app()->makeWith(PersonResourceCollectionContract::class, [$this->person_repository->index()]);
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Person $person)
    {
        return app()->make(PersonResourceContract::class, [$person]);
    }

    /**
     * @param Request $request
     * @return PersonResource
     */
    public function store(PersonStoreRequest $request)
    {
        return app()->make(PersonResourceContract::class, [$this->person_repository->create()]);
    }

    /**
     * @param $person
     * @param Request $request
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function update(Person $person, PersonUpdateRequest $request)
    {
        return app()->make(PersonResourceContract::class, [$this->person_repository->update($person)]);
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function destroy(Person $person)
    {
        return app()->make(PersonResourceContract::class, [$this->person_repository->delete($person)]);
    }
}
