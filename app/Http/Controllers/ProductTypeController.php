<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProductType;
use App\Services\FileService;
use App\Services\ProductTypeService;

class ProductTypeController extends Controller
{
    // Master
    // ProductType List Master Page
    public function masterList(Request $request) {

        $productTypes = ProductTypeService::paging($request);

        return view('pages/admin/product-types')->with('productTypes', $productTypes);
    }

    // Master
    // ProductType Detail Master Page
    public function masterDetail(Request $request) {
        $productType = ProductType::find($request->id);
        $file = empty($productType->files) ? null : $productType->files->first();
        $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
        return view('pages/admin/productType-detail')   ->with('productType', $productType)
                                                        ->with('imgSrc', $imgSrc);
    }

    /**
     * Save a productType in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'code' => 'required_if:empty($request->id),true|max:50',
            'name' => 'required'
        ]);

        try {
            $successMsg = "";

            if(empty($request->id)) {
                // Check code is exists
                if (ProductType::where('code', $request->code)->exists()) {
                    // return back()->withInput()->withErrors(['code' => 'This code already exists.']);
                    return response()
                        ->json(['status' => 400, 'message' => 'This code already exists.', 'data' => null]);
                } else {
                    $productType = $this->create($request);
                    FileService::upload($request, null, $productType->id, 'App\Models\ProductType', 'images/productTypes/');
                    $successMsg = stringFormat(config('messages.SUCCESS_CREATED_MSG'), "ProductType");
                }
            } else {
                $productType = $this->update($request);
                FileService::upload($request, $productType->files->first(), $productType->id, 'App\Models\ProductType', 'images/productTypes/');
                $successMsg = stringFormat(config('messages.SUCCESS_UPDATED_MSG'), "ProductType");
            }
    
            // Alert::success('Successfully', $successMsg);
            // return redirect()->route('productTypeMasterList');
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            // Alert::error('Error', config('messages.COMMON_ERROR_MSG'));
            return back();
        }
    }

    /**
     * Remove a productType in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        DB::beginTransaction();
        try {
            $codes = [];
            foreach (ProductType::whereIn('id', $request->id)->get() as $delete) {
                array_push($codes, $delete->code);
                $delete->delete();
            }

            DB::commit();
            // return implode(",", $codes);
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);
        ;

        } catch( Exception $e) {
            DB::rollBack();
            // return "Error ! This productType cannot be removed.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This productType cannot be removed.', 'data' => null]);
        }
    }

    /**
     * Disable a productType in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        try {
            $roles = ProductType::whereIn('id', $request->id);

            $codes = $roles->get()->map(function ($item, $key) {
                return $item->code;
            });

            $roles->update(['active' => false]);

            // return $codes;
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => $codes]);

        } catch( Exception $e) {
            // return "Error ! This productType cannot be disabled.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This productType cannot be disabled.', 'data' => null]);
        }
    }

    public function create(Request $request)
    {
        return ProductType::create([
            'code' => $request->code,
            'name' => $request->name,
            'active' => !empty($request->active)
        ]);
    }

    public function update(Request $request)
    {
        $productType = ProductType::find($request->id);

        $productType->name = $request->name;

        $productType->active = !empty($request->active);

        $productType->save();

        return $productType;
    }
}
