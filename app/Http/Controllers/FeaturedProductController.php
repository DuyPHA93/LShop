<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\FeaturedProduct;
use App\Services\FeaturedProductService;

class FeaturedProductController extends Controller
{
    // Master
    // Featured Product List Master Page
    public function masterList(Request $request) {

        $featuredProducts = FeaturedProductService::paging($request);

        return view('pages/admin/featured-products')->with('featuredProducts', $featuredProducts);
    }

    // Master
    // Featured Product Detail Master Page
    public function masterDetail(Request $request) {
        $featuredProduct = FeaturedProduct::find($request->id);
        $products = Product::where('active', 1)->get();
        return view('pages/admin/featuredProduct-detail')   ->with('featuredProduct', $featuredProduct)
                                                            ->with('products', $products);
    }

    /**
     * Save a featuredProduct in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'product' => 'required_if:empty($request->id),true',
            'startDate' => 'required_if:empty($request->id),true',
            'endDate' => 'required'
        ]);

        try {
            $successMsg = "";

            // Check code is exists
            if (FeaturedProductService::checkDuplicate($request->product, $request->id, $request->startDate, $request->endDate)) {
                return response()
                    ->json(['status' => 400, 'message' => "Kỳ hạn từ ngày " . "'" . $request->startDate . "' đến ngày '" . $request->endDate . "' đang giao với kỳ hạn khác.", 'data' => null]);
            }

            if(empty($request->id)) {
                $featuredProduct = $this->create($request);
                $successMsg = stringFormat(config('messages.SUCCESS_CREATED_MSG'), "Featured Product");
            } else {
                $featuredProduct = $this->update($request);
                $successMsg = stringFormat(config('messages.SUCCESS_UPDATED_MSG'), "Featured Product");
            }
            
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            return back();
        }
    }

    /**
     * Remove a featuredProduct in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        DB::beginTransaction();
        try {
            $codes = [];
            foreach (FeaturedProduct::whereIn('id', $request->id)->get() as $delete) {
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
            // return "Error ! This featuredProduct cannot be removed.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This featuredProduct cannot be removed.', 'data' => null]);
        }
    }

    public function create(Request $request)
    {
        return FeaturedProduct::create([
            'product_id' => $request->product,
            'start_date' => empty($request->startDate) ? null : \Carbon\Carbon::createFromFormat('d/m/Y', $request->startDate)->format('Y-m-d'),
            'end_date' => empty($request->endDate) ? null : \Carbon\Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Y-m-d'),
        ]);
    }

    public function update(Request $request)
    {
        $featuredProduct = FeaturedProduct::find($request->id);

        $featuredProduct->end_date = empty($request->endDate) ? null : \Carbon\Carbon::createFromFormat('d/m/Y', $request->endDate)->format('Y-m-d');

        $featuredProduct->save();

        return $featuredProduct;
    }
}
