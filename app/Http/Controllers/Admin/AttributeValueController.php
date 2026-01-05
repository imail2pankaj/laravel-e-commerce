<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseCrudController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AttributeValueFormRequest;
use App\Http\Requests\AttributeValueUpdateRequest;
use App\Interfaces\AttributeValueRepositoryInterface;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Services\Datatable\ActionBuilder;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Yajra\DataTables\Facades\DataTables;

class AttributeValueController extends BaseCrudController
{
    protected string $moduleKey = 'attributes';   
    protected $attributeRepo;

   public function __construct(AttributeValueRepositoryInterface $attributeRepo)
   {
      parent::__construct(); 
      $this->attributeRepo=$attributeRepo;

      $this->middleware("permission:{$this->moduleKey}.edit")->only('updateSortOrder');

   }

 
    public function index()
    {
        $attributes = $this->attributeRepo->getActiveAttributesWithValues();

        return view(
            'admin.attribute.attributeValue.attributeValue-list',
            compact('attributes')
        );
    }

    public function create()
    {
        $attributes = $this->attributeRepo->getActiveAttributes();

        return view(
            'admin.attribute.attributeValue.attributeValue-form',
            compact('attributes')
        );
    }


    public function bulkStore(AttributeValueFormRequest $request)
    {
        $attributeId = $request->attribute_id;

        // ✅ Decode Tagify JSON
        $rawValues = json_decode($request->values, true);

        // Fallback (if Tagify disabled or JS off)
        if (!is_array($rawValues)) {
            $rawValues = preg_split("/\r\n|\n|\r/", $request->values);
            $rawValues = collect($rawValues)->map(fn ($v) => ['value' => $v])->toArray();
        }

        $values = collect($rawValues)
            ->pluck('value')
            ->map(fn ($v) => trim($v))
            ->filter()
            ->unique()
            ->values();

        $inserted = 0;
        $skipped  = [];

        DB::transaction(function () use (
            $attributeId,
            $values,
            &$inserted,
            &$skipped
        ) {

            $startOrder = $this->attributeRepo->getMaxSortOrder($attributeId);

            foreach ($values as $value) {
                try {
                    $this->attributeRepo->create([
                        'attribute_id' => $attributeId,
                        'value'        => $value,
                        'slug'         => Str::slug($value),
                        'sort_order'   => ++$startOrder,
                        'is_active'    => 1,
                    ]);

                    $inserted++;

                } catch (QueryException $e) {
                    // duplicate via DB unique index
                    $skipped[] = $value;
                }
            }
        });

        return redirect()
            ->route('attributeValue.list')
            ->with(
                'success',
                "{$inserted} values added."
                . (count($skipped)
                    ? ' Skipped: ' . implode(', ', $skipped)
                    : ''
                )
            );
    }




    public function updateSortOrder(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->order as $item) {
                $this->attributeRepo->update($item['id'], [
                    'sort_order' => $item['sort_order']
                ]);
            }
        });

        return response()->json(['status' => true]);
    }


    public function update(AttributeValueUpdateRequest $request, $id)
    {
        try {
            $this->attributeRepo->update($id, [
                'value'     => $request->value,
                'slug'      => Str::slug($request->value),
                'is_active' => $request->is_active,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Value updated successfully'
            ]);

        } catch (QueryException $e) {

            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'status' => false,
                    'message' => 'This value already exists for this attribute.'
                ], 422);
            }

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }


    public function destroy($id)
   {
     $this->attributeRepo->delete($id);
      return redirect()->route('attributeValue.list')->with('success','Record Delete Successfully...!!');

   }

}


