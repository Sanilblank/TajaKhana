<?php

namespace App\Http\Controllers;

use App\Mail\VerifyUserEmail;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Chef;
use App\Models\ChefResponsibility;
use App\Models\Menuitem;
use App\Models\MenuitemImage;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;


class FrontController extends Controller
{
    //

    public function index()
    {
        // $ip = '27.34.30.148'; //For static IP address get
        // //$ip = request()->ip(); //Dynamic IP address get
        // $userlocation = Location::get($ip); //Get user coordinates
        // $branch = Branch::where('status', 1)->distance($userlocation->latitude, $userlocation->longitude)->orderBy('distance', 'ASC')->first(); //Choose nearest branch
        $sliders = Slider::latest()->get();
        $branches = Branch::where('status', 1)->get();
        return view('frontend.index', compact('branches', 'sliders'));
    }

    public static function verifyEmail($name, $email, $verification_code)
    {
        $mailData = [
            'name' => $name,
            'verification_code' => $verification_code,
        ];
        Mail::to($email)->send(new VerifyUserEmail($mailData));
    }

    public function aboutus()
    {
        $chefs = Chef::latest()->get();
        return view('frontend.aboutus', compact('chefs'));
    }

    public function shop($id, $location)
    {
        $selectedbranch = Branch::findorfail($id);
        $branchmenu = BranchMenu::latest()->where('branch_id', $selectedbranch->id)->get();
        $categories = Category::latest()->where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();

        return view('frontend.shop', compact('selectedbranch', 'branchmenu', 'categories', 'branches'));
    }

    public function changebranch(Request $request)
    {
        $data = $this->validate($request, [
            'changebranch' => 'required',
        ]);

        $selectedbranch = Branch::findorfail($data['changebranch']);

        return redirect()->route('shop', [$data['changebranch'], $selectedbranch->branchlocation]);
    }

    public function shopdetails($id, $slug)
    {
        $branchmenuitem = BranchMenu::findorfail($id);
        $selectedbranch = Branch::where('id', $branchmenuitem->branch_id)->first();
        $selecteditem = Menuitem::where('id', $branchmenuitem->menuitem_id)->first();
        $itemimages = MenuitemImage::where('menuitem_id', $selecteditem->id)->get();
        $itemimage = MenuitemImage::where('menuitem_id', $selecteditem->id)->first();
        $chefresponsible = ChefResponsibility::where('branch_id', $selectedbranch->id)->where('branchmenu_id', $branchmenuitem->id)->first();

        $relateditems = array();
        $itemcategories = $selecteditem->category_id;
        $branchmenuitems = BranchMenu::where('branch_id', $selectedbranch->id)->where('menuitem_id', '!=', $selecteditem->id)->get();
        foreach($itemcategories as $category_id)
        {
            foreach($branchmenuitems as $item)
            {
                if(count($relateditems) < 7)
                {
                    if(in_array($category_id, $item->menuitem->category_id))
                    {
                        array_push($relateditems, $item);
                    }
                }
            }
        }

        return view('frontend.shopdetails', compact('selectedbranch', 'selecteditem', 'itemimages', 'itemimage', 'relateditems', 'branchmenuitem', 'chefresponsible'));
    }

    public function addtocart(Request $request, $id)
    {
        // $branchmenu = BranchMenu::findorfail($id);
        $cart = Cart::where('user_id', Auth::user()->id)->where('branchmenu_id', $id)->first();
        if($cart)
        {
            return redirect()->back()->with('failure', 'Item is already in cart. Go to cart.');
        }
        else
        {
            $cartitem = Cart::create([
                'user_id' => Auth::user()->id,
                'branchmenu_id' => $id,
                'quantity' => $request['quantity'],
                'price' => $request['price']
            ]);

            $cartitem->save();
            return redirect()->back()->with('success', 'Product is added in cart successfully.');
        }
    }

    public function cart()
    {
        $cartitems = Cart::where('user_id', Auth::user()->id)->get();
        return view('frontend.cart', compact('cartitems'));
    }

    public function updatequantity(Request $request, $id)
    {
        $cart = Cart::where('id', $id)->first();

            $cart->update([
                'quantity' => $request['quantity'],
            ]);
            return redirect()->back()->with('success', 'Quantity is updated successfully.');

    }

    public function removefromcart($id)
    {
        $cart = Cart::where('id', $id)->first();
        $cart->delete();

        return redirect()->back()->with('success', 'Item is removed from cart successfully.');
    }
}
