@extends('layouts.admin')
@section('title', 'Welcome to Laravel Admin 8')
@section('content')

    <!-- Lightweight client-side loader that feature-detects and load polyfills only when necessary -->
    <script src="https://cdn.jsdelivr.net/npm/@webcomponents/webcomponentsjs@2/webcomponents-loader.min.js"></script>

    <!-- Load the element definition -->
    <script type="module" src="https://cdn.jsdelivr.net/gh/zerodevx/zero-md@1/src/zero-md.min.js"></script>

    <div class="container my-5 pb-4">

        <div class="card">
            <div class="row text-center pt-4">
                <div class="col">
                    <h2 class="word-rotator slide font-weight-bold text-8 mb-2">
                        <span>Welcome to </span>
                        <span class="word-rotator-words bg-primary" style="width: 130.266px;">
                            <b class="is-visible">Laravel</b>
                            <b class="is-hidden">Admin</b>
                        </span>
                        <span> 8</span>
                    </h2>
                </div>
            </div>
            <div class="card-body"><zero-md src="{{ url('') }}/README.md"></zero-md></div>
        </div>

    </div>

@endsection