<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\BrandFormRequest;
use App\Interfaces\BrandRepositoryInterface;
use App\Services\Datatable\ActionBuilder;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends BaseCrudController
{
   protected string $moduleKey = 'brands';
   protected $brandRepo;
   protected $imageService;
   public function __construct(BrandRepositoryInterface $brandRepo, ImageService $imageService)
   {
      parent::__construct();
      $this->brandRepo = $brandRepo;
      $this->imageService = $imageService;
   }

   public function index()
   {
      if (request()->ajax()) {
         $brand = $this->brandRepo->allQuery();

         if ($status = request('status')) {
            $brand->where('status', $status);
         }

         return DataTables::eloquent($brand)
            ->addIndexColumn()
            ->addColumn('status', function ($brand) {
               if ($brand->status === 'published') {
                  $badgeClass = 'bg-success';
               } elseif ($brand->status === 'inactive') {
                  $badgeClass = 'bg-danger';
               } else {
                  $badgeClass = 'bg-secondary'; // draft
               }

               return '<span class="badge ' . $badgeClass . '">'
                  . ucfirst($brand->status) .
                  '</span>';
            })

            ->addColumn('action', function ($val) {
               return ActionBuilder::make($val, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.brands.edit', $val->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.brands.destroy', $val->id)
                  ]
               ]);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
      }
      return view('admin.brand.brand-list');
   }


   // public function getTableData()
   // {
   //    $brand = $this->brandRepo->allQuery();

   //      if ($status= request('status')) {
   //          $brand->where('status', $status);
   //      }

   //    return DataTables::eloquent($brand)
   //       ->addIndexColumn()
   //      ->addColumn('status', function ($brand) {
   //          if ($brand->status === 'published') {
   //             $badgeClass = 'bg-success';
   //          } elseif ($brand->status === 'inactive') {
   //             $badgeClass = 'bg-danger';
   //          } else {
   //             $badgeClass = 'bg-secondary'; // draft
   //          }

   //          return '<span class="badge ' . $badgeClass . '">'
   //                . ucfirst($brand->status) .
   //                '</span>';
   //       })

   //       ->addColumn('action', function ($val) {
   //             return ActionBuilder::make($val, [
   //                'edit' => [
   //                   'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
   //                   'url' => route('admin.brands.edit', $val->id)
   //                ],
   //                'delete' => [
   //                   'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
   //                   'url' => route('admin.brands.destroy', $val->id)
   //                ]
   //             ]);
   //       })
   //       ->rawColumns([ 'status','action'])
   //       ->make(true);
   // }
   public function create()
   {
      return view('admin.brand.brand-form');
   }


   public function store(BrandFormRequest $request)
   {
      $data = $request->validated();

      if ($request->hasFile('logo')) {
         $data['logo'] = $this->imageService->upload(
            $request->file('logo'),
            'brand',
            $data['slug']
         );
      }

      $this->brandRepo->create($data);

      return redirect()
         ->route('admin.brands.index')
         ->with('success', 'New Record added successfully!');
   }


   public function edit($id)
   {
      $brand = $this->brandRepo->find($id);
      return view('admin.brand.brand-form', compact('brand'));
   }

   public function update(BrandFormRequest $request, $id)
   {
      $brand = $this->brandRepo->find($id);
      $data = $request->validated();


      if ($request->hasFile('logo')) {

         // delete old image
         $this->imageService->delete($brand->logo);

         // upload new image
         $data['logo'] = $this->imageService->upload(
            $request->file('logo'),
            'brand',
            $data['slug']
         );
      }

      $this->brandRepo->update($id, $data);

      return redirect()
         ->route('admin.brands.index')
         ->with('success', 'Record updated successfully!');
   }



   public function destroy($id)
   {
      $brand = $this->brandRepo->find($id);

      if (!empty($brand->logo)) {
         $this->imageService->delete($brand->logo);
      }

      $this->brandRepo->delete($id);
      return redirect()->route('admin.brands.index')->with('success', 'Record Delete Successfully...!!');

   }
}
