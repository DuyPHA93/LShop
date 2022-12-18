<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderLine;

use App\Services\FileService;
use App\Services\UserService;

class UserController extends Controller
{
    public function showMyOrder()
    {
        $orders = Order::where('person_order_id', Auth::user()->id)->get();
        foreach($orders as $item) {
            $orderLine = OrderLine::where('order_no', $item->order_no)->first();

            $file = empty($orderLine) || empty($orderLine->product->files) ? null : $orderLine->product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return view('pages/user/orders')->with('orders', $orders);
    }

    public function showOrderDetail(Request $request)
    {
        $order = Order::find($request->id);
        $orderLines = OrderLine::where('order_no', $order->order_no)->get();

        foreach($orderLines as $item) {
            $file = empty($item->product) || empty($item->product->files) ? null : $item->product->files->first();
            $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
            $item->imgSrc = $imgSrc;
        }

        return view('pages/user/order-detail')  ->with('order', $order)
                                                ->with('orderLines', $orderLines);
    }

    // Master
    // User List Master Page
    public function masterList(Request $request) {

        $users = UserService::paging($request);

        return view('pages/admin/users')->with('users', $users);
    }

    // Master
    // User Detail Master Page
    public function masterDetail(Request $request) {
        $user = User::find($request->id);
        $file = empty($user->files) ? null : $user->files->first();
        $imgSrc = empty($file) ? null : ($file->path . $file->file_name);
        return view('pages/admin/user-detail')   ->with('user', $user)
                                                    ->with('imgSrc', $imgSrc);
    }

    /**
     * Save a user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validate the request...
        $validated = $request->validate([
            'email' => 'required_if:empty($request->id),true|email',
            'password' => 'required_if:empty($request->id),true',
            'firstName' => 'required',
            'lastName' => 'required',
            'phone' => 'required',
            'role' => 'required'
        ]);

        try {
            $successMsg = "";

            if(empty($request->id)) {
                // Check email is exists
                if (User::where('email', $request->email)->exists()) {
                    return response()
                        ->json(['status' => 400, 'message' => 'This email already exists.', 'data' => null]);
                } else {
                    $user = $this->create($request);
                    FileService::upload($request, null, $user->id, 'App\Models\User', 'images/users/');
                    $successMsg = stringFormat(config('messages.SUCCESS_CREATED_MSG'), "User");
                }
            } else {
                $user = $this->update($request);
                FileService::upload($request, $user->files->first(), $user->id, 'App\Models\User', 'images/users/');
                $successMsg = stringFormat(config('messages.SUCCESS_UPDATED_MSG'), "User");
            }
            
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => null]);

        } catch (Exception $e) {
            return back();
        }
    }

    /**
     * Remove a user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request) {

        DB::beginTransaction();
        try {
            $codes = [];
            foreach (User::whereIn('id', $request->id)->get() as $delete) {
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
            // return "Error ! This user cannot be removed.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This user cannot be removed.', 'data' => null]);
        }
    }

    /**
     * Disable a user in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disable(Request $request)
    {
        try {
            $roles = User::whereIn('id', $request->id);

            $codes = $roles->get()->map(function ($item, $key) {
                return $item->code;
            });

            $roles->update(['active' => false]);

            // return $codes;
            return response()
                ->json(['status' => 200, 'message' => 'Successfully!', 'data' => $codes]);

        } catch( Exception $e) {
            // return "Error ! This user cannot be disabled.";
            return response()
                ->json(['status' => 500, 'message' => 'Error ! This user cannot be disabled.', 'data' => null]);
        }
    }

    public function create(Request $request)
    {
        return User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'phone' => $request->phone,
            'role_id' => $request->role,
            'active' => !empty($request->active)
        ]);
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);

        $user->password = Hash::make($request->password);

        $user->first_name = $request->firstName;

        $user->last_name = $request->lastName;

        $user->phone = $request->phone;

        $user->role_id = $request->role;

        $user->active = !empty($request->active);

        $user->save();

        return $user;
    }
}
