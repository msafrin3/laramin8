<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Kempen;
use App\Models\Meta;
use App\Models\Metadata;

class KempenController extends Controller
{
    
    public function index() {
        $data['layout'] = 'layouts.app';
        $data['title'] = 'Jadual Kempen';
        $data['datatable_route'] = route('kempen.list');
        $data['batch_route'] = route('kempen.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Laman Utama',
                'url' => '/',
                'active' => false
            ),
            array(
                'title' => 'Jadual Kempen',
                'url' => '',
                'active' => true
            )
        );
        $data['buttons'] = array(
            array(
                'id' => 'addkempen',
                'label' => 'Tambah Maklumat',
                'class' => 'btn-primary',
                'icon' => 'fa-plus-circle',
                'modal' => true,
                'link' => route('kempen.add')
            )
        );
        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id'
            ),
            array(
                'dt' => 'name',
                'label' => 'Tajuk'
            ),
            array(
                'dt' => 'parlimen',
                'label' => 'Parlimen'
            ),
            array(
                'dt' => 'dun',
                'label' => 'DUN'
            ),
            array(
                'dt' => 'type',
                'label' => 'Jenis Kempen'
            ),
            array(
                'dt' => 'location',
                'label' => 'Lokasi'
            ),
            array(
                'dt' => 'date',
                'label' => 'Tarikh/Masa'
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'deletekempen',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete this data?',
                'route' => url('kempen/batch')
            )
        );
        return view('layouts.datatable', $data);
    }

    public function list(Request $request) {
        $kempens = Kempen::query();

        return DataTables::eloquent($kempens)
            ->editColumn('parlimen', function($query) {
                return $query->Parlimen;
            })
            ->make(true);
    }

    public function create() {
        $types = Meta::where('name', 'jenis')->first()->Metadata;
        $sasarans = Meta::where('name', 'sasaran')->first()->Metadata;
        $kategoris = Meta::where('name', 'kategori')->first()->Metadata;
        return view('kempen.add', ['types' => $types, 'sasarans' => $sasarans, 'kategoris' => $kategoris]);
    }

    public function store(Request $request) {}

    public function edit() {}

    public function update() {}

    public function destroy() {}

}