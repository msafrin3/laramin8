<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Meta;
use App\Models\Metadata;
use App\Models\Logs;

class AdminController extends Controller
{
    
    public function index() {
        return view('admin.index');
    }

    public function permission() {
        $data['title'] = 'Permission Management';
        $data['datatable_route'] = route('admin.permission.list');
        $data['batch_route'] = route('admin.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/admin',
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
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
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
                'id' => 'deletepermission',
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
                'url' => '/admin',
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
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
            ),
            array(
                'dt' => 'actions',
                'label' => 'Actions',
                'searchable' => false,
                'orderable' => false,
                'class' => 'text-center'
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'deleterole',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete selected role'
            )
        );
        $data['batch_route'] = route('admin.batch');
        $data['buttons'] = array(
            array(
                'id' => 'addrole',
                'label' => 'Add Role',
                'class' => 'btn-primary',
                'icon' => 'fa-plus-circle',
                'modal' => true,
                'link' => route('admin.role.add')
            )
        );

        return view('layouts.datatable', $data);
    }

    public function roleGet(Request $request) {
        $roles = DB::table('roles');

        return DataTables::of($roles)
            ->editColumn('permissions', function($query) {
                $role = Role::find($query->id);
                $html = '';
                foreach($role->permissions as $permission) {
                    $html .= '<span class="badge badge-tertiary rounded-pill py-1 px-2 me-1 text-uppercase">'. $permission->display_name .'</span>';
                }
                return $html;
            })
            ->editColumn('actions', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'. route('admin.role.edit', $query->id) .'">Edit</button>';
            })
            ->rawColumns(['permissions', 'actions'])
            ->make(true);
    }

    public function roleAdd() {
        $data['title'] = 'Add Role';
        $data['posturl'] = route('admin.role.store');

        $permission_list = Permission::all()->toArray();

        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Name',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter display name',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Description',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'description',
                    'class' => 'form-control',
                    'placeholder' => 'Enter role description',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Permissions',
                'type' => 'checkbox',
                'name' => 'permissions',
                'options' => $permission_list
            )
        );
        return view('layouts.basic-form', $data);
    }

    public function roleStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:roles'
            ]);

            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            
            $data = $request->except(['permissions']);

            $role = Role::create($data);
            $role->attachPermissions($request->input('permissions'));

            return response()->json(['success' => true, 'message' => 'Role Created']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function roleEdit(Role $role) {
        $data['title'] = 'Edit Role';
        $data['posturl'] = route('admin.role.update', $role->id);
        $permission_list = DB::table('permissions')->select([
            'permissions.*',
            DB::raw("if(permission_role.permission_id is not null, 1, null) as is_checked")
        ])
        ->leftJoin('permission_role', function($join) use ($role) {
            $join->on('permissions.id', 'permission_role.permission_id');
            $join->on('permission_role.role_id', DB::raw($role->id));
        })->get();
        
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Name',
                    'required' => 'required',
                    'value' => $role->name
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter display name',
                    'required' => 'required',
                    'value' => $role->display_name
                )
            ),
            array(
                'label' => 'Description',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'description',
                    'class' => 'form-control',
                    'placeholder' => 'Enter role description',
                    'required' => 'required',
                    'value' => $role->description
                )
            ),
            array(
                'label' => 'Permissions',
                'type' => 'checkbox',
                'name' => 'permissions',
                'options' => json_decode(json_encode($permission_list), true)
            )
        );
        
        return view('layouts.basic-form', $data);
    }

    public function meta() {
        $data['title'] = 'Meta Management';
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/admin',
                'active' => false
            ),
            array(
                'title' => 'Meta Management',
                'url' => '',
                'active' => true
            )
        );
        $data['datatable_route'] = route('admin.meta.list');
        $data['batch_route'] = route('admin.batch');
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
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
            ),
            array(
                'dt' => 'actions',
                'label' => 'Actions',
                'searchable' => false,
                'orderable' => false,
                'class' => 'text-center'
            )
        );
        $data['buttons'] = array(
            array(
                'id' => 'addmeta',
                'label' => 'Add new Meta',
                'icon' => 'fa-plus-circle',
                'class' => 'btn-primary',
                'modal' => true,
                'link' => route('admin.meta.add')
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'deletemeta',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete this Meta'
            )
        );

        return view('layouts.datatable', $data);
    }

    public function metaGet(Request $request) {
        $metas = DB::table('meta');

        return DataTables::of($metas)
            ->editColumn('actions', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'. route('admin.meta.edit', $query->id) .'">Edit</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function metaAdd() {
        $data['title'] = 'Add New Meta';
        $data['posturl'] = route('admin.meta.store');
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter name',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter display name',
                    'required' => 'required'
                )
            )
        );
        return view('layouts.basic-form', $data);
    }

    public function metaStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:meta'
            ]);
            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $data = $request->except(['_token']);
            Meta::create($data);
            return response()->json(['success' => true, 'message' => 'Meta successfully created.']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function metaEdit(Meta $meta) {
        $data['title'] = 'Edit Meta';
        $data['posturl'] = route('admin.meta.update', $meta->id);
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter name',
                    'required' => 'required',
                    'value' => $meta->name
                )
            ),
            array(
                'label' => 'Display Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'display_name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter display name',
                    'required' => 'required',
                    'value' => $meta->display_name
                )
            )
        );
        return view('layouts.basic-form', $data);
    }

    public function metaUpdate(Meta $meta, Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:meta,name,'.$meta->id
            ]);
            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $meta->update($request->all());

            return response()->json(['success' => true, 'message' => 'Meta Successfully updated!']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function metadata() {
        $data['title'] = 'Meta Data Management';
        $data['datatable_route'] = route('admin.metadata.list');
        $data['batch_route'] = route('admin.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/admin',
                'active' => false
            ),
            array(
                'title' => 'Meta Management',
                'url' => '/admin/meta',
                'active' => false
            ),
            array(
                'title' => 'Meta Data Management',
                'url' => '/admin/metadata',
                'active' => true
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'deletemetadata',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete selected Meta Data?'
            )
        );
        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id'
            ),
            array(
                'dt' => 'meta_name',
                'label' => 'Meta'
            ),
            array(
                'dt' => 'value',
                'label' => 'Value'
            ),
            array(
                'dt' => 'group_helper',
                'label' => 'Group Helper'
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
            ),
            array(
                'dt' => 'actions',
                'label' => 'Actions',
                'searchable' => false,
                'orderable' => false,
                'class' => 'text-center'
            )
        );
        
        $data['buttons'] = array(
            array(
                'id' => 'addmetadata',
                'label' => 'Add Meta Data',
                'class' => 'btn-primary',
                'icon' => 'fa-plus-circle',
                'modal' => true,
                'link' => route('admin.metadata.add')
            )
        );
        return view('layouts.datatable', $data);
    }

    public function metadataGet(Request $request) {
        $model = DB::table('meta_data')->select([
            'meta_data.*',
            'meta.name as meta_name'
        ])
        ->leftJoin('meta', 'meta_data.meta_id', 'meta.id');

        return DataTables::of($model)
            ->editColumn('actions', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'. route('admin.metadata.edit', $query->id) .'">Edit</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function metadataAdd() {
        $data['title'] = 'Add new Meta Data';
        $data['posturl'] = route('admin.metadata.store');
        $meta_list = Meta::all()->toArray();
        array_unshift($meta_list, array('id' => '', 'name' => 'Select Meta'));
        $data['forms'] = array(
            array(
                'label' => 'Select Meta',
                'type' => 'dropdown',
                'attributes' => array(
                    'name' => 'meta_id',
                    'class' => 'form-control',
                    'required' => 'required'
                ),
                'options' => $meta_list
            ),
            array(
                'label' => 'Value',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'value',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Value',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Group Helper',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'group_helper',
                    'class' => 'form-control',
                    'placeholder' => 'Enter group helper'
                )
            )
        );

        return view('layouts.basic-form', $data);
    }

    public function metadataStore(Request $request) {
        try {
            Metadata::create($request->all());
            return response()->json(['success' => true, 'message' => 'Meta Data Successfully created!']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function metadataEdit(Metadata $metadata) {
        $data['title'] = 'Edit Meta Data';
        $data['posturl'] = route('admin.metadata.update', $metadata->id);
        // $meta_list = Meta::all()->toArray();
        // array_unshift($meta_list, array('id' => '', 'name' => 'Select Meta'));
        $meta_list = DB::table('meta')->select([
            'meta.*',
            DB::raw("if(meta_data.id is not null, 1, 0) as is_checked")
        ])
        ->leftJoin('meta_data', function($join) use ($metadata) {
            $join->on('meta.id', 'meta_data.meta_id');
            $join->on('meta_data.id', DB::raw($metadata->id));
        })
        ->get();
        $meta_list = json_decode(json_encode($meta_list), true);
        array_unshift($meta_list, array('id' => '', 'name' => 'Select Meta'));
        
        $data['forms'] = array(
            array(
                'label' => 'Select Meta',
                'type' => 'dropdown',
                'attributes' => array(
                    'name' => 'meta_id',
                    'class' => 'form-control',
                    'required' => 'required'
                ),
                'options' => $meta_list
            ),
            array(
                'label' => 'Value',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'value',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Value',
                    'required' => 'required',
                    'value' => $metadata->value
                )
            ),
            array(
                'label' => 'Group Helper',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'group_helper',
                    'class' => 'form-control',
                    'placeholder' => 'Enter group helper',
                    'value' => $metadata->group_helper
                )
            )
        );

        return view('layouts.basic-form', $data);
    }

    public function metadataUpdate(Metadata $metadata, Request $request) {
        try {
            $metadata->update($request->all());
            return response()->json(['success' => true, 'message' => 'Meta Data successfully updated.']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function user() {
        $data['title'] = 'User Management';
        $data['datatable_route'] = route('admin.user.list');
        $data['batch_route'] = route('admin.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/admin',
                'active' => false
            ),
            array(
                'title' => 'User Management',
                'url' => '',
                'active' => true
            )
        );
        $data['buttons'] = array(
            array(
                'id' => 'adduser',
                'label' => 'Add User',
                'icon' => 'fa-user-plus',
                'link' => route('admin.user.add'),
                'class' => 'btn-primary',
                'modal' => true
            )
        );
        $data['actions'] = array(
            array(
                'id' => 'deleteuser',
                'label' => 'Delete User',
                'message' => 'Are you sure want to delete selected user?'
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
                'dt' => 'email',
                'label' => 'Email'
            ),
            array(
                'dt' => 'roles',
                'label' => 'Roles',
                'searchable' => false,
                'orderable' => false
            ),
            array(
                'dt' => 'permissions',
                'label' => 'Permissions',
                'searchable' => false,
                'orderable' => false
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
            ),
            array(
                'dt' => 'actions',
                'label' => 'Actions',
                'class' => 'text-center'
            )
        );

        return view('layouts.datatable', $data);
    }

    public function userGet(Request $request) {
        $users = DB::table('users')->get();
        return DataTables::of($users)
            ->editColumn('roles', function($query) {
                $roles = '';
                $user = User::find($query->id);
                foreach($user->roles as $role) {
                    $roles .= '<span class="badge badge-tertiary rounded-pill py-1 px-2 me-1 text-uppercase">'. $role->display_name .'</span>';
                }
                return $roles;
            })
            ->editColumn('permissions', function($query) {
                $permissions = '';
                $user = User::find($query->id);
                foreach($user->permissions as $permission) {
                    $permissions .= '<span class="badge badge-tertiary rounded-pill py-1 px-2 me-1 text-uppercase">'. $permission->display_name .'</span>';
                }
                return $permissions;
            })
            ->editColumn('actions', function($query) {
                return '<button type="button" class="btn btn-quaternary btn-sm displayModal" data-modal_url="'. route('admin.user.edit', $query->id) .'">Edit</button>';
            })
            ->rawColumns(['roles', 'permissions', 'actions'])
            ->make(true);
    }

    public function userAdd() {
        $data['title'] = 'Add New User';
        $data['posturl'] = route('admin.user.store');
        $roles_list = Role::select(['id', DB::raw('display_name as name')])->get();
        $permissions_list = Permission::select(['id', DB::raw('display_name as name')])->get();
        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Name',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Email',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'email',
                    'name' => 'email',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Email',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Password',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'password',
                    'name' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Password',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Password Confirmation',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'password',
                    'name' => 'password_confirmation',
                    'class' => 'form-control',
                    'placeholder' => 'Re-type Password',
                    'required' => 'required'
                )
            ),
            array(
                'label' => 'Roles',
                'type' => 'checkbox',
                'name' => 'roles',
                'options' => $roles_list
            ),
            array(
                'label' => 'Permissions',
                'type' => 'checkbox',
                'name' => 'permissions',
                'options' => $permissions_list
            )
        );

        return view('layouts.basic-form', $data);
    }

    public function userStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|unique:users',
                'password' => 'required|string|min:6|confirmed'
            ]);

            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $data = $request->except(['roles', 'permissions']);
            $data['password'] = bcrypt($request->input('password'));
            $user = User::create($data);

            if($request->has('roles')) {
                $user->attachRoles($request->input('roles'));
                $user->syncRoles($request->input('roles'));
            }
            if($request->has('permissions')) {
                $user->attachPermissions($request->input('permissions'));
                $user->syncPermissions($request->input('permissions'));
            }

            return response()->json(['success' => true, 'message' => 'User successfully created!']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function userEdit(User $user, Request $request) {
        $data['title'] = 'Edit User';
        $data['posturl'] = route('admin.user.update', $user->id);

        $roles_list = DB::table('roles')->select([
            'roles.id',
            'roles.display_name as name',
            DB::raw('if(role_user.user_id is not null, 1, 0) as is_checked')
        ])
        ->leftJoin('role_user', function($join) use ($user) {
            $join->on('role_user.role_id', 'roles.id');
            $join->on('role_user.user_id', DB::raw($user->id));
        })
        ->get();

        $permissions_list = DB::table('permissions')->select([
            'permissions.id',
            'permissions.display_name as name',
            DB::raw('if(permission_user.user_id is not null, 1, 0) as is_checked')
        ])
        ->leftJoin('permission_user', function($join) use ($user) {
            $join->on('permission_user.permission_id', 'permissions.id');
            $join->on('permission_user.user_id', DB::raw($user->id));
        })
        ->get();

        $data['forms'] = array(
            array(
                'label' => 'Name',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'text',
                    'name' => 'name',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Name',
                    'required' => 'required',
                    'value' => $user->name
                )
            ),
            array(
                'label' => 'Email',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'email',
                    'name' => 'email',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Email',
                    'required' => 'required',
                    'value' => $user->email
                )
            ),
            array(
                'label' => 'Password',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'password',
                    'name' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Enter Password'
                )
            ),
            array(
                'label' => 'Password Confirmation',
                'type' => 'input',
                'attributes' => array(
                    'type' => 'password',
                    'name' => 'password_confirmation',
                    'class' => 'form-control',
                    'placeholder' => 'Re-type Password'
                )
            ),
            array(
                'label' => 'Roles',
                'type' => 'checkbox',
                'name' => 'roles',
                'options' => json_decode(json_encode($roles_list), true)
            ),
            array(
                'label' => 'Permissions',
                'type' => 'checkbox',
                'name' => 'permissions',
                'options' => json_decode(json_encode($permissions_list), true)
            )
        );
        return view('layouts.basic-form', $data);
    }

    public function userUpdate(User $user, Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|unique:users,email,'.$user->id,
                'password' => 'confirmed'
            ]);

            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            $data = $request->except(['roles', 'permissions']);
            if($request->has('password') && $request->input('password') != null) {
                $data['password'] = bcrypt($request->input('password'));
            } else {
                unset($data['password']);
                unset($data['password_confirmation']);
            }

            $user->update($data);

            if($request->has('roles')) {
                $user->syncRoles($request->input('roles'));
            }
            if($request->has('permissions')) {
                $user->syncPermissions($request->input('permissions'));
            }

            return response()->json(['success' => true, 'message' => 'User successfully updated.']);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function batch(Request $request) {
        try {
            $message = '';
            if($request->input('action') == 'deleteuser') {
                // delete from table role_user
                DB::table('role_user')->whereIn('user_id', $request->input('ids'))->delete();
                // delete from table permission_user
                DB::table('permission_user')->whereIn('user_id', $request->input('ids'))->delete();
                // delete user
                User::whereIn('id', $request->input('ids'))->delete();
                
                $message = 'User successfully deleted';
            } elseif($request->input('action') == 'deletemetadata') {
                Metadata::whereIn('id', $request['ids'])->delete();
                $message = 'Meta Data successfully deleted!';
            } elseif($request->input('action') == 'deletemeta') {
                Metadata::whereIn('meta_id', $request['ids'])->delete();
                Meta::whereIn('id', $request['ids'])->delete();
                $message = 'Meta Successfully deleted!';
            } elseif($request->input('action') == 'deleterole') {
                // delete roles attached to user
                DB::table('role_user')->whereIn('role_id', $request['ids'])->delete();
                // delete roles attached to permission
                DB::table('permission_role')->whereIn('role_id', $request['ids'])->delete();
                // delete role
                Role::whereIn('id', $request['ids'])->delete();
                $message = 'Role successfully deleted';
            } elseif($request->input('action') == 'deletepermission') {
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

    public function log() {
        $data['title'] = 'System Activity Log';
        $data['datatable_route'] = route('admin.log.list');
        $data['batch_route'] = route('admin.batch');
        $data['breadcrumb'] = array(
            array(
                'title' => 'Home',
                'url' => '/admin',
                'active' => false
            ),
            array(
                'title' => 'System Activity',
                'url' => '',
                'active' => true
            )
        );
        $user_list = User::all()->toArray();
        array_unshift($user_list, array('id' => '', 'name' => 'All User'));
        $data['columns'] = array(
            array(
                'dt' => 'id',
                'label' => 'id',
                'visible' => false
            ),
            array(
                'dt' => 'user_name',
                'label' => 'User',
                'filter' => array(
                    'value' => $user_list
                )
            ),
            array(
                'dt' => 'url',
                'label' => 'URL'
            ),
            array(
                'dt' => 'method',
                'label' => 'Method'
            ),
            array(
                'dt' => 'params',
                'label' => 'Parameters',
                'class' => 'text-center'
            ),
            array(
                'dt' => 'ip_address',
                'label' => 'IP Address'
            ),
            array(
                'dt' => 'user_agent',
                'label' => 'User Agent'
            ),
            array(
                'dt' => 'created_at',
                'label' => 'Created At'
            ),
            array(
                'dt' => 'updated_at',
                'label' => 'Updated At'
            )
        );
        $data['order'] = 7;
        $data['sort_order'] = 'Desc';
        $data['no_select'] = true;

        return view('layouts.datatable', $data);
    }

    public function logGet(Request $request) {
        $logs = DB::table('logs')->select([
            'logs.*',
            'users.name as user_name'
        ])
        ->leftJoin('users', 'logs.user_id', 'users.id');

        if($request['user_name']) {
            $logs->where('logs.user_id', $request['user_name']);
        }

        return DataTables::of($logs)
            ->editColumn('params', function($query) {
                return '<a class="displayModal" data-modal_url="'. route('admin.log.param', $query->id) .'">Parameters</a>';
            })
            ->rawColumns(['params'])
            ->make(true);
    }

    public function logParam(Logs $log) {
        return view('admin.logs-paramter', ['log' => $log]);
    }

    public function analysis() {
        return view('admin.analysis');
    }

    public function analysisGet(Request $request) {
        $logs = DB::table('logs')->select([
            'logs.*', 
            DB::raw("if(logs.user_id is null, 'Guest User', users.name) as user_name"),
            DB::raw("date(logs.created_at) as date")
        ])
        ->leftJoin('users', 'logs.user_id', 'users.id');

        $data['todays_visitor'] = clone $logs;
        $data['todays_visitor'] = $data['todays_visitor']->where(DB::raw("date(logs.created_at)"), date('Y-m-d'))->groupBy('logs.user_id')->groupBy('logs.ip_address')->get()->count();

        $data['todays_login'] = clone $logs;
        $data['todays_login'] = $data['todays_login']->where('logs.is_login', 1)->where(DB::raw("date(logs.created_at)"), date('Y-m-d'))->count();

        $data['last_30days'] = clone $logs;
        $data['last_30days'] = $data['last_30days']->where('logs.is_login', 1)->where('logs.created_at', '>', DB::raw("now() - interval 30 day"))->count();

        $data['total_user'] = User::count();

        $data['last_30days_data'] = clone $logs;
        $data['last_30days_data'] = $data['last_30days_data']->where('logs.is_login', 1)->where('logs.created_at', '>', DB::raw("now() - interval 30 day"))->orderBy(DB::raw("date(logs.created_at)"), 'desc')->get();

        $data['current_active'] = DB::table('sessions')->select([
            'sessions.*',
            'users.name as user_name',
            DB::raw("FROM_UNIXTIME(sessions.last_activity) as last_activity_date")
        ])
        ->leftJoin('users', 'sessions.user_id', 'users.id')
        ->get();

        $data['most_active_user'] = DB::table('logs')->select([
            'logs.*', 
            DB::raw("if(logs.user_id is null, 'Guest User', users.name) as user_name"),
            DB::raw("date(logs.created_at) as date"),
            DB::raw("count(*) as total")
        ])
        ->leftJoin('users', 'logs.user_id', 'users.id')
        ->groupBy('logs.user_id')
        ->orderBy('total', 'desc')
        ->get();

        $data['daily_login'] = DB::table('logs')->select([
            'logs.*', 
            DB::raw("date(logs.created_at) as date"),
            DB::raw("count(*) as total")
        ])
        ->leftJoin('users', 'logs.user_id', 'users.id')
        ->where('logs.is_login', 1)
        ->groupBy(DB::raw("date(logs.created_at)"))
        ->orderBy(DB::raw("date(logs.created_at)"), 'desc')
        ->get();
        
        return response()->json($data);
    }

}