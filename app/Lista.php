<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{     
    protected $table = 'lists';

    protected $guarded = ['id'];

    public $timestamps = true;

    // public function reports()
    // {
    //     return $this->belongsToMany('App\Report', 'lists_reports', 'list_id', 'report_id');
    // }
}
