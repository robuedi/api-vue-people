<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PersonStoreRequest;
use App\Http\Requests\v1\PersonUpdateRequest;
use App\Http\Resources\v1\PersonResource;
use App\Repositories\PersonRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Http\Response;

class PersonsController extends Controller
{
    private PersonRepositoryInterface $person_repository;

    public function __construct(PersonRepositoryInterface $person_repository)
    {
        $this->person_repository = $person_repository->setVersion(1);
    }

    /**
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function index()
    {
        return PersonResource::collection($this->person_repository->index())->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Person $person)
    {
        return PersonResource::make($person)->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(PersonStoreRequest $request)
    {
        return PersonResource::make($this->person_repository->create())->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param $person
     * @param Request $request
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function update(Person $person, PersonUpdateRequest $request)
    {
        return PersonResource::make($this->person_repository->update($person))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function destroy(Person $person)
    {
        return PersonResource::make($this->person_repository->delete($person))->response()->setStatusCode(Response::HTTP_OK);
    }
}
