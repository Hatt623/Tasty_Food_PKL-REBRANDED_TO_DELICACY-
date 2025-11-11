<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->get();
        $res = [
            'success' => true,
            'data' => $news,
            'message' => 'List News',
        ];
        return response()->json($res, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $news = News::find($id);
       if (! $news) {
        return response()->json([
            'message' => 'Data not found',
        ], 400);
       }

       return response()->json([
        'success'=> true,
        'data' => $news,
        'message' => 'Show News Detail'
       ], 200);
    }

}
