<form>
    <div class="modal-header">
        <h4 class="modal-title">Tambah Kempen</h4>
    </div>
    <div class="modal-body">
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Pilih Negeri</label>
            <div class="col-md-6">
                <select name="stateid" class="form-control" readonly required>
                    <option value="1">JOHOR</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Parlimen</label>
            <div class="col-md-6">
                <select name="parid" class="form-control" required></select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">DUN</label>
            <div class="col-md-6">
                <select name="dunid" class="form-control" required></select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">DM</label>
            <div class="col-md-6">
                <select name="dmid" class="form-control" required></select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Tajuk Kempen</label>
            <div class="col-md-9">
                <input type="text" class="form-control" name="name" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Jenis Kempen</label>
            <div class="col-md-6">
                <select name="jenis_mtdt_id" class="form-control" required>
                    @foreach($types as $type)
                    <option value="{{ $type->id }}">{{ $type->value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Lokasi</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="location" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Tarikh</label>
            <div class="col-md-6">
                <input type="date" class="form-control" name="date" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Masa</label>
            <div class="col-md-6">
                <input type="time" class="form-control" name="time" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Penganjur</label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="penganjur" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Golongan Sasaran</label>
            <div class="col-md-6">
                <select name="sasaran_mtdt_id" class="form-control" required>
                    @foreach($sasarans as $sasaran)
                    <option value="{{ $sasaran->id }}">{{ $sasaran->value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Anggaran Peserta</label>
            <div class="col-md-6">
                <input type="number" class="form-control" name="anggaran_peserta">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-quaternary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        getParlimen(1);
    });

    $(document).on("change", "select[name=parid]", function() {
        var stateid = $("select[name=stateid]").val();
        var parid = $(this).val();
        getDun(stateid, parid);
    });

    $(document).on("change", "select[name=dunid]", function() {
        var stateid = $("select[name=stateid]").val();
        var parid = $("select[name=parid]").val();
        var dunid = $(this).val();
        getDm(stateid,parid,dunid);
    });

    function getParlimen(stateid) {
        $.ajax({
            url: "{{ url('api/getParlimen') }}",
            type: "GET",
            data: "stateid=" + stateid,
            success: function(response) {
                console.log(response);
                var parlimen = '';
                $.each(response.data, function(index,value) {
                    parlimen += '<option value="'+ value.parid +'">'+ value.label1 +'</option>';
                });
                $("select[name=parid]").html('<option value="">-- Pilih Parlimen --</option>' + parlimen);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function getDun(stateid, parid) {
        $.ajax({
            url: "{{ url('api/getDun') }}",
            type: "GET",
            data: "stateid=" + stateid + "&parid=" + parid,
            success: function(response) {
                console.log(response);
                var dun = '';
                $.each(response.data, function(index,value) {
                    dun += '<option value="'+ value.dunid +'">'+ value.label1 +'</option>';
                });
                $("select[name=dunid]").html('<option value="">-- Pilih DUN --</option>' + dun);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }

    function getDm(stateid, parid, dunid) {
        $.ajax({
            url: "{{ url('api/getDm') }}",
            type: "GET",
            data: "stateid=" + stateid + "&parid=" + parid + "&dunid=" + dunid,
            success: function(response) {
                console.log(response);
                var dm = '';
                $.each(response.data, function(index,value) {
                    dm += '<option value="'+ value.dmid +'">'+ value.label1 +'</option>';
                });
                $("select[name=dmid]").html('<option value="">-- Pilih DM --</option>' + dm);
            },
            error: function(err) {
                console.log(err);
            }
        });
    }
</script>