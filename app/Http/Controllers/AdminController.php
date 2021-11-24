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
        $data['batch_route'] = route('admin.permission.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => 'admin',
                'active' => false
            ),
            array(
                'title' => 'Permission Management',
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

        $name_list = Permission::select('id', 'name')->get()->toArray();
        array_unshift($name_list, ['id' => '', 'name' => 'Select Name']);

        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id'
            ),
            array(
                'dt' => 'name',
                'label' => 'Name',
                'filter' => array(
                    'value' => $name_list
                )
            ),
            array(
                'dt' => 'display_name',
                'label' => 'Display Name'
            ),
            array(
                'dt' => 'description',
                'label' => 'Description'
            ),
            array(
                'dt' => 'action',
                'label' => 'Action',
                'searchable' => false,
                'orderable' => false,
                'class' => 'text-center'
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
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'required' => 'requierd',
                    'placeholder' => 'Please enter name',
                    'class' => 'form-control'
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'required' => true,
                    'placeholder' => 'Please enter display name',
                    'class' => 'form-control'
                )
            ),
            array(
                'label' => 'Description',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'description',
                    'required' => false,
                    'placeholder' => 'Enter description',
                    'class' => 'form-control'
                )
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

        if($request['name']) {
            $permissions->where('id', $request['name']);
        }

        return DataTables::of($permissions)
            ->filterColumn('name', function($query, $keyword) {
                $query->where('permissions.name', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('display_name', function($query, $keyword) {
                $query->where('permissions.display_name', 'like', '%'.$keyword.'%');
            })
            ->filterColumn('description', function($query, $keyword) {
                $query->where('permissions.description', 'like', '%'.$keyword.'%');
            })
            ->editColumn('action', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'.route('admin.permission.edit', $query->id).'">Edit</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function permissionBatch(Request $request) {
        try {
            $message = '';
            if($request['action'] == 'delete') {
                // delete from permission_role
                DB::table('permission_role')->whereIn('permission_id', $request['ids'])->delete();
                DB::table('permission_user')->whereIn('permission_id', $request['ids'])->delete();
                Permission::whereIn('id', $request['ids'])->delete();
                $message = 'Permission(s) successfull deleted!';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function permissionEdit(Permission $permission) {
        $data['title'] = 'Edit Permission';
        $data['posturl'] = route('admin.permission.update', $permission->id);
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'required' => 'requierd',
                    'placeholder' => 'Please enter name',
                    'value' => $permission->name,
                    'class' => 'form-control'
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'required' => true,
                    'placeholder' => 'Please enter display name',
                    'value' => $permission->display_name,
                    'class' => 'form-control'
                )
            ),
            array(
                'label' => 'Description',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'description',
                    'required' => false,
                    'placeholder' => 'Enter description',
                    'value' => $permission->description,
                    'class' => 'form-control'
                )
            )
        );

        return view('layouts.basic-form', $data);
    }

    public function permissionUpdate(Request $request, Permission $permission) {
        try {
            $permission->update($request->all());
            return response()->json(['success' => true, 'message' => 'Permission successfully updated!']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function role() {
        $data['title'] = 'Role Management';
        $data['datatable_route'] = route('admin.role.list');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => 'admin',
                'active' => false
            ),
            array(
                'title' => 'Role Management',
                'url' => '',
                'active' => true
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
            ),
            array(
                'dt' => 'permissions',
                'label' => 'Permissions',
                'searchable' => false,
                'orderable' => false
            )
        );
        $data['actions'] = [];
        $data['batch_route'] = route('admin.role.batch');

        return view('layouts.datatable', $data);
    }

    public function roleGet(Request $request) {
        $roles = DB::table('roles');

        return DataTables::of($roles)
            ->make(true);
    }

    public function roleBatch(Request $request) {
        //
    }

}
