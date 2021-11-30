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

        <div class="card">
            <div class="card-header bg-color-quaternary text-white text-1 text-uppercase">
                List {{ $title }}
            </div>
            <div class="card-body">
                <form id="formfilter">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="text" id="searchinput" class="form-control" placeholder="Search..">
                        </div>
                        @foreach($columns as $column)
                            @isset($column['filter'])
                            <div class="col-md-2">
                                <select class="form-control _filter" id="{{ $column['dt'] }}_filter">
                                    @foreach($column['filter']['value'] as $option)
                                    <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endisset
                        @endforeach
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="btn_reset">Reset</button>
                        </div>
                    </div>
                </form>
                <div class="row mt-2 mb-4">
                    <div class="col-md-2">
                        <input type="hidden" id="selectedrows" name="selectedrows" value="">
                        <select name="action" class="form-control" id="action" style="display: none">
                            <option value="" selected="selected">Select Action</option>
                            @isset($actions)
                                @foreach($actions as $action)
                                <option value="{{ $action['id'] }}">{{ $action['label'] }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    @isset($buttons)
                        @foreach($buttons as $button)
                        <button type="button" id="{{ $button['id'] }}" class="btn {{ $button['class'] }} @isset($button['modal']) displayModal @endisset" @isset($button['modal']) data-modal_url="{{ $button['link'] }}" @endisset><i class="fa {{ $button['icon'] }} fa-fw"></i> {{ $button['label'] }}</button>
                        @endforeach
                    @endisset
                </div>
                <div class="table-responsive">
                    <table id="maintable" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                @foreach($columns as $column)
                                <th>{{ $column['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                    </table>
                </div>
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
        $(document).ready(function() {
            var table = $("#maintable").DataTable({
                "dom": '<"top">rt<"bottom"ip><"clear">',
                'iDisplayLength': 25,
                'searching': true,
                'processing': true,
                'serverSide': true,
                'autoWidth': false,
                'ajax': {
                    'url': "{{ $datatable_route }}",
                    'type': 'POST',
                    'data': function(d) {
                        d._token = "{{ csrf_token() }}";
                        @foreach($columns as $column)
                            @isset($column['filter'])
                                d.{{ $column['dt'] }} = $("#{{ $column['dt'] }}_filter").val();
                            @endisset
                        @endforeach
                    }
                },
                @isset($no_select)
                @else
                'columnDefs': [{
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllPages': true,
                        'selectCallback': function() {
                            updateSelectedRows();
                        }
                    },
                    'className': 'select-checkbox',
                }],
                'select': {
                    'style': 'multi'
                },
                @endisset
                'columns': [
                    @foreach($columns as $column)
                    {
                        data: '{{ $column['dt'] }}', name: '{{ $column['dt'] }}' ,
                        visible : {{ isset($column['visible']) && $column['visible'] == false ? 'false' : 'true' }},
                        searchable : {{ isset($column['searchable']) ? 'false' : 'true' }} ,
                        orderable : {{ isset($column['orderable']) ? 'false' : 'true' }} ,
                        className: @isset($column['class']) "{{ $column['class'] }}" @else "" @endisset
                    },
                    @endforeach
                ],
                @isset($order)
                'order': [
                    [{{ $order }}, "{{ $sort_order }}"]
                ]
                @endisset
            });

            $('#maintable').on('error.dt', function(e, settings, techNote, message) {
                console.log('An error has been reported by DataTables: ', message);
            }).DataTable();

            $("#searchinput").on('keyup', delay(function() {
                var input = $("#searchinput").val();
                table.search(input, true, true).draw();
            }, 500));

            // trigger filter change
            $("._filter").change(function() {
                $("#maintable").DataTable().ajax.reload(null, false);
            });

            // reset filter
            $('#btn_reset').on('click', function() {
                $('#formfilter').get(0).reset();
                var table = $('#maintable').DataTable();
                table.search('').columns().search('').draw();
            });

            // Handle form submission event 
            $("#action").on("change", function(e) {
                var msg = '';
                @isset($actions)
                @foreach($actions as $action)
                    if($("#action").val() == "{{ $action['id'] }}") {
                        msg = "{{ $action['message'] }}";
                    }
                @endforeach
                if(confirm(msg)) {
                    var rows_selected = $("#selectedrows").val();
                    var page = "{{ url($batch_route) }}";
                    var data = {
                        _token: "{{ csrf_token() }}",
                        action: $("#action").val(),
                        ids: rows_selected.split(","),
                        row_info: row_info()
                    }
                    
                    $.post(page, data, 'json')
                    .done(function(response) {
                        console.log(response);
                        if(response.success) {
                            Swal.fire({
                                title: 'Success',
                                html: response.message,
                                icon: 'success'
                            });
                            $("#action").val('');
                        } else {
                            Swal.fire({
                                title: 'Error',
                                html: response.message,
                                icon: 'error'
                            })
                        }
                        $("#maintable").DataTable().draw();
                        $("#action").val('');
                    });
                }
                @endisset
            });
        });

        $.fn.dataTable.ext.errMode = 'none';

        $(document).on('click', '.displayModal', function(){
            $('#modal_display').removeData('bs.modal');
            $('#modal_display').modal('show').find('.modal-content').load($(this).attr('data-modal_url'));
        });
    </script>

    <script>
        function updateSelectedRows() {
            var rows_selected = $('#maintable').DataTable().column(0).checkboxes.selected();
            var rows_text = rows_selected.join(",");
            $('#selectedrows').val(rows_text);
            if (rows_text == '') $('#action').css('display', 'none');
            else $('#action').css('display', 'block');
        };

        function delay(callback, ms) {
            var timer = 0;
            return function() {
                var context = this,
                    args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function row_info() {
            var row = [];
            var data = $('#example').DataTable().rows('.selected').data();
            $.each(data, function(index, value) {
                row.push(value);
            });
            return row;
        };
    </script>

@endsection