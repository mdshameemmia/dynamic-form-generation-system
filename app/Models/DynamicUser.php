<?php

namespace App\Models;

use App\Models\User;
use App\Models\DynamicFormValue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DynamicUser extends Model
{
    use HasFactory;

    protected $table = 'dynamic_users';

    protected $guarded = [];

    public function dynamicFormValues()
    {
        return $this->hasMany(DynamicFormValue::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
