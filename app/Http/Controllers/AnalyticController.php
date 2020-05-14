<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \App\Analytic::all();
    }


    public function show($id)
    {
        return \App\Analytic::findOrFail($id);
    }

    public function store(Request $request)
    {
        $params = $request->only(['name', 'units', 'is_numeric', 'num_decimal_places']);
        if (count($params) != 4) {
            return response()->json(['error' => 'name, units, is_numeric and num_decimal_places are required'], 400);
        }
        return \App\Analytic::create();
    }

    public function summary_by_suburb($suburb)
    {
        // Get properties with filter
        $properties = \App\Property::where('suburb', $suburb)->get();
        $result = $this->summarise_analytics($properties);
        return ['summary' => $result];
    }

    public function summary_by_state($state)
    {
        // Get properties with filter
        $properties = \App\Property::where('state', $state)->get();
        $result = $this->summarise_analytics($properties);
        return ['summary' => $result];
    }

    public function summary_by_country($country)
    {
        // Get properties with filter
        $properties = \App\Property::where('country', $country)->get();
        $result = $this->summarise_analytics($properties);
        return ['summary' => $result];
    }

    /*
     * Calculate analytics summary
     */
    /**
     * @param $properties
     * @return array
     */
    private function summarise_analytics($properties): array
    {
        $bins = [];
        foreach ($properties as $property) {
            // Put analytics in bins by type
            foreach ($property->analytics as $analytic) {
                if (!array_key_exists($analytic->id, $bins)) {
                    $bins[$analytic->id]['data'] = collect([]);
                    $bins[$analytic->id]['obj'] = $analytic;
                }
                $bins[$analytic->id]['data'] [] = $analytic->pivot;
            }
        }
        $result = [];
        $property_count = $properties->count();
        foreach ($bins as $analytic_id => $analytic_value) {
            // For each analytic calculate min, max, median and percentage of properties with a value
            $min = $analytic_value['data']->min('value');
            $max = $analytic_value['data']->max('value');
            $median = $analytic_value['data']->median('value');
            $count = $analytic_value['data']->count();
            $percentage_with_analytic = $count / $property_count * 100;
            $analytic_type_obj = $analytic_value['obj'];
            $result []= [
                'id' => $analytic_type_obj->id,
                'name' => $analytic_type_obj->name,
                'units' => $analytic_type_obj->units,
                'min' => $min,
                'max' => $max,
                'median' => $median,
                'percentage_with_analytic' => $percentage_with_analytic,
                'percentage_without_analytic' => 100-$percentage_with_analytic,
            ];
        }
        return $result;
    }
}
