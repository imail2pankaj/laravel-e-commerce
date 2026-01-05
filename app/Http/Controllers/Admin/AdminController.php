<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminFormRequest;
use App\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use App\Services\Datatable\ActionBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends BaseCrudController
{
   protected string $moduleKey = 'admins';
   protected $adminRepo;
   public function __construct(AdminRepositoryInterface $adminRepo)
   {
      parent::__construct();

      $this->adminRepo = $adminRepo;
   }
   public function show()
   {
      return view('admin.dashboard');
   }

   public function index()
   {
      if (request()->ajax()) {
         $admin = $this->adminRepo->allQuery()->with('roles:id,name');

         return DataTables::eloquent($admin)
            ->addIndexColumn()
            ->addColumn('roles', function ($admin) {
               return $admin->roles->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($user) {
               return ActionBuilder::make($user, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.users.edit', $user->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.users.destroy', $user->id)
                  ]
               ]);
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('admin.admins.admin-list');
   }


   public function create()
   {
      $roles = Role::all();
      return view('admin.admins.admin-form', compact('roles'));
   }


   public function store(AdminFormRequest $request)
   {
      $data = $request->validated();

      // dd($data); 

      $data['password'] = Hash::make($data['password']);

      $roleName = $data['role'];

      unset($data['role']);

      $admin = $this->adminRepo->create($data);

      $admin->assignRole($roleName);

      return redirect()->route('admin.users.index')->with('success', 'New Record add Successfully...!!');
   }

   public function edit($id)
   {
      $admin = $this->adminRepo->find($id);
      $roles = Role::all();
      return view('admin.admins.admin-form', compact('admin', 'roles'));
   }

   public function update(AdminFormRequest $request, $id)
   {
      $data = $request->validated();
      $data['password'] = Hash::make($data['password']);
      $role = $data['role'];
      unset($data['role']);

      $admin = $this->adminRepo->update($id, $data);

      $admin->syncRoles($role);

      return redirect()->route('admin.users.index')->with('success', 'Record Update Successfully...!!');
   }

   public function destroy($id)
   {
      $this->adminRepo->delete($id);
      return redirect()->route('admin.users.index')->with('success', 'Record Delete Successfully...!!');

   }

}
