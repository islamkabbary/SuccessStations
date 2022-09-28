<?php

namespace App\Repositories;

use App\Helpers\FileHelper;
use App\Http\Traits\CrudTrait;
use App\Http\Traits\MainTrait;
use App\Http\Traits\ResponseTraits;
use App\Models\Complaint;
use Illuminate\Database\Eloquent\Model;

class CancelReasonRepository
{
    use CrudTrait, ResponseTraits, MainTrait;

    protected $country;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->indexTrait($this->model);
    }

    public function show($id)
    {
        return $this->showTrait($this->model, $id);
    }

    public function store($request)
    {
        $data = $request->except('_method', '_token');
        return $this->storeTrait($this->model, $data);
    }

    public function update($id, $request)
    {
        $data = $request->except('_method', '_token');
        return $this->updateTrait($this->model, $id, $data);
    }

    public function destroy($id)
    {
        return $this->destroyTrait($this->model, $id);
    }
    public function complaints()
    {
        return Complaint::orderBy('id', 'DESC')->get();
    }
    public function sendComplaint($request)
    {
        $data = $request->except('_method', '_token', 'file');
        if ($request->hasFile('file')) {
            $file_path = FileHelper::upload_file('complaints', $request->file);
            $data['file'] = $file_path;
        }
        $data['user_id'] = auth()->user()->id;
        Complaint::create($data);
        return true;
    }
}
