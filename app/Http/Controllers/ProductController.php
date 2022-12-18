<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Brand;
use App\Services\FileService;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function showDetail($id)
    {
        $product = Product::find($id);

        if (isset($product)) {
            $file = empty($product->files) ? null : $product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $product->imgSrc = $imgSrc;
        }

        return view('pages/user/detail')->with('product', $product)
                                        ->with('randomProducts', ProductService::getRandomProducts($id));
    }

    public function search(Request $request)
    {
        return view('pages/user/products')  ->with('products', ProductService::search($request))
                                            ->with('randomProducts', ProductService::getRandomProducts(null));
    }

    // Master
    // Product List Master Page
    public function masterList(Request $request) {

        $products = ProductService::paging($request);

        return view('pages/admin/products')->with('products', $products);
    }

    // Master
    // Product Detail Master Page
    public function masterDetail(Request $request) {
        $product = Product::find($request->id);
        $file = empty($product->files) ? null : $product->files->first();
        $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
        $productTypes = ProductType::where('active', 1)->get();
        $brands = isset($product) ? Brand::where('active', 1)->where('product_type_id', $product->product_type_id)->get() : [];
        return view('pages/admin/product-detail')   ->with('product', $product)
                                                    ->with('productTypes', $productTypes)
                                                    ->with('brands', $brands)
                                                    ->with('imgSrc', $imgSrc);
    }

    /**
     * Save a product in the database.
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
            'description' => 'required',
            'price' => 'required',
            'productType' => 'required',
            'quantity' => 'required'
        ]);

        try {
            $successMsg = "";

            if(empty($request->id)) {
                // Check code is exists
                if (Product::where('code', $request->code)->exists()) {
                    return response()
                        ->json(['status' => 400, 'message' => 'This code already exists.', 'data' => null]);
                } else {
                    $product = $this->create($request);
                    FileService::upload($request, null, $product->id, 'App\Models\Product', 'images/products/');
                    $successMsg = stringFormat(config('messages.SUCCESS_CREATED_MSG'), "Product");
                }
            } else {
                $product = $this->update($request);
                FileService::upload($request, $product->files->first(), $product->id, 'App\Models\Product', 'images/products/');
                $successMsg = stringFormat(config('messages.SUCCESS_UPDATED_MSG'), "Product");
            }
            
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            return back();
        }
    }

    /**
     * Remove a product in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        DB::beginTransaction();
        try {
            $codes = [];
            foreach (Product::whereIn('id', $request->id)->get() as $delete) {
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
            // return "Error ! This product cannot be removed.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This product cannot be removed.', 'data' => null]);
        }
    }

    /**
     * Disable a product in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        try {
            $roles = Product::whereIn('id', $request->id);

            $codes = $roles->get()->map(function ($item, $key) {
                return $item->code;
            });

            $roles->update(['active' => false]);

            // return $codes;
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => $codes]);

        } catch( Exception $e) {
            // return "Error ! This product cannot be disabled.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This product cannot be disabled.', 'data' => null]);
        }
    }

    public function create(Request $request)
    {
        return Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'product_type_id' => $request->productType,
            'brand_id' => $request->brand,
            'quantity' => $request->quantity,
            'active' => !empty($request->active)
        ]);
    }

    public function update(Request $request)
    {
        $product = Product::find($request->id);

        $product->name = $request->name;

        $product->description = $request->description;

        $product->price = $request->price;

        $product->product_type_id = $request->productType;

        $product->brand_id = $request->brand;

        $product->quantity = $request->quantity;

        $product->active = !empty($request->active);

        $product->save();

        return $product;
    }
}
