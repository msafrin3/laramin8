@extends('layouts.admin')
@section('title', $title)
@section('content')

    <div class="m-4">
        <ul class="breadcrumb d-block mb-3">
            <ul class="breadcrumb d-block mb-3">
                @foreach($breadcrumb as $bread)
                    @if($bread['active'])
                    <li class="active">{{ $bread['title'] }}</li>
                    @else
                    <li>
                        <a href="{{ url('').$bread['url'] }}">{{ $bread['title'] }}</a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </ul>

        <h4>{{ $title }}</h4>

        <div class="card">
            <div class="card-header bg-color-quaternary text-white text-1 text-uppercase">
                Fill up the form
            </div>
            <div class="card-body">
                <form id="myform">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Name</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" placeholder="Enter name">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection