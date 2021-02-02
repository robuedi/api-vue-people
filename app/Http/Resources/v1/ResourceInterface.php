<?php


namespace App\Http\Resources\v1;

use App\Models\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ResourceInterface
{
    public function getResource(Person $model);
    public function getResourceCollection(LengthAwarePaginator $model);
}
