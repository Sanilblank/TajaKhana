@extends('backend.layouts.app')
@push('styles')
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endpush
@section('content')
<div class="right_col" role="main">
    <!-- MAIN -->
    @if (session('success'))
    <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    @if (session('failure'))
    <div class="col-sm-12">
        <div class="alert  alert-danger alert-dismissible fade show" role="alert">
            {{ session('failure') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <h1 class="mt-3">Order no. {{$order->id}} <a href="{{route('order.index')}}" class="btn btn-primary btn-sm"> <i class="fa fa-eye" aria-hidden="true"></i> View All Orders</a> </h1>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <p style="font-weight: bold;">Order Id: </p>
                        </div>
                        <div class="col-md-10">
                            <p> {{$order->id}}</p>
                        </div>
                            <div class="col-md-2">
                                <p style="font-weight: bold;">Customer Name: </p>
                            </div>
                        <div class="col-md-10">
                            <p> {{$delivery_address->firstname}} {{$delivery_address->lastname}}</p>
                        </div>
                            <div class="col-md-2">
                                <p style="font-weight: bold;">Customer Email: </p>
                            </div>
                        <div class="col-md-10">
                            <p>{{$delivery_address->email}}</p>
                        </div>
                            <div class="col-md-2">
                                <p style="font-weight: bold;">Delivery Address: </p>
                            </div>
                        <div class="col-md-10">
                            <p>{{$delivery_address->address}}, {{$delivery_address->town}}, {{$delivery_address->district}}</p>
                        </div>
                            <div class="col-md-2">
                                <p style="font-weight: bold;">Customer contact: </p>
                            </div>
                        <div class="col-md-10">
                            <p>{{$delivery_address->phone}}</p>
                        </div>
                            <div class="col-md-2">
                                <p style="font-weight: bold;">Ordered Date: </p>
                            </div>
                        <div class="col-md-10">
                            <p> {{date('F d, Y', strtotime($order->created_at))}}</p>
                        </div>
                        <div class="col-md-2">
                            <p style="font-weight: bold;">Order Status: </p>
                        </div>
                        <div class="col-md-10">
                            <p> {{$order->status->status}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-2">
            @if ($order->status_id != 5)
                <div class="card px-3 py-3 mt-2">
                    <div class="card-header">
                        <h3>Add Other Product</h3>
                    </div>
                    <div class="card-body">

                            <form action="{{route('addproductorder')}}" method="POST">
                                @csrf
                                @method('PUT')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input list="menuitems" name="menuitem_id" placeholder="Select Item" class="form-control">
                                                <datalist id="menuitems">
                                                    @foreach ($menuitems as $item)
                                                        <option value="{{$item->id}}">{{$item->title}} ({{$item->quantity}} {{$item->unit}})</option>
                                                    @endforeach
                                                </datalist>
                                                @error('menuitem_id')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">

                                                <input type="text" name="quantity" class="form-control" value="{{ @old('quantity') }}"
                                                    placeholder="Enter Quantity">
                                                @error('quantity')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input list="branches" name="branch_id" placeholder="Select Branch" class="form-control">
                                                <datalist id="branches">
                                                    @foreach ($branches as $selectedbranch)
                                                        <option value="{{$selectedbranch->id}}">{{$selectedbranch->branchlocation}}</option>
                                                    @endforeach
                                                </datalist>
                                                @error('branch_id')
                                                    <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <input type="hidden" value="{{$order->id}}" name="order_id">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary" type="submit">+ Add</button>
                                        </div>
                                    </div>
                            </form>
                    </div>
                </div>
            @endif
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Order Summary</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item active">
                                  <a class="nav-link active" id="shipping-tab" data-toggle="tab" href="#shipping" role="tab" aria-controls="shipping" aria-selected="true">Ordered Items Details</a>
                                </li>
                                <li>
                                  <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Delivery Address Details</a>
                                </li>
                                <li>
                                    <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">Delivery Status</a>
                                  </li>
                            </ul>
                              <div class="tab-content mt-2" id="myTabContent">
                                <div class="tab-pane fade active show" id="shipping" role="tabcard" aria-labelledby="shipping-tab">
                                    <div class="table table-responsive">
                                        <table class="table text-center">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-center">Item Info</th>
                                                    <th class="text-center">Branch Location</th>
                                                    <th class="text-center">Unit Price</th>
                                                    <th class="text-center">Quantity</th>
                                                    <th class="text-center">Total (Rs.)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ordered_products as $ordered_product)
                                                    @if ($ordered_product->quantity > 0)
                                                        <tr>
                                                            <td style="vertical-align: inherit">
                                                                <a href="{{route('deletefromorder', $ordered_product->id)}}" class="btn btn-danger remove" title="Cancel this product">x</a>
                                                            </td>
                                                            <td style="vertical-align: inherit">
                                                                @php
                                                                    $product_image = DB::table('menuitem_images')->where('menuitem_id', $ordered_product->menuitem_id)->first();
                                                                @endphp
                                                                <img src="{{Storage::disk('uploads')->url($product_image->filename)}}" alt="{{$ordered_product->menuitem->title}}" style="max-height: 100px;">
                                                            </td>
                                                            <td style="vertical-align: inherit">
                                                                <b>{{$ordered_product->menuitem->title}}</b>
                                                                <p>({{$ordered_product->menuitem->quantity}} {{$ordered_product->menuitem->unit}})</p>
                                                            </td>
                                                            <td style="vertical-align: inherit">{{$ordered_product->branch->branchlocation}}</td>
                                                            <td style="vertical-align: inherit">Rs. {{$ordered_product->price}}</td>
                                                            <td style="width: 50px;">
                                                                <form action="{{route('updatequantityadmin', $ordered_product->id)}}" method="POST" class="text-center">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="form-group">
                                                                        <input type="number" class="form-control text-center" min="1" value="{{$ordered_product->quantity}}" name="quantity"/>
                                                                    </div>

                                                                    @if ($ordered_product->status_id == 6)
                                                                    <p class="h6" style="color: red">(Canceled)</p>
                                                                    @elseif ($ordered_product->status_id == 5)
                                                                    <p class="h6" style="color: green">(Delivered)</p>
                                                                    @else
                                                                        <button type="submit" class="btn btn-success">Update</button>
                                                                    @endif
                                                                  </form>

                                                                  {{-- <p class="mt-1">({{$ordered_product->product->quantity}} left in stock)</p> --}}
                                                            </td>
                                                            <td style="vertical-align: inherit">Rs. {{$ordered_product->price * $ordered_product->quantity}}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                    @php
                                                        $grandtotal = 0;
                                                        foreach ($noncancelledorderedproducts as $product) {
                                                            $grandtotal = $grandtotal + ($product->price * $product->quantity);
                                                        }
                                                    @endphp

                                                <tr>

                                                    <td colspan="5" align="right" style="font-weight: bold;">Grand Total:</td>
                                                    <td style="vertical-align: inherit"><input type="text" name="gtotal" value="Rs.{{$grandtotal}}" disabled></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="tab-pane fade mt-2" id="payment" role="tabcard" aria-labelledby="payment-tab">
                                    <form action="{{route('editaddress', $delivery_address->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label for="firstname">Firstname: </label>
                                                <input type="text" name="firstname" class="form-control" value="{{$delivery_address->firstname}}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="lastname">Lastname: </label>
                                                <input type="text" name="lastname" class="form-control" value="{{$delivery_address->lastname}}">
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="email">Email:</label>
                                                <input type="text" name="email" class="form-control" value="{{$delivery_address->email}}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="phone">Phone:</label>
                                                <input type="text" name="phone" class="form-control" value="{{$delivery_address->phone}}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="address">Street Address:</label>
                                                <input type="text" name="address" class="form-control" value="{{$delivery_address->address}}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="town">Town / City:</label>
                                                <input type="text" name="town" class="form-control" value="{{$delivery_address->town}}">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="district">District:</label>
                                                <input type="text" name="district" class="form-control" value="{{$delivery_address->district}}">
                                            </div>

                                        </div>
                                        <center>
                                            <button class="btn btn-success my-3" type="submit">Save Changes</button>
                                        </center>
                                    </form>
                                </div>
                                <div class="tab-pane fade mt-3" id="status" role="tabcard" aria-labelledby="status-tab">
                                    <form action="{{route('changeOrderStatus', $order->id)}}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label for="orderstatus" class="col-md-3"><h3>Order Status:</h3></label>
                                            <div class="col-md-4">
                                                <select name="status_id" class="form-control">
                                                    @foreach ($orderstatuses as $orderstatus)
                                                        <option value="{{$orderstatus->id}}" {{$orderstatus->id == $order->status_id ? 'selected' : ''}}>{{$orderstatus->status}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-group mt-2">
                                                    <textarea name="reason"  cols="30" rows="10" class="form-control" placeholder="Fill the reason only if you are canceling order or leave blank."></textarea>
                                                    @error('reason')
                                                        <div class="text-danger">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-success">Change Status</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush
