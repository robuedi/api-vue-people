<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ResourceInterface;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Http\Resources\v2\PersonResource;

class PersonsController extends Controller
{
    private ResourceInterface $resource_response;

    public function __construct(ResourceInterface $resource_response)
    {
        $this->resource_response = $resource_response;
    }
    /**
     * @param $person
     * @return PersonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Person $person)
    {
        return $this->resource_response->getResource($person);
    }
}
