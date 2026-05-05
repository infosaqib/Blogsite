<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Library extends Model
{
    //if you have different table name, use:
    //protected $table = "table_name";

    public function test()
    {
        echo "This is a test function";
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
