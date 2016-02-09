<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    protected $table = 'report_types';

    protected $guarded = ['id'];

    public $timestamps = true;
}
