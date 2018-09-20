<?php

namespace App\Http\Controllers;
use App\Http\Controllers\BaseAPIController; 
use App\Post;
use Validator;
use Illuminate\Http\Request;

class PostAPIController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::all();
        return $this->sendResponse($posts->toArray(), 
        'Posts retrived successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'  => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error. ',
         $validator->errors());
        }
        $post = Post::create($input);

        return $this->sendResponse($post->toArray(), 'Post 
        created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if(is_null($post)){
            return $this->sendError('Post not found.');
        }
        return $this->sendResponse($post->toArray(), 'Post 
        retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error. ',
        $validator->errors());
        }
        $post = Post::find($id);
        if(is_null($post)){
            return $this->sendError('Post not found');
        }
        $post->name = $input['name'];
        $post->description = $input['description'];
        $post->save();
        return $this->sendResponse($post->toArray(), 'Post updated 
        successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if(is_null($post)){
            return $this->sendError('Post not found');
        }
        $post->delete();
        return $this->sendResponse($id, 'Id deleted 
        successfully');
    }
}
