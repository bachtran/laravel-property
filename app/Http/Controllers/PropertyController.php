<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Property::all();
    }


    public function show($id)
    {
        return \App\Property::findOrFail($id);
    }

    public function store(Request $request)
    {
        $params = $request->only(['guid', 'suburb', 'state', 'country']);
        if (count($params) != 4) {
            return response()->json(['error' => 'guid, suburb, state and country are required'], 400);
        }
        return \App\Property::create($params);
    }

    public function add_analytic($property_id, $analytic_id, Request $request)
    {
        $value = $request->input('value');
        if ($value == null) {
            return response()->json(['error' => 'value is required'], 400);
        }
        $property = \App\Property::findOrFail($property_id);
        $property->analytics()->attach($analytic_id, ['value' => $request->input('value')]);
        return $property;
    }
}
