<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Brand;
use App\Models\ProductType;
use App\Services\BrandService;

class BrandController extends Controller
{
    // Master
    // Brand List Master Page
    public function masterList(Request $request) {

        $brands = BrandService::paging($request);

        return view('pages/admin/brands')->with('brands', $brands);
    }

    // Master
    // Brand Detail Master Page
    public function masterDetail(Request $request) {
        $brand = Brand::find($request->id);
        $productTypes = ProductType::where('active', 1)->get();
        return view('pages/admin/brand-detail') ->with('brand', $brand)
                                                ->with('productTypes', $productTypes);
    }

    // Ajax
    // Get brands option Html
    public function getBrandHtml(Request $request) {
        $brands = Brand::where('product_type_id', $request->productTypeId)->get();
        $html = "<option value=''></option>";
        foreach($brands as $brand) {
            $html .= "<option value='" . $brand->id . "'>" . $brand->name . "</option>";
        }
        return $html;
    }

    /**
     * Save a brand in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'code' => 'required_if:empty($request->id),true|max:50',
            'name' => 'required',
            'productType' => 'required'
        ]);

        try {
            $successMsg = "";

            if(empty($request->id)) {
                // Check code is exists
                if (Brand::where('code', $request->code)->exists()) {
                    return response()
                        ->json(['status' => 400, 'message' => 'This code already exists.', 'data' => null]);
                } else {
                    $brand = $this->create($request);
                    $successMsg = stringFormat(config('messages.SUCCESS_CREATED_MSG'), "Brand");
                }
            } else {
                $brand = $this->update($request);
                $successMsg = stringFormat(config('messages.SUCCESS_UPDATED_MSG'), "Brand");
            }
            
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            return back();
        }
    }

    /**
     * Remove a brand in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        DB::beginTransaction();
        try {
            $codes = [];
            foreach (Brand::whereIn('id', $request->id)->get() as $delete) {
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
            // return "Error ! This brand cannot be removed.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This brand cannot be removed.', 'data' => null]);
        }
    }

    /**
     * Disable a brand in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        try {
            $roles = Brand::whereIn('id', $request->id);

            $codes = $roles->get()->map(function ($item, $key) {
                return $item->code;
            });

            $roles->update(['active' => false]);

            // return $codes;
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => $codes]);

        } catch( Exception $e) {
            // return "Error ! This brand cannot be disabled.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This brand cannot be disabled.', 'data' => null]);
        }
    }

    public function create(Request $request)
    {
        return Brand::create([
            'code' => $request->code,
            'name' => $request->name,
            'product_type_id' => $request->productType,
            'active' => !empty($request->active)
        ]);
    }

    public function update(Request $request)
    {
        $brand = Brand::find($request->id);

        $brand->name = $request->name;

        $brand->product_type_id = $request->productType;

        $brand->active = !empty($request->active);

        $brand->save();

        return $brand;
    }
}
