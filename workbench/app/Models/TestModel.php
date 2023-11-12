<?php

namespace Workbench\App\Models;

use Illuminate\Database\Eloquent\Model;
use Traffordfewster\AccessCode\Traits\InteractsWithAccessCodes;

class TestModel extends Model
{
    use InteractsWithAccessCodes;

    protected $guarded = [];
}