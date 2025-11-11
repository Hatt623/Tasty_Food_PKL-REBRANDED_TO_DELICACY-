<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\About;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiAboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abouts = About::latest()->get();
        $res = [
            'success' => true,
            'data' => $abouts,
            'message' => 'List Abouts',
        ];
        return response()->json($res, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $about = About::find($id);
       if (! $about) {
        return response()->json([
            'message' => 'Data not found',
        ], 400);
       }

       return response()->json([
        'success'=> true,
        'data' => $about,
        'message' => 'Show About Detail'
       ], 200);
    }
}
