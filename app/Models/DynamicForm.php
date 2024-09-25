<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicForm extends Model
{
    use HasFactory;

    protected $table = "dynamic_forms";

    protected $guarded = [];

    public function options(){
        return $this->hasMany(Option::class);
    }
}
