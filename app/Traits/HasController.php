<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $table = app($this->model)->getTable();
        $ability = $table . ".index";
        $this->authorize($ability, Auth::user());

        $query = $this->model::relationships(request())
            ->count(request());

        if (request()->has('page')):
            $per_page = request()->per_page ?: 50;
            return $query->paginate($per_page);
        endif;

        return $query->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $table = app($this->model)->getTable();
        $ability = $table . ".create";
        $this->authorize($ability, Auth::user());

        $model = new $this->model;
        $model->fill($request->all());
        $model->save();

        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $table = app($this->model)->getTable();
        $ability = $table . ".show";
        $this->authorize($ability, Auth::user());

        $model = $this->model::findOrFail($id);
        return $model;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $table = app($this->model)->getTable();
        $ability = $table . ".update";
        $this->authorize($ability, Auth::user());

        $model = $this->model::findOrFail($id);
        $model->fill($request->all());
        $model->save();

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = app($this->model)->getTable();
        $ability = $table . ".delete";
        $this->authorize($ability, Auth::user());

        $model = $this->model::findOrFail($id);
        $model->delete();

        return $model;
    }

}
