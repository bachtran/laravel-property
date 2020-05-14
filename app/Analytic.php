<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    public $table = 'analytic_types';
    /*
     * Properties with this analytic type
     */
    public function assoc_properties() {
        return $this->belongsToMany('App\Property', 'property_analytics',
        'analytic_type_id', 'property_id')->withTimestamps()->withPivot('value');
    }

    protected $fillable = ['name', 'units', 'is_numeric', 'num_decimal_places'];
}
