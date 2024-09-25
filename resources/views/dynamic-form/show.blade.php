@extends('layouts.master')
@section('content')
    <div class="card py-5">
        <h2 class="text-center font-weight-bold text-dark mb-3">{{ Illuminate\Support\Str::headline($form_values[0]->dynamic_form_slug, ' ')}}</h2>
        <div class="row text-center ">
            @foreach ($form_values as $form_value)
                <div class="col-md-6">
                    <p class="font-weight-bold">{{ Illuminate\Support\Str::headline($form_value->field_name, ' ')}}</p>
                </div>
                <div class="col-md-6">
                    @php
                        $values = json_decode($form_value->field_value,true);
                       
                    @endphp
                    @if (is_array($values))
                        @foreach ($values as $value)
                            {{$value}} ,
                        @endforeach
                    @else    
                    {{$form_value->field_value??''}}
                    @endif
                </div>
                @endforeach
            </div>
      
    </div>
@endsection