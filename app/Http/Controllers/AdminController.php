<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class AdminController extends Controller
{
    
    public function index() {
        return view('admin.index');
    }

    public function permission() {
        $data['title'] = 'Permission Management';
        $data['datatable_route'] = route('admin.permission.list');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/',
                'active' => false
            ),
            array(
                'title' => 'Permission Management',
                'url' => '',
                'active' => true
            ),
            array(
                'title' => 'Add New Permission',
                'url' => '',
                'active' => true
            )
        );

        $data['buttons'] = array(
            array(
                'id' => 'addpermission',
                'label' => 'Add Permission',
                'class' => 'btn-primary',
                'icon' => 'fa-plus-circle',
                'modal' => true,
                'link' => route('admin.permission.add')
            )
        );

        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id'
            ),
            array(
                'dt' => 'name',
                'label' => 'Name'
            ),
            array(
                'dt' => 'display_name',
                'label' => 'Display Name'
            ),
            array(
                'dt' => 'description',
                'label' => 'Description'
            )
        );

        $data['actions'] = array(
            array(
                'id' => 'delete',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete selected permission?',
                'route' => url('admin/permission/batch')
            )
        );
        return view('layouts.datatable', $data);
    }

    public function permissionAdd() {
        $data['title'] = 'Add New Permission';
        $data['posturl'] = route('admin.permission.store');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/',
                'active' => false
            ),
            array(
                'title' => 'Permission Management',
                'url' => '',
                'active' => true
            ),
            array(
                'title' => 'Add New Permission',
                'url' => '',
                'active' => true
            )
        );

        $data['form-url'] = '/admin/permission/add';
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'text',
                'name' => 'name',
                'required' => true,
                'placeholder' => 'Please enter name'
            ),
            array(
                'label' => 'Display Name',
                'type' => 'text',
                'name' => 'display_name',
                'required' => true,
                'placeholder' => 'Please enter display name'
            ),
            array(
                'label' => 'Description',
                'type' => 'text',
                'name' => 'description',
                'required' => false,
                'placeholder' => 'Enter description'
            )
        );
        return view('layouts.basic-form', $data);
    }

    public function permissionStore(Request $request) {
        try {
            $data = Permission::where('name', $request['name']);
            if($data->count() > 0) {
                return response()->json(['success' => false, 'message' => 'Permission already exist!!']);
            } else {
                Permission::create($request->all());
                return response()->json(['success' => true, 'message' => 'Permission created']);
            }
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function permissionGet(Request $request) {
        $permissions = DB::table('permissions');

        return DataTables::of($permissions)->make(true);
    }

    public function permissionBatch(Request $request) {
        //
    }

}
