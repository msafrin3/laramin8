<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Kempen;
use App\Models\KempenVip;
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
                'dt' => 'dm',
                'label' => 'DM'
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
            ),
            array(
                'dt' => 'options',
                'label' => 'Options',
                'class' => 'text-center no-wrap'
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'delete',
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
                return $query->Parlimen();
            })
            ->editColumn('dun', function($query) {
                return $query->Dun();
            })
            ->editColumn('dm', function($query) {
                return $query->Dm();
            })
            ->editColumn('type', function($query) {
                return $query->Type->value;
            })
            ->editColumn('options', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'.route('kempen.edit', $query->id).'">Edit</button>'.'<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'.route('kempen.view', $query->id).'">View</button>';
            })
            ->rawColumns(['options', 'parlimen'])
            ->make(true);
    }

    public function create() {
        $types = Meta::where('name', 'jenis')->first()->Metadata;
        $sasarans = Meta::where('name', 'sasaran')->first()->Metadata;
        $kategoris = Meta::where('name', 'kategori')->first()->Metadata;
        $vips = KempenVip::select('name')->groupBy('name')->orderBy('name')->pluck('name')->toArray();
        $penganjurs = Kempen::select('penganjur')->groupBy('penganjur')->orderBy('penganjur')->pluck('penganjur')->toArray();
        $locations = Kempen::select('location')->groupBy('location')->orderBy('location')->pluck('location')->toArray();
        return view('kempen.add', [
            'types' => $types, 
            'sasarans' => $sasarans, 
            'kategoris' => $kategoris,
            'vips' => $vips,
            'penganjurs' => $penganjurs,
            'locations' => $locations
        ]);
    }

    public function store(Request $request) {
        try {
            $data = $request->except(['_token', 'vips']);
            $data['user_id'] = Auth::user()->id;
            $kempen = Kempen::create($data);

            if($request->has('vips')) {
                $vips = explode(';', $request->input('vips'));
                foreach($vips as $vip) {
                    KempenVip::create([
                        'kempen_id' => $kempen->id,
                        'name' => $vip
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Maklumat kempen berjaya disimpan']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function view(Kempen $kempen) {
        return view('kempen.view', ['kempen' => $kempen]);
    }

    public function edit(Kempen $kempen) {
        $types = Meta::where('name', 'jenis')->first()->Metadata;
        $sasarans = Meta::where('name', 'sasaran')->first()->Metadata;
        $kategoris = Meta::where('name', 'kategori')->first()->Metadata;
        $vips = KempenVip::select('name')->groupBy('name')->orderBy('name')->pluck('name')->toArray();
        $penganjurs = Kempen::select('penganjur')->groupBy('penganjur')->orderBy('penganjur')->pluck('penganjur')->toArray();
        $locations = Kempen::select('location')->groupBy('location')->orderBy('location')->pluck('location')->toArray();
        $_vips = KempenVip::select('name')->where('kempen_id', $kempen->id)->pluck('name')->toArray();
        return view('kempen.edit', [
            'kempen' => $kempen,
            'types' => $types, 
            'sasarans' => $sasarans, 
            'kategoris' => $kategoris,
            'vips' => $vips,
            'penganjurs' => $penganjurs,
            'locations' => $locations,
            '_vips' => $_vips
        ]);
    }

    public function update(Request $request, Kempen $kempen) {
        try {
            $data = $request->except(['_token', 'vips']);
            $data['user_id'] = Auth::user()->id;
            $kempen->update($data);

            if($request->has('vips')) {
                $kempen->Vips()->delete();
                $vips = explode(';', $request->input('vips'));
                foreach($vips as $vip) {
                    KempenVip::create([
                        'kempen_id' => $kempen->id,
                        'name' => $vip
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Maklumat kempen berjaya disimpan.']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function batch(Request $request) {
        try {
            $message = '';
            if($request->input('action') == 'delete') {
                KempenVip::whereIn('kempen_id', $request->input('ids'))->delete();
                Kempen::whereIn('id', $request->input('ids'))->delete();

                $message = 'Maklumat kempen berjaya dipadam';
            }

            return response()->json(['success' => true, 'message' => $message]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}