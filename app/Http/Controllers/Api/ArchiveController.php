<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $data = DB::table('archives')
                ->leftJoin('user_posts','user_posts.id','=', 'archives.user_post_id')
                ->distinct()
                ->select("user_posts.photo")
                ->where('archives.user_id','=',$userId)
                ->get();

        return response()->json([
            'data' => $data
        ]); 
    }

    public function create(Request $request)
    {
        $input = $request->all();
        DB::table('archives')->insert([
            'user_id' => $request->user()->id,
            'user_post_id' => $input['user_post_id'],
        ]);

        return response()->json([
            'data' => 'Ok'
        ]); 
    }

    public function unArchive($id) {
        DB::table('archives')->where("id","=",$id)->delete();

        return response()->json([
            'data' => 'Ok'
        ]); 
    }

}
