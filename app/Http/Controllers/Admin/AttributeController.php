<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeFormRequest;
use App\Interfaces\AttributeRepositoryInterface;
use App\Services\Datatable\ActionBuilder;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends BaseCrudController
{
   protected string $moduleKey = 'attributes';
   protected $attributeRepo;
   protected $imageService;
   public function __construct(AttributeRepositoryInterface $attributeRepo, ImageService $imageService)
   {
      parent::__construct();
      $this->attributeRepo = $attributeRepo;
      $this->imageService = $imageService;
   }

   public function index()
   {
      if (request()->ajax()) {
         $attribute = $this->attributeRepo->allQuery();

         return DataTables::eloquent($attribute)
            ->addIndexColumn()
            ->addColumn('action', function ($val) {
               return ActionBuilder::make($val, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.attributes.edit', $val->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.attributes.destroy', $val->id)
                  ]
               ]);
            })
            ->rawColumns(['action',])
            ->make(true);
      }
      return view('admin.attribute.attribute-list');
   }

   public function create()
   {
      return view('admin.attribute.attribute-form');
   }


   public function store(AttributeFormRequest $request)
   {
      $data = $request->validated();

      $this->attributeRepo->create($data);

      return redirect()
         ->route('admin.attributes.index')
         ->with('success', 'New Record added successfully!');
   }


   public function edit($id)
   {
      $attribute = $this->attributeRepo->find($id);
      return view('admin.attribute.attribute-form', compact('attribute'));
   }

   public function update(AttributeFormRequest $request, $id)
   {
      $attribute = $this->attributeRepo->find($id);
      $data = $request->validated();

      $this->attributeRepo->update($id, $data);

      return redirect()
         ->route('admin.attributes.index')
         ->with('success', 'Record updated successfully!');
   }



   public function destroy($id)
   {
      $this->attributeRepo->delete($id);
      return redirect()->route('admin.attributes.index')->with('success', 'Record Delete Successfully...!!');

   }
}
