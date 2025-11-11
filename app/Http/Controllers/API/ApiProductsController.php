<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->get();
        $res = [
            'success' => true,
            'data' => $products,
            'message' => 'List Products',
        ];
        return response()->json($res, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $product = Product::find($id);
       if (! $product) {
        return response()->json([
            'message' => 'Data not found',
        ], 400);
       }

       return response()->json([
        'success'=> true,
        'data' => $product,
        'message' => 'Show product Detail'
       ], 200);
    }

}
