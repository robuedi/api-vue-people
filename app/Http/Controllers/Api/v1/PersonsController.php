<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\PersonStoreRequest;
use App\Http\Requests\v1\PersonUpdateRequest;
use App\Http\Resources\v1\PersonResource;
use App\Http\Resources\v1\PersonResourceCollection;
use App\Http\Resources\v1\ResourceInterface;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Repositories\PersonRepository;

class PersonsController extends Controller
{
    private ResourceInterface $resource_response;
    private PersonRepository $person_repository;

    public function __construct(ResourceInterface $resource_response, PersonRepository $person_repository)
    {
        $this->resource_response = $resource_response;
        $this->person_repository = $person_repository;
    }

    /**
     * @return PersonResourceCollection
     */
    public function index() : PersonResourceCollection
    {
        return $this->resource_response->getResourceCollection($this->person_repository->getAllPaginate());
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Person $person)
    {
        return $this->resource_response->getResource($person);
    }

    /**
     * @param Request $request
     * @return PersonResource
     */
    public function store(PersonStoreRequest $request)
    {
        return $this->resource_response->getResource($this->person_repository->create());
    }

    /**
     * @param $person
     * @param Request $request
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function update(Person $person, PersonUpdateRequest $request)
    {
        return $this->resource_response->getResource($this->person_repository->update($person));
    }

    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function destroy(Person $person)
    {
        return $this->resource_response->getResource($this->person_repository->delete($person));
    }
}
