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
                'id' => 'delete',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete selected role',
                'route' => route('admin.role.batch')
            )
        );
        $data['batch_route'] = route('admin.role.batch');
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

    public function roleBatch(Request $request) {
        try {
            $message = '';
            if($request['action'] == 'delete') {
                // delete roles attached to user
                DB::table('role_user')->whereIn('role_id', $request['ids'])->delete();
                // delete roles attached to permission
                DB::table('permission_role')->whereIn('role_id', $request['ids'])->delete();
                // delete role
                Role::whereIn('id', $request['ids'])->delete();
                $message = 'Role successfully deleted';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
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
        $data['batch_route'] = route('admin.meta.batch');
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
                'id' => 'delete',
                'label' => 'Delete',
                'message' => 'Are you sure want to delete this Meta',
                'route' => route('admin.meta.batch')
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

    public function metaBatch(Request $request) {
        try {
            $message = '';
            if($request['action'] == 'delete') {
                Metadata::whereIn('meta_id', $request['ids'])->delete();
                Meta::whereIn('id', $request['ids'])->delete();
                $message = 'Meta Successfully deleted!';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function metadata() {
        $data['title'] = 'Meta Data Management';
        $data['datatable_route'] = route('admin.metadata.list');
        $data['batch_route'] = route('admin.metadata.batch');
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
                'id' => 'delete',
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

    public function metadataBatch(Request $request) {
        try {
            $message = '';
            if($request['action'] == 'delete') {
                Metadata::whereIn('id', $request['ids'])->delete();
                $message = 'Meta Data successfully deleted!';
            }

            return response()->json(['success' => true, 'message' => $message]);
        } catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}