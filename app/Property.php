<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /*
     * The analytics of a property
     */
    public function analytics() {
        return $this->belongsToMany('App\Analytic', 'property_analytics',
        'property_id', 'analytic_type_id')->withTimestamps()->withPivot('value');
    }

    protected $fillable = ['guid', 'suburb', 'state', 'country'];
}
