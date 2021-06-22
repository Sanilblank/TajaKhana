<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\DeliveryAddress;
use App\Models\Menuitem;
use App\Models\Order;
use App\Models\OrderedProducts;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->user()->can('manage-order')){
            $neworder = DB::table('notifications')->where('type','App\Notifications\NewOrderNotification')->where('is_read', 0)->get();
            foreach ($neworder as $order) {
                DB::update('update notifications set is_read = 1 where id = ?', [$order->id]);
            }

            if ($request->ajax()) {
                $data = Order::latest()->with('user')->with('status')->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('customer', function($row) {
                            $delivery_address = DeliveryAddress::where('id', $row->delivery_address_id)->first();
                            if($row->user_id == 1)
                            {
                                $admin = "(Made by Admin)";
                            }
                            else{
                                $admin = "";
                            }
                            $customer = $delivery_address->firstname.' '. $delivery_address->lastname . "<br>" .$admin;
                            return $customer;
                        })
                        ->addColumn('address', function($row) {
                            $delivery_address = DeliveryAddress::where('id', $row->delivery_address_id)->first();
                            $address = $delivery_address->address. ', '. $delivery_address->district;
                            return $address;
                        })
                        ->addColumn('phone', function($row) {
                            $delivery_address = DeliveryAddress::where('id', $row->delivery_address_id)->first();
                            return $delivery_address->phone;
                        })
                        ->addColumn('email', function($row) {
                            $delivery_address = DeliveryAddress::where('id', $row->delivery_address_id)->first();
                            return $delivery_address->email;
                        })
                        ->addColumn('date', function($row) {
                            $date = date('F j, Y', strtotime($row->created_at));
                            return $date;
                        })
                        ->addColumn('status', function($row) {
                            if ($row->status_id == 5) {
                                $date = '<span class="badge bg-green">'.$row->status->status.'</span>';
                            }elseif ($row->status_id == 6) {
                                $date = '<span class="badge bg-red">'.$row->status->status.'</span>';
                            }else {
                                $date = '<span class="badge bg-warning">'.$row->status->status.'</span>';
                            }
                            return $date;
                        })
                        ->addColumn('action', function($row){
                            $showurl = route('order.show', $row->id);
                            $btn = "<a href='$showurl' class='edit btn btn-primary btn-sm'>View Order</a>";

                            return $btn;
                        })
                        ->rawColumns(['customer','address', 'phone', 'email', 'status', 'action'])
                        ->make(true);
            }
            return view('backend.order.index');
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if($request->user()->can('manage-order')){
            $branches = Branch::where('status', 1)->get();
            $menuitems = Menuitem::get();
            return view('backend.order.create', compact('branches', 'menuitems'));
        }else{
            return view('backend.permission.permission');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $order = Order::findorFail($id);
        $ordered_products = OrderedProducts::where('order_id', $order->id)->with('menuitem')->with('status')->get();
        $noncancelledorderedproducts = OrderedProducts::where('order_id', $order->id)->where('status_id', '!=', 6)->with('menuitem')->with('status')->get();
        $delivery_address = DeliveryAddress::where('id', $order->delivery_address_id)->first();
        $orderstatuses = OrderStatus::get();
        $branches = Branch::where('status', 1)->get();
        $menuitems = Menuitem::get();
        return view('backend.order.show', compact('order', 'ordered_products', 'delivery_address', 'orderstatuses', 'noncancelledorderedproducts', 'menuitems', 'branches'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function addproductorder(Request $request)
    {
        $data = $this->validate($request, [
            'menuitem_id'=>'required',
            'branch_id'=>'required',
            'order_id' => 'required',
            'quantity' =>'required'
        ]);
        $order = Order::findorfail($data['order_id']);
        $menuitem = Menuitem::where('id', $data['menuitem_id'])->first();

        $branchmenu = BranchMenu::where('branch_id', $data['branch_id'])->where('menuitem_id', $data['menuitem_id'])->first();
        if($branchmenu)
        {
            $monthyear = date('F, Y');
            if($menuitem->discount != 0)
            {
                $discountamount = ($menuitem->discount / 100) * $menuitem->price;
                $afterdiscount = ceil($menuitem->price - $discountamount);
            }
            else
            {
                $afterdiscount = $menuitem->price;
            }
            $orderproduct = OrderedProducts::create([
                'user_id'=>$order->user_id,
                'order_id'=>$data['order_id'],
                'branch_id'=>$data['branch_id'],
                'menuitem_id'=>$data['menuitem_id'],
                'quantity'=>$data['quantity'],
                'price'=>$afterdiscount,
                'status_id'=>$order->status_id,
                'monthyear'=>$monthyear,
            ]);
                $orderproduct->save();

            return redirect()->back()->with('success', 'Item Successfully Added.');

        }
        else
        {
            return redirect()->back()->with('failure', 'Item in not available in selected branch.');

        }

    }

    public function deletefromorder($id)
    {
        $ordered_product = OrderedProducts::findorFail($id);

        $ordered_product->update([
            'status_id' => 6,
            'reason' => 'Cancelled from admin side.'
        ]);

        return redirect()->back()->with('success', 'Product is cancelled from order.');
    }

    public function updatequantityadmin(Request $request, $id)
    {
        $ordered_product = OrderedProducts::findorFail($id);

        $ordered_product->update([
            'quantity' => $request['quantity']
        ]);

        return redirect()->back()->with('success', 'Quantity is updated successfully.');
    }

    public function editaddress(Request $request, $id)
    {
        $delivery_address = DeliveryAddress::findorFail($id);

        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'town' => 'required',
            'district' => 'required',
        ]);

        $delivery_address->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'],
            'town' => $data['town'],
            'district' => $data['district'],
        ]);

        return redirect()->back()->with('success', 'Delivery address details updated successfully.');
    }

    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::findorFail($id);
        $ordered_products = OrderedProducts::where('order_id', $order->id)->get();

        foreach ($ordered_products as $ordered_product) {
            if($ordered_product->status_id != 6){
                if ($request['status_id'] == 6) {
                    $this->validate($request, [
                        'reason' => 'required'
                    ]);

                    $ordered_product->update([
                        'status_id' => $request['status_id'],
                        'reason' => $request['reason'],
                    ]);
                } else {
                    $ordered_product->update([
                        'status_id' => $request['status_id']
                    ]);
                }
            }
        }
        $order->update([
            'status_id' => $request['status_id']
        ]);

        return redirect()->back()->with('success', 'Order Status is updated successfully.');
    }

    public function productorder(Request $request)
    {
        if($request->user()->can('manage-order')){

           $data = $this->validate($request, [
                'firstname'=>'required',
                'lastname'=>'required',
                'address'=>'required',
                'town'=>'required',
                'district'=>'required',
                'postcode'=>'required',
                'phone'=>'required',
                'email'=>'required',
                'menuitem_id'=>'required',
                'branch_id'=>'required',
                'quantity'=>'required',

           ]);

           $branchmenu = BranchMenu::where('branch_id', $data['branch_id'])->where('menuitem_id', $data['menuitem_id'])->first();
           if(!$branchmenu)
           {
               return redirect()->back()->with('failure', 'Selected Item is not available in selected branch.');
           }

            $delivery_address = DeliveryAddress::create([
                'user_id'=>1,
                'firstname'=>$data['firstname'],
                'lastname'=>$data['lastname'],
                'address'=>$data['address'],
                'town'=>$data['town'],
                'district'=>$data['district'],
                'postcode'=>$data['postcode'],
                'phone'=>$data['phone'],
                'email'=>$data['email'],
                'is_default'=>0,
            ]);
            $delivery_address->save();

            $monthyear = date('F, Y');
            $order = Order::create([
                'user_id'=>1,
                'delivery_address_id'=>$delivery_address['id'],
                'status_id'=>1,
                'monthyear'=>$monthyear,
            ]);
            $order->save();

                $product = Menuitem::findorfail($data['menuitem_id']);
                if($product->discount > 0)
                {
                    $discountamount = ($product->discount / 100) * $product->price;
                    $actualamount = $product->price - $discountamount;
                }
                else{
                    $actualamount = $product->price;
                }
                $orderedproduct = OrderedProducts::create([
                    'user_id'=>1,
                    'order_id'=>$order['id'],
                    'branch_id'=>$data['branch_id'],
                    'menuitem_id'=>$data['menuitem_id'],
                    'quantity'=>$data['quantity'],
                    'price'=>$actualamount,
                    'status_id'=>1,
                    'monthyear'=>$monthyear,
                ]);
                $orderedproduct->save();

            return redirect()->route('order.show', $order->id)->with('success', 'Order Added Successfully');


        }else{
            return view('backend.permission.permission');
        }
    }
}
