<?php

namespace App\Services;

use App\Models\City;
use App\Repositories\CityRepository;

class CityService
{

    protected $repo;
    public function __construct(City $repo)
    {
        $this->repo = new CityRepository($repo);
    }

    public function index()
    {
        return $this->repo->index();
    }

    public function show($id)
    {
        return $this->repo->show($id);
    }

    public function store($request){

        return $this->repo->store($request);
    }

    public function update($id, $request){
        return $this->repo->update($id,$request);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }

    public function getCities($id)
    {
        return $this->repo->getCities($id);
    }

}
