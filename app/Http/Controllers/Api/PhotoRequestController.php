<?php

namespace App\Http\Controllers;

use App\Models\PhotoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoRequestController extends Controller
{
    public function index()
    {
        $data = DB::table('photo_requests')
                ->join('users','users.id','=','photo_requests.user_id')
                ->select("*")
                ->paginate();

        return response()->json([
            'data' => $data,
        ]);  
    }

    public function create(Request $request)
    {
        $input = $request->all();

        DB::table('photo_requests')->insert([
            'user_id' => $input['user_id'],
            'description' => $input['description'],
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name,
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
