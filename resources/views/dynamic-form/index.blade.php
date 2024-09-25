@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="card px-2">
            <h3 class="text-center my-2">Dynamic Form</h3>
            <div class="row px-3 d-flex justify-content-between">
                <div>

                </div>
                <div>


                    @if (auth()->user()->role == 'Administration')
                        <button class="btn btn-primary  my-1"><a href="{{ route('dynamic_form.create') }}"
                                class="text-white">New Form Create</a></button>
                    @endif
                </div>
            </div>
            <div class="row px-3">
                <table border="1" class="table table-bordered my-2">
                    <thead>
                        <tr>
                            <th>Ser No</th>
                            <th>Form Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($forms as $key => $form)
                            <tr>
                                <td>{{ $loop->iteration ?? '' }}</td>
                                <td>
                                    <a href="{{ route('dynamic_form_value.create', $form->slug) }}">
                                        <button type="button" class="btn btn-primary" data-toggle="tooltip"
                                            data-placement="top" title="THIS IS TOOLTIP">
                                            {{ $form->name }}
                                        </button>
                                    </a>
                                </td>
                                <td class="d-flex justify-content-center">
                                    {{-- <a href="{{route('dynamic_form.show',$form->slug)}}">
                                        <button class="btn btn-sm btn-info mx-2">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </a>
                                    <a href="{{route('dynamic_form.edit',$form->slug)}}">
                                        <button class="btn btn-sm btn-info">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </a> --}}
                                    <a href="{{ route('dynamic_form.all_users', $form->slug) }}">
                                        <button class="btn btn-sm btn-info mx-1">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No record here</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        h3 {
            color: black;
        }

        .table {
            color: black;
        }

        .table tr th,
        .table tr td {
            text-align: center
        }
    </style>
@endpush
