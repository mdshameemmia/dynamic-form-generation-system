<?php

namespace App\Models;

use App\Models\DynamicUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicFormValue extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'dynamic_form_values';

    public function dynamicUser()
    {
        return $this->belongsTo(DynamicUser::class);
    }

}
