<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $contacts = contact::latest()->get();
        $res = [
            'success' => true,
            'data' => $contacts,
            'message' => 'List Contacts',
        ];
        return response()->json($res, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|min:1|max:100',
            'name' => 'required|min:1|max:100',
            'email' => 'required|min:1|max:100',
            'message' => 'required|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }

        $contact =          new Contact;
        $contact ->subject  = $request->subject;
        $contact ->name     = $request->name;
        $contact ->email    = $request->email;
        $contact ->message  = $request->message;

        $contact->save();

        // Response
        $res = [
            'success' => true,
            'data' => $contact,
            'message' => 'Store Contact'
        ];
        return response()->json($res, 200);
    }
}
