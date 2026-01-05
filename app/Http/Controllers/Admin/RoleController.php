<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleFormRequest;
use App\Interfaces\RoleRepositoryInterface;
use App\Services\Datatable\ActionBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
   protected $roleRepo;
   public function __construct(RoleRepositoryInterface $roleRepo)
   {
      $this->roleRepo = $roleRepo;
   }

   public function index()
   {
      if (request()->ajax()) {
         $role = $this->roleRepo->allQuery();

         return DataTables::eloquent($role)
            ->addIndexColumn()

            ->addColumn('action', function ($val) {
               return ActionBuilder::make($val, [
                  'edit' => [
                     // 'can' => auth()->user()->hasPermissionTo('users.edit'),
                     'url' => route('admin.roles.edit', $val->id)
                  ],
                  'delete' => [
                     // 'can' => auth()->user()->hasPermissionTo('users.delete'),
                     'url' => route('admin.roles.destroy', $val->id)
                  ]
               ]);
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('admin.role.role-list');
   }


   public function create()
   {
      return view('admin.role.role-form');
   }


   public function store(RoleFormRequest $requst)
   {
      $data = $requst->validated();

      $data['guard_name'] = 'admin';
      $this->roleRepo->create($data);

      return redirect()->route('admin.roles.index')->with('success', 'New Record add Successfully...!!');
   }

   public function edit($id)
   {
      $role = $this->roleRepo->find($id);
      return view('admin.role.role-form', compact('role'));
   }

   public function update(RoleFormRequest $requst, $id)
   {
      $data = $requst->validated();
      $this->roleRepo->update($id, $data);
      return redirect()->route('admin.roles.index')->with('success', 'Record Update Successfully...!!');
   }

   public function destroy($id)
   {
      $this->roleRepo->delete($id);
      return redirect()->route('admin.roles.index')->with('success', 'Record Delete Successfully...!!');

   }
}
