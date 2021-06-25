<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Menuitem;
use App\Models\Order;
use App\Models\OrderedProducts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if((Auth::user()->users_roles->role_id) == 3)
        {
            return redirect()->route('index');
        }
        else{
            $noofusers = User::where('is_verified', 1)->with(['users_roles' => function ($query) {
                $query->where('role_id', 3);
            }])->count();
            $noofbranches = Branch::where('status', 1)->count();
            $noofitems = Menuitem::count();
            $nooforderstoday = Order::whereDate('created_at', date('Y-m-d'))->count();

            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            //For Piechart
            $monthyear = date('F, Y');
            $frequentusers = array("user1" => 0,"user2" => 0,"user3" => 0,"user4" => 0,"user5" => 0);
            $frequentusersname = array();
            $frequentusersorders = array();

            $allusers = User::where('is_verified', 1)->get();
            foreach($allusers as $user)
            {
                $nooforders = Order::where('user_id', $user->id)->where('monthyear', $monthyear)->where('status_id', '!=' ,6)->count();
                arsort($frequentusers);

                if($nooforders > $frequentusers[array_key_last($frequentusers)])
                {
                    array_pop($frequentusers);
                    $frequentusers[$user->name] = $nooforders;
                    arsort($frequentusers);
                }
            }

            foreach($frequentusers as $key=>$value)
            {
                array_push($frequentusersname, $key);
                array_push($frequentusersorders, $value);
            }

            //For Linechart 1
            $totalorders = array();
            $totalincome = array();
            $totalexpense = array();
            $totalprofit = array();
            for($i=0; $i<12; $i++)
            {
                $totalorders[$i] = 0;
                $totalincome[$i] = 0;
                $totalexpense[$i] = 0;
                $totalprofit[$i] = 0;
            }

            for($i=0; $i<12; $i++)
            {
                $currentmonthyear = $months[$i].', '.date('Y');
                $orders = Order::where('monthyear', $currentmonthyear)->get();
                $totalorders[$i] = count($orders);

                $orderedproducts = OrderedProducts::where('monthyear', $currentmonthyear)->where('status_id', '!=', 6)->get();
                foreach($orderedproducts as $orderedproduct)
                {
                    $totalincome[$i] = $totalincome[$i] + ($orderedproduct->quantity * $orderedproduct->price);
                    $totalexpense[$i] = $totalexpense[$i] + ($orderedproduct->quantity * $orderedproduct->menuitem->costprice);
                    $totalprofit[$i] = $totalincome[$i] - $totalexpense[$i];
                }

            }


            return view('backend.dashboard', compact('noofusers', 'noofbranches', 'noofitems', 'nooforderstoday', 'frequentusersname', 'frequentusersorders', 'totalorders', 'totalincome', 'totalexpense', 'totalprofit'));
        }

    }
}
