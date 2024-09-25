@extends('layouts.master')
@section('content')
    <div class="container card py-4 ">
        <div class="row my-2">
            <div class="col-md-12 text-center text-dark mx-3 h4">Google Form</div>
        </div>

        <form action="{{ route('dynamic_form_value.update',$form_slug->dynamic_user_id) }}" method="POST">
            @csrf
            @foreach ($dynamic_forms as $dynamic_form)
                @if ($dynamic_form->type == 'short_answer')
                    @php
                        $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                    @endphp
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <input type="text" name="{{$field_name}}"
                            class="form-control" @if ($dynamic_form->required)
                                required
                            @endif
                         value="{{$form_values[$field_name] ?? ''}}"    
                        >
                    </div>
                @elseif($dynamic_form->type == 'long_answer')
                    @php
                        $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                    @endphp

                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <textarea type="text"  name="{{$field_name}}"
                            class="form-control" cols="20" rows="2" @if ($dynamic_form->required)
                            required
                        @endif>
                        {{$form_values[$field_name] ?? ''}}   
                        </textarea>
                    </div>
                @elseif($dynamic_form->type == 'multiple_choice')
                    <div class="form-group">
                        @php
                        $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                        @endphp

                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            @foreach ($dynamic_form->options as $option)
                                <input type="radio"
                                    name="{{$field_name}}" @if ($form_values[$field_name] == $option->value)
                                        checked
                                    @endif value="{{$option->value}}" @if ($dynamic_form->required)
                                    required
                                @endif>
                                <label for="" class="mt-2 mx-3">{{ $option->value }}</label>
                            @endforeach
                        </div>
                    </div>
                @elseif($dynamic_form->type == 'checkbox')
                    <div class="form-group">
                        @php
                        $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                        $values = json_decode($form_values[$field_name],true);
                        @endphp
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            @foreach ($dynamic_form->options as $option)
                                <input type="checkbox"
                                    name="{{$field_name}}[]" value="{{$option->value}}"
                                @if (in_array($option->value, $values))
                                        checked
                                    @endif
                                >
                                <label for="" class="mt-2 mx-3">{{ $option->value }}</label>
                            @endforeach
                        </div>
                    </div>
                @elseif($dynamic_form->type == 'dropdown')
                    @php
                    $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                    @endphp

                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            <select name="{{$field_name}}"
                                class="form-control" @if ($dynamic_form->required)
                                required
                            @endif>
                                <option value="">Select One </option>
                                @foreach ($dynamic_form->options as $option)
                                    <option value="{{ $option->value }}" 
                                        @if ($form_values[$field_name] == $option->value)
                                        selected
                                    @endif>{{ $option->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif ($dynamic_form->type == 'date')
                    @php
                    $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                    @endphp

                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <input type="date" name="{{$field_name}}"
                            class="form-control" @if ($dynamic_form->required)
                            required
                            @endif
                            value="{{$form_values[$field_name] ?? ''}}"
                        >
                    </div>
                @elseif($dynamic_form->type =='time')
                @php
                $field_name = Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_');
                @endphp
             
                <div class="form-group">
                    <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                    <input type="number" placeholder="e.g 1220" name="{{ $field_name }}"
                        class="form-control" @if ($dynamic_form->required)
                        required
                        @endif
                        value="{{$form_values[$field_name] ?? ''}}"
                    >
                </div>
                @endif
            @endforeach

            <div class="row d-flex justify-content-center" id="btn_container">
                <button type="submit" class="btn btn-primary btn-sm mx-1">Update</button>
            </div>

        </form>


    </div>
@endsection

@push('js')
@endpush
