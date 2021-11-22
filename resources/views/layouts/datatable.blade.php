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
                <div class="row">
                    <div class="col-md-2">
                        <input type="text" class="form-control" placeholder="Search..">
                    </div>
                    <div class="col-md-2">
                        <select class="form-control">
                            <option value="">Select something</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary">Reset</button>
                    </div>
                </div>
                <div class="row mt-2 mb-4">
                    <div class="col-md-2">
                        <input type="hidden" id="selectedrows" name="selectedrows" value="">
                        <select name="action" class="form-control" id="action" style="display: none">
                            <option value="" selected="selected">Select Action</option>
                            <option value="">Delete</option>
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
                'columns': [
                    @foreach($columns as $column)
                    {
                        data: '{{ $column['dt'] }}', name: '{{ $column['dt'] }}' ,
                        visible : {{ isset($column['visible']) && $column['visible'] == false ? 'false' : 'true' }},
                        searchable : {{ isset($column['searchable']) ? 'false' : 'true' }} ,
                        orderable : {{ isset($column['orderable']) ? 'false' : 'true' }} ,
                    },
                    @endforeach
                ]
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