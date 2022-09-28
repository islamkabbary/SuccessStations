<?php

namespace App\Services;

use App\Models\PromoCode;
use App\Repositories\PromoCodeRepository;

class PromoCodeService
{

    protected $repo;
    public function __construct(PromoCode $repo)
    {
        $this->repo = new PromoCodeRepository($repo);
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

}
