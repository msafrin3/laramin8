<form id="myform">
    <div class="modal-header">
        <h4 class="modal-title">{{ $title }}</h4>
    </div>
    <div class="modal-body">
        @foreach($forms as $form)
        <div class="form-group row">
            <label class="col-md-3 col-form-label">{{ $form['label'] }}</label>
            <div class="col-md-9">
                @if($form['type'] == 'input')
                <input
                    @foreach($form['attributes'] as $attr_label => $attr_value)
                    {{ $attr_label }}="{{ $attr_value }}"
                    @endforeach
                >
                @elseif($form['type'] == 'checkbox')
                    @foreach($form['options'] as $option)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                        name="{{ $form['name'] }}[]" 
                        value="{{ $option['id'] }}" 
                        id="check{{ $form['name'].$option['id'] }}" 
                        @isset($option['is_checked']) @if($option['is_checked'] == 1) checked="checked" @endif @endisset>
                        <label class="form-check-label" for="check{{ $form['name'].$option['id'] }}">
                            {{ $option['name'] }}
                        </label>
                    </div>
                    @endforeach
                @elseif($form['type'] == 'dropdown')
                    <select 
                    @foreach($form['attributes'] as $attr_label => $attr_value)
                    {{ $attr_label }}="{{ $attr_value }}"
                    @endforeach
                    >
                        @foreach($form['options'] as $option)
                        <option value="{{ $option['id'] }}" @isset($option['is_checked']) @if($option['is_checked'] == 1) selected @endif @endisset>{{ $option['name'] }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-quaternary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    $("#myform").submit(function(e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: "{{ $posturl }}",
            type: "POST",
            enctype: "multipart/form-data",
            data: new FormData($("#myform")[0]),
            processData: false,
            contentType: false,
            cache: false,
            success: function(response) {
                console.log(response);
                if(response.success) {
                    $("#modal_display").modal('toggle');
                    Swal.fire({
                        title: 'Success',
                        html: response.message,
                        icon: 'success'
                    });
                    $("#maintable").DataTable().draw();
                } else {
                    Swal.fire({
                        title: 'Error',
                        html: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(err) {
                console.log(err);
            }
        });
    });
</script>