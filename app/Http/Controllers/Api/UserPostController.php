<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPost;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserPostController extends Controller
{
    public function search(Request $request){
        $name = $request->query('name');

        $data = DB::table('user_posts')
            ->join('users', 'users.id', '=', 'user_posts.user_id')
            ->where('user_posts.description', 'LIKE', '%' . $name . '%')
            ->select('*')
            ->get();

        return response()->json([
            'data' => $data,
        ]);  
    }

    public function like($id){
        $data = UserPost::findOrFail($id);
        $data->update([
            'likes' => $data['likes'] + 1
        ]);

        return response()->json([
            'data' => $data,
        ]);  
    }

    public function unLike($id){
        $data = UserPost::findOrFail($id);
        $data->update([
            'likes' => $data['likes'] - 1
        ]);

        return response()->json([
            'data' => $data,
        ]);  
    }

    public function getAll(){
        $data = DB::table('user_posts')
            ->join('users', 'users.id', '=', 'user_posts.user_id')
            ->select('user_posts.id','user_posts.*', 'users.name')
            ->get();

        return response()->json([
            'data' => $data,
        ]); 
    }

    public function getMyPost(Request $request){
        $userId = $request->user()->id;

        $data = DB::table('user_posts')
            ->join('users', 'users.id', '=', 'user_posts.user_id')
            ->where('users.id','=',$userId)
            ->select('*')
            ->get();

        return response()->json([
            'data' => $data,
        ]); 
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'description' => 'required'
        ]);

        if($validator->fails()){
            throw new Exception($validator->messages());
        }

        $input = $request->all();

        $input['photo'] = $request
            ->file('photo')
            ->store('assets/posts', 'public');

        $data = UserPost::create($input);

        return response()->json([
            'data' => $data,
        ]); 
    }

    public function getById(array $input)
    {
        $data = UserPost::findOrFail($input['id']);

        return response()->json([
            'data' => $data,
        ]);
    }

    public function update(object $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            throw new Exception($validator->messages());
        }

        $post = UserPost::findOrFail($request['id']);
        $input = $request->all();

        if ($request->hasFile('photo')) {
            Storage::delete('public/' . $post->photo);
            $input['photo'] = $request
                ->file('photo')
                ->store('assets/posts', 'public');
        }

        $post->update($input);

        return response()->json([
            'data' => $post,
        ]);
    }

    public function delete(array $input)
    {
        $post = UserPost::findOrFail($input['id']);

        $post->delete();

        Storage::delete('public/' . $post->photo);

        return $this->response()->json([
            'message' => 'Data Successfully Delete'
        ]);
    }
}
