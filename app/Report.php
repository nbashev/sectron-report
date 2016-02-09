<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function type()
    {
        return $this->hasOne('App\ReportType', 'id', 'type_id');
    }

    public function lists()
    {
        return $this->hasMany('App\Lista', 'report_id', 'id');
    }

    // public function lists()
    // {
    //     return $this->belongsToMany('App\Lista', 'lists_reports', 'report_id', 'list_id');
    // }
}
