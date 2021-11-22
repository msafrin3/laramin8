@extends('layouts.admin')
@section('title', $title)
@section('content')

    <div class="m-4">
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

        <h4>{{ $title }}</h4>

        <div class="mb-3">
            @isset($buttons)
                @foreach($buttons as $button)
                <button type="button" id="{{ $button['id'] }}" class="btn {{ $button['class'] }} @isset($button['modal']) displayModal @endisset" @isset($button['modal']) data-modal_url="{{ $button['link'] }}" @endisset><i class="fa {{ $button['icon'] }} fa-fw"></i> {{ $button['label'] }}</button>
                @endforeach
            @endisset
        </div>

        <div class="card">
            <div class="card-header bg-color-quaternary text-white text-1 text-uppercase">
                List {{ $title }}
            </div>
            <div class="card-body">
                <form>
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

    <div class="modal fade" id="modal_display">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

@endsection
@section('footerScripts')

    <script>
        $(document).on('click', '.displayModal', function(){
            $('#modal_display').removeData('bs.modal');
            $('#modal_display').modal('show').find('.modal-content').load($(this).attr('data-modal_url'));
        });
    </script>

@endsection