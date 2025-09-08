<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Product;
use App\Models\Contact;
use App\Models\About;

class BackendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalNews = News::count();
        $totalProducts = Product::count();
        $totalContacts = Contact::count();
        $contacts = Contact::all();

        return view('backend.index', compact('totalNews', 'totalProducts', 'totalContacts', 'contacts' )); 
    }
   
}
