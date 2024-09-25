@extends('layouts.master')
@section('content')
    <div class="container card py-4 ">
        <div class="row my-2">
            <div class="col-md-12 text-center text-dark mx-3 h4">Google Form</div>
        </div>

        <form action="{{ route('dynamic_form_value.store', $dynamic_forms[0]->slug) }}" method="POST">
            @csrf
            @foreach ($dynamic_forms as $dynamic_form)
                @if ($dynamic_form->type == 'short_answer')
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <input type="text" name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                            class="form-control" @if ($dynamic_form->required) required @endif>
                    </div>
                @elseif($dynamic_form->type == 'long_answer')
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <textarea type="text" name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                            class="form-control" cols="20" rows="2" @if ($dynamic_form->required) required @endif>
                        </textarea>
                    </div>
                @elseif($dynamic_form->type == 'multiple_choice')
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            @foreach ($dynamic_form->options as $option)
                                <input type="radio"
                                    name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                                    value="{{ $option->value }}" @if ($dynamic_form->required) required @endif>
                                <label for="" class="mt-2 mx-3">{{ $option->value }}</label>
                            @endforeach
                        </div>
                    </div>
                @elseif($dynamic_form->type == 'checkbox')
                    @php
                        $dropdownOptions = [];
                        foreach ($dynamic_form->options as $option) {
                            $dropdownOptions[$option->value] = $option->value;
                        }
                    @endphp

                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            @foreach ($dynamic_form->options as $option)
                                <input type="checkbox"
                                    name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}[]"
                                    value="{{ $option }}">
                                <label for="" class="mt-2 mx-3">{{ $option }}</label>
                            @endforeach
                        </div>
                    </div>
                @elseif($dynamic_form->type == 'dropdown')
                    @php
                        $dropdownOptions = [];
                        foreach ($dynamic_form->options as $option) {
                            $dropdownOptions[$option->value] = $option->value;
                        }
                    @endphp

                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <div class="form-group d-flex">
                            <select name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                                class="form-control" @if ($dynamic_form->required) required @endif>
                                <option value="">Select One </option>
                                @foreach ($dropdownOptions as $option)
                                    <option value="{{ $option }}">{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @elseif ($dynamic_form->type == 'date')
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <input type="date" name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                            class="form-control" @if ($dynamic_form->required) required @endif>
                    </div>
                @elseif($dynamic_form->type == 'time')
                    <div class="form-group">
                        <label for="" class="my-0">{{ $dynamic_form->dynamic_field ?? '' }}</label>
                        <input type="number" placeholder="e.g 1220"
                            name="{{ Illuminate\Support\Str::slug($dynamic_form->dynamic_field, '_') }}"
                            class="form-control" @if ($dynamic_form->required) required @endif>
                    </div>
                @endif
            @endforeach

            <div class="row d-flex justify-content-center" id="btn_container">
                <button type="submit" class="btn btn-primary btn-sm mx-1">Submit</button>
            </div>

        </form>

    </div>
@endsection

@push('js')
@endpush
