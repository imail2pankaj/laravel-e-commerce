<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Services\Datatable\ActionBuilder;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class CategoryController extends BaseCrudController
{
   protected string $moduleKey = 'categories';
   protected $categoryRepo;
   protected $imageService;
   public function __construct(CategoryRepositoryInterface $categoryRepo, ImageService $imageService)
   {
      parent::__construct();
      $this->categoryRepo = $categoryRepo;
      $this->imageService = $imageService;
   }

   public function index()
   {
      if (request()->ajax()) {
         $category = $this->categoryRepo->allQuery();


         if ($status = request('status')) {
            $category->where('status', $status);
         }


         return DataTables::eloquent($category)
            ->addIndexColumn()
            ->addColumn('status', function ($category) {
               if ($category->status === 'published') {
                  $badgeClass = 'bg-success';
               } elseif ($category->status === 'inactive') {
                  $badgeClass = 'bg-danger';
               } else {
                  $badgeClass = 'bg-secondary'; // draft
               }

               return '<span class="badge ' . $badgeClass . '">'
                  . ucfirst($category->status) .
                  '</span>';
            })

            ->addColumn('action', function ($val) {
               return ActionBuilder::make($val, [
                  'edit' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.edit'),
                     'url' => route('admin.categories.edit', $val->id)
                  ],
                  'delete' => [
                     'can' => auth()->user()->hasPermissionTo($this->moduleKey . '.delete'),
                     'url' => route('admin.categories.destroy', $val->id)
                  ]
               ]);
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
      }
      return view('admin.category.category-list');
   }



   public function create()
   {
      return view('admin.category.category-form');
   }


   public function store(CategoryFormRequest $request)
   {
      $data = $request->validated();
      //   dd($data);

      if ($request->hasFile('image')) {
         $data['image'] = $this->imageService->upload(
            $request->file('image'),
            'category',
            $data['slug']
         );
      }

      $this->categoryRepo->create($data);

      return redirect()
         ->route('admin.categories.index')
         ->with('success', 'New Record added successfully!');
   }


   public function edit($id)
   {
      $category = $this->categoryRepo->find($id);
      return view('admin.category.category-form', compact('category'));
   }

   public function update(CategoryFormRequest $request, $id)
   {
      $category = $this->categoryRepo->find($id);
      $data = $request->validated();


      if ($request->hasFile('image')) {

         // delete old image
         $this->imageService->delete($category->image);

         // upload new image
         $data['image'] = $this->imageService->upload(
            $request->file('image'),
            'category',
            $data['slug']
         );
      }

      $this->categoryRepo->update($id, $data);

      return redirect()
         ->route('admin.categories.index')
         ->with('success', 'Record updated successfully!');
   }



   public function destroy($id)
   {
      $category = $this->categoryRepo->find($id);

      if (!empty($category->image)) {
         $this->imageService->delete($category->image);
      }

      $this->categoryRepo->delete($id);
      return redirect()->route('admin.categories.index')->with('success', 'Record Delete Successfully...!!');

   }
}
