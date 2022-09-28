<?php

namespace App\Services;

use App\Models\CancelReason;
use App\Repositories\CancelReasonRepository;

class CancelReasonService
{

    protected $repo;
    public function __construct(CancelReason $repo)
    {
        $this->repo = new CancelReasonRepository($repo);
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

    public function complaints(){
        return $this->repo->complaints();
    }

    public function sendComplaint($request){
        return $this->repo->sendComplaint($request);
    }
}
