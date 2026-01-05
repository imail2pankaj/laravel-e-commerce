<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerFormRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Services\Datatable\ActionBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends BaseCrudController
{
   protected string $moduleKey = 'customers';
   protected $customerRepo;
   public function __construct(CustomerRepositoryInterface $customerRepo)
   {
      parent::__construct();
      $this->customerRepo = $customerRepo;
   }

   public function index()
   {
      if (request()->ajax()) {

         $customer = $this->customerRepo->allQuery();

         return DataTables::eloquent($customer)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
               return ActionBuilder::make($user, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.customers.edit', $user->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.customers.destroy', $user->id)
                  ]
               ]);
            })
            ->rawColumns(['action'])
            ->make(true);
      }

      return view('admin.customer.customer-list');
   }

   public function getTableData()
   {
      $customer = $this->customerRepo->allQuery();

      return DataTables::eloquent($customer)
         ->addIndexColumn()
         ->addColumn('action', function ($user) {
            return ActionBuilder::make($user, [
               'edit' => [
                  'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                  'url' => route('customer.edit', $user->id)
               ],
               'delete' => [
                  'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                  'url' => route('customer.delete', $user->id)
               ]
            ]);
         })
         ->rawColumns(['action'])
         ->make(true);
   }

   public function create()
   {
      return view('admin.customer.customer-form');
   }

   public function store(CustomerFormRequest $request)
   {
      // dd($request->all());
      $data = $request->validated();

      $data['password'] = Hash::make($data['password']);

      $this->customerRepo->create($data);

      return redirect()->route('admin.customers.index')->with('success', 'New Record add Successfully...!!');
   }
   public function edit($id)
   {
      $customer = $this->customerRepo->find($id);
      return view('admin.customer.customer-form', compact('customer'));
   }


   public function update(CustomerFormRequest $request, $id)
   {
      $data = $request->validated();

      $data['password'] = Hash::make($data['password']);

      $customer = $this->customerRepo->update($id, $data);

      return redirect()->route('admin.customers.index')->with('success', 'Record Update Successfully...!!');
   }

   public function destroy($id)
   {
      $this->customerRepo->delete($id);
      return redirect()->route('admin.customers.index')->with('success', 'Record Delete Successfully...!!');

   }


}
