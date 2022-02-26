@extends('layouts.statistic')
@section('headerScripts')

    <style>
        .box {
            display: flex;
            margin: 10px;
            width: 100%;
            flex-wrap: wrap;
        }
        .box-item {
            width: 19%;
            border: 1px solid white;
            margin: 5px;
            padding: 10px;
            border-radius: 4px;
        }
    </style>

@endsection
@section('content')

    {{-- <div class="dark:bg-gray-800">asdasdasd</div> --}}
    <div class="box">
        @for($i = 1;$i <= 56;$i++)
        <div class="box-item dark:bg-gray-800">N{{ $i }}</div>
        @endfor
    </div>

@endsection