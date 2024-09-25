<?php

namespace App\Models;

use App\Models\DynamicForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;

    protected $table = 'options';
    protected $guarded = [];

    public function dynamic_form()
    {
        return $this->belongsTo(DynamicForm::class);
    }
}
