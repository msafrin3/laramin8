<div class="modal-header">
    <h4 class="modal-title">Maklumat Kempen</h4>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Negeri</th>
                <td>{{ $kempen->State() }}</td>
            </tr>
            <tr>
                <th>Parlimen</th>
                <td>{{ $kempen->Parlimen() }}</td>
            </tr>
            <tr>
                <th>DUN</th>
                <td>{{ $kempen->Dun() }}</td>
            </tr>
            <tr>
                <th>DM</th>
                <td>{{ $kempen->Dm() }}</td>
            </tr>
            <tr>
                <th>Tajuk</th>
                <td>{{ $kempen->name }}</td>
            </tr>
            <tr>
                <th>Jenis Kempen</th>
                <td>{{ $kempen->Type->value }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $kempen->location }}</td>
            </tr>
            <tr>
                <th>Tarikh / Masa</th>
                <td>{{ date('F d, Y H:i:s',strtotime($kempen->date.' '.$kempen->time.':00')) }}</td>
            </tr>
            <tr>
                <th>Penganjur</th>
                <td>{{ $kempen->penganjur }}</td>
            </tr>
            <tr>
                <th>Sasaran</th>
                <td>{{ $kempen->Sasaran->value }}</td>
            </tr>
            <tr>
                <th>Tetamu / VIP yang hadir</th>
                <td>
                    <ul>
                        @foreach($kempen->Vips as $vip)
                        <li>{{ $vip->name }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <th>Anggaran Peserta</th>
                <td>{{ $kempen->anggaran_peserta }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $kempen->Kategori->value }}</td>
            </tr>
            <tr>
                <th>Pegawai Bertanggungjawab</th>
                <td>{{ $kempen->User->name }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-quaternary" data-bs-dismiss="modal">Batal</button>
</div>