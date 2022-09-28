<?php

namespace App\Repositories;

use App\Helpers\FileHelper;
use App\Http\Traits\CrudTrait;
use App\Http\Traits\MainTrait;
use App\Http\Traits\ResponseTraits;
use Illuminate\Database\Eloquent\Model;
class BrandRepository
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

    public function store($request){
        $data = $request->except('_method' , '_token' , 'image');
        if($request->hasFile('image')){
            $image_path = FileHelper::upload_file('brands' , $request->image);
            $data['image'] = $image_path;
        }
        return $this->storeTrait($this->model ,$data);
    }

    public function update($id, $request){
        $data = $request->except('_method' , '_token' , 'image');
        $tag = $this->model->where('id',$id)->first();
        if($request->hasFile('image')){
            $image_path = FileHelper::update_file('tags' , $request->image ,$tag->image );
            $data['image'] = $image_path;
        }
        return $this->updateTrait($this->model, $id, $data);
    }

    public function destroy($id)
    {
        return $this->destroyTrait($this->model, $id);
    }


}
