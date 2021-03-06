<?php

namespace App\Http\Controllers;

use App\Mail\CustomerEmail;
use App\Mail\EmailChangeVerification;
use App\Mail\PasswordChangeVerification;
use App\Mail\RegisterSubscriber;
use App\Mail\SubscriberMail;
use App\Mail\VerifyUserEmail;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Branch;
use App\Models\BranchMenu;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Chef;
use App\Models\ChefResponsibility;
use App\Models\CombomenuRequest;
use App\Models\CookbookCategory;
use App\Models\CookbookItem;
use App\Models\DeliveryAddress;
use App\Models\Faq;
use App\Models\Menuitem;
use App\Models\MenuitemImage;
use App\Models\Order;
use App\Models\OrderedProducts;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\ComboRequestNotification;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    //

    public function index()
    {
        $ip = '27.34.30.148'; //For static IP address get
        //$ip = request()->ip(); //Dynamic IP address get
        $userlocation = Location::get($ip); //Get user coordinates
        $selectedbranch = Branch::where('status', 1)->distance($userlocation->latitude, $userlocation->longitude)->orderBy('distance', 'ASC')->first(); //Choose nearest branch
        $sliders = Slider::latest()->get();
        $branches = Branch::where('status', 1)->get();
        $chefs = Chef::latest()->take(4)->get();
        $reviews = Review::where('disable', null)->latest()->orderBy('rating', 'DESC')->take(6)->get();
        $cookbookitems = CookbookItem::latest()->take(6)->get();
        $blogs = Blog::latest()->take(6)->get();
        $branchmenu = BranchMenu::latest()->where('branch_id', $selectedbranch->id)->take(8)->get();

        return view('frontend.index', compact('branches', 'sliders', 'chefs', 'reviews', 'cookbookitems', 'blogs', 'branchmenu', 'selectedbranch'));
    }

    public function contact()
    {
        $branches = Branch::latest()->where('status', 1)->get();
        return view('frontend.contact', compact('branches'));
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
        $reviews = Review::where('disable', null)->latest()->orderBy('rating', 'DESC')->take(6)->get();
        return view('frontend.aboutus', compact('chefs', 'reviews'));
    }

    public function shop($id, $location)
    {
        $selectedbranch = Branch::findorfail($id);
        $branchmenu = BranchMenu::latest()->where('branch_id', $selectedbranch->id)->get();
        $categories = Category::latest()->where('status', 1)->get();
        $branches = Branch::where('status', 1)->get();
        $popularitems = CookbookItem::latest()->orderBy('view_count')->take(5)->get();

        return view('frontend.shop', compact('selectedbranch', 'branchmenu', 'categories', 'branches', 'popularitems'));
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

    public function checkout($id)
    {
        $cartitems = Cart::where('user_id', $id)->get();
        if(count($cartitems) == 0)
        {
            return redirect()->back()->with('failure', 'No products in your cart.');
        }

        return view('frontend.checkout', compact('cartitems'));
    }

    public function placeorder(Request $request)
    {
        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'address' => 'required',
            'town' => 'required',
            'district' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
          ]);

          $address = DeliveryAddress::where('user_id', Auth::user()->id)->first();
            if($address) {
                $delivery_address = DeliveryAddress::create([
                    'user_id' => Auth::user()->id,
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'address' => $data['address'],
                    'town' => $data['town'],
                    'district' => $data['district'],
                    'postcode' => $data['postcode'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'is_default' => 0
                ]);
            }else {
                $delivery_address = DeliveryAddress::create([
                    'user_id' => Auth::user()->id,
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'address' => $data['address'],
                    'town' => $data['town'],
                    'district' => $data['district'],
                    'postcode' => $data['postcode'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'is_default' => 1
                ]);
            }

            $delivery_address->save();
            $monthyear = date('F, Y');

            $order = Order::create([
                'user_id' => Auth::user()->id,
                'delivery_address_id' => $delivery_address->id,
                'status_id' => 1,
                'monthyear'=>$monthyear,
            ]);

            $order->save();
            $order->notify(new NewOrderNotification($order));

            $cartproducts = Cart::where('user_id', Auth::user()->id)->get();

            foreach($cartproducts as $cartproduct)
            {
                $branchmenu = BranchMenu::where('id', $cartproduct->branchmenu_id)->first();

                $ordered_products = OrderedProducts::create([
                    'user_id' => Auth::user()->id,
                    'order_id' => $order->id,
                    'branch_id' => $branchmenu->branch_id,
                    'menuitem_id' => $branchmenu->menuitem_id,
                    'quantity' => $cartproduct->quantity,
                    'price' => $cartproduct->price,
                    'status_id' => 1,
                    'monthyear' => $monthyear
                ]);
                $ordered_products->save();
                $cartproduct->delete();
            }
            return redirect()->route('index')->with('success', 'Thank you for ordering. We will call you soon.');
    }

    public function addreview(Request $request)
    {
        $data = $this->validate($request, [
            'star' => 'required',
            'username' => 'required',
            'chef_id' => 'required',
        ]);

        $review = Review::create([
            'username' => $data['username'],
            'user_id' => Auth::user()->id,
            'chef_id' => $data['chef_id'],
            'rating' => $data['star'],
            'description' => $request['ratingdescription'],
        ]);

        $review->save();

        return redirect()->back()->with('success', 'Review added successfully.');
    }

    public function updatereview(Request $request, $id)
    {
        $userreview = Review::findorfail($id);
        $data = $this->validate($request, [
            'star' => 'required',
        ]);
        $userreview->update([
            'rating' => $data['star'],
            'description' => $request['ratingdescription'],
        ]);
        $userreview->save();
        return redirect()->back()->with('success', 'Review updated successfully');
    }

    public function deleteuserreview($id)
    {
        $userreview = Review::findorfail($id);
        $userreview->delete();
        return redirect()->back()->with('success', 'Review Deleted Successfully');
    }

    public function myaccount()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $title = $user->name;
        $deliveryaddress = DeliveryAddress::where('user_id', $user->id)->where('is_default', 1)->first();

        return view('frontend.myprofile.myaccount', compact('user', 'deliveryaddress'));
    }

    public function editcustomeraddress()
    {
        $address = DeliveryAddress::where('user_id', Auth::user()->id)->where('is_default', 1)->first();

        return view('frontend.myprofile.editaddress', compact('address'));
    }

    public function updateaddress(Request $request, $id)
    {
        $data = $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'district' => 'required',
            'town' => 'required',
            'postcode' => 'required',
            'email'=>'required|email',
        ]);

        $address = DeliveryAddress::findorfail($id);

        $address->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'address' => $data['address'],
            'town' => $data['town'],
            'district' => $data['district'],
            'postcode' => $data['postcode'],
            'phone' => $data['phone'],
            'email' => $data['email'],

        ]);
        return redirect()->route('myaccount')->with('success', 'Address information Updated Successfully');
    }

    public function myprofile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('frontend.myprofile.myprofile', compact( 'user'));
    }

    public function editinfo()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('frontend.myprofile.editinfo', compact( 'user'));
    }

    public function sendEmailChange(Request $request)
    {
        $user = Auth::user();

        $data = $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
        ]);

        Cookie::queue('emailcookie', $data['email'], 30);
        Cookie::queue('namecookie', $data['name'], 30);


        $mailData = [
            'name' => $data['name'],
            'verification_code' => $user->verification_code,
        ];
        Mail::to($data['email'])->send(new EmailChangeVerification($mailData));

        return redirect()->back()->with('success', 'Please verify from your newly given email');
    }

    public function useremailchange()
    {
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $user = User::where('verification_code', $verification_code)->first();
        if( $user != null)
        {
            $username = Cookie::get('namecookie');
            $email = Cookie::get('emailcookie');

            $user->name = $username;
            $user->email = $email;
            $user->save();

            return redirect()->route('myprofile')->with('success', 'Your name and email has been changed as requested');
        }
        return redirect()->route('index')->with('error', 'Something is wrong.');
    }

    public function sendotpEmail()
    {
        $user = Auth::user();

        $email = $user->email;

        $otp = mt_rand(111111, 999999);

        Cookie::queue('otpcookie', $otp, 10);

        $mailData = [
            'otp' => $otp,
        ];

        Mail::to($email)->send(new PasswordChangeVerification($mailData));

        return view('frontend.myprofile.otpconfirmation');

    }

    public function otpvalidation(Request $request)
    {
        $data = $this->validate($request, [
            'otpcode' => 'required|numeric',
        ]);

        $cookiedata = Cookie::get('otpcookie');

        if($data['otpcode'] == $cookiedata) {

            return view('frontend.myprofile.editpassword');
        }
        else {
            return response()->json([
                'error_message' => 'Your otp code didnt match.'
            ], Response::HTTP_OK);
        }
    }

    public function updatePassword(Request $request)
    {
        $data = $this->validate($request,[
            'oldpassword' =>  'required',
            'newpassword' => 'required|min:8|confirmed|different:password',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        if(Hash::check($data['oldpassword'], $user->password))
        {
            if(!Hash::check($data['newpassword'], $user->password))
            {
                $newpassword = Hash::make($data['newpassword']);
                $user->update([
                    'password' => $newpassword,
                ]);
                $user->save();
                return redirect()->route('myprofile')->with('success', 'Password has been changed.');
            }
            else
            {
                return redirect()->back()
                        ->with('samepass', 'Old password cannot be new password.');
            }
        }
        else{
            return redirect()->back()
                    ->with('oldfailure', 'Your old password doesnot match our credentials.');
        }
    }

    public function myorders()
    {
        $orders = Order::latest()->where('user_id', Auth::user()->id)->with('user', 'status')->get();
        return view('frontend.myprofile.myorders', compact('orders'));
    }

    public function cancelorder(Request $request, $id)
    {
        $orderproduct = OrderedProducts::findorfail($id);

        if ($request['reason'] == null) {
            $data = $this->validate($request, [
                'other' => 'required',
            ]);
            $reason = $data['other'];
        } else {
            $data = $this->validate($request, [
                'reason' => 'required',
            ]);
            $reason = $data['reason'];
        }

        $orderproduct->update([
            'status_id' => 6,
            'reason' => $reason
        ]);

        return redirect()->back()->with('success', 'Cancellation successful.');
    }

    public function myreviews()
    {
        $user_id = Auth::user()->id;
        $reviews = Review::where('user_id', $user_id)->latest()->simplePaginate(10);

        return view('frontend.myprofile.myreviews', compact('reviews'));
    }

    public function customerEmail(Request $request)
    {
        $setting = Setting::first();
        $email = $setting->email;
        $data = $this->validate($request, [
            'fullname'=>'required',
            'customeremail'=>'required',
            'message'=>'required',
        ]);

        $mailData = [
            'fullname' => $request['fullname'],
            'customeremail' => $request['customeremail'],
            'message' => $request['message'],
        ];

        Mail::to($email)->send(new CustomerEmail($mailData));

        return redirect()->back()->with('success', 'Thank you for messaging us. We will get back to you soon.');
    }

    public function reqcombomenu(Request $request)
    {
        $data = $this->validate($request, [
            'menuitem_id' => 'required',
            'fullname' => 'required',
            'contactno' => 'required',
            'description' => 'required',
        ]);

        $combomenurequest = CombomenuRequest::create([
            'fullname' => $data['fullname'],
            'menuitem_id' => $data['menuitem_id'],
            'description' => $data['description'],
            'contactno' => $data['contactno'],
        ]);
        $combomenurequest->save();
        $combomenurequest->notify(new ComboRequestNotification($combomenurequest));

        return redirect()->back()->with('success', 'We will contact you soon.');

    }

    public function getblogs()
    {
        $blogs = Blog::latest()->simplePaginate(4);
        $allblogs = Blog::all();
        $popularblogs = Blog::latest()->orderBy('view_count')->take(5)->get();
        $latestblogs = Blog::latest()->take(5)->get();
        $blogcategories = BlogCategory::latest()->take(5)->get();
        return view('frontend.blog', compact('blogs', 'popularblogs', 'blogcategories', 'allblogs', 'latestblogs'));
    }

    public function getblogdetail($id)
    {
        $blog = Blog::findorfail($id);
        $view_count = $blog->view_count + 1;
        $blog->update([
            'view_count' => $view_count,
        ]);
        $allblogs = Blog::all();
        $popularblogs = Blog::latest()->orderBy('view_count')->take(5)->get();
        $latestblogs = Blog::latest()->take(5)->get();
        $blogcategories = BlogCategory::latest()->take(5)->get();
        return view('frontend.blogdetail', compact('blog', 'popularblogs', 'blogcategories', 'allblogs', 'latestblogs'));
    }

    public function categoryblog($id, $slug)
    {
        $reqcategory = BlogCategory::findorfail($id);

        $blogs = Blog::latest()->whereJsonContains('category', "$reqcategory->id")->simplePaginate(4);
        $allblogs = Blog::all();
        $popularblogs = Blog::latest()->orderBy('view_count')->take(5)->get();
        $latestblogs = Blog::latest()->take(5)->get();
        $blogcategories = BlogCategory::latest()->take(5)->get();
        return view('frontend.categoryblog', compact('blogs', 'popularblogs', 'blogcategories', 'allblogs', 'latestblogs', 'reqcategory'));
    }

    public function authorblogs($name)
    {

        $blogs = Blog::latest()->where('authorname', $name)->simplePaginate(4);
        $allblogs = Blog::all();
        $popularblogs = Blog::latest()->orderBy('view_count')->take(5)->get();
        $latestblogs = Blog::latest()->take(5)->get();
        $blogcategories = BlogCategory::latest()->take(5)->get();
        return view('frontend.authorblog', compact('blogs', 'popularblogs', 'blogcategories', 'allblogs', 'latestblogs', 'name'));
    }

    public function getrecipes()
    {
        $cookbookitems = CookbookItem::latest()->simplePaginate(8);
        $allcookbookitems = CookbookItem::all();
        $popularitems = CookbookItem::latest()->orderBy('view_count')->take(5)->get();
        $latestitems = CookbookItem::latest()->take(5)->get();
        $cookbookcategories = CookbookCategory::latest()->take(5)->get();

        return view('frontend.cookbook', compact('cookbookitems', 'allcookbookitems', 'popularitems', 'latestitems', 'cookbookcategories'));
    }

    public function getrecipedetail($id, $slug)
    {
        $cookbookitem = CookbookItem::findorfail($id);
        $view_count = $cookbookitem->view_count + 1;
        $cookbookitem->update([
            'view_count' => $view_count,
        ]);
        $allcookbookitems = CookbookItem::all();
        $popularitems = CookbookItem::latest()->orderBy('view_count')->take(5)->get();
        $latestitems = CookbookItem::latest()->take(5)->get();
        $cookbookcategories = CookbookCategory::latest()->take(5)->get();

        return view('frontend.recipedetail', compact('cookbookitem', 'allcookbookitems', 'popularitems', 'latestitems', 'cookbookcategories'));
    }

    public function categorycookbookrecipe($id, $slug)
    {
        $reqcategory = CookbookCategory::findorfail($id);

        $cookbookitems = CookbookItem::latest()->whereJsonContains('category', "$reqcategory->id")->simplePaginate(8);
        $allcookbookitems = CookbookItem::all();
        $popularitems = CookbookItem::latest()->orderBy('view_count')->take(5)->get();
        $latestitems = CookbookItem::latest()->take(5)->get();
        $cookbookcategories = CookbookCategory::latest()->take(5)->get();

        return view('frontend.categorycookbook', compact('cookbookitems', 'allcookbookitems', 'popularitems', 'latestitems', 'cookbookcategories', 'reqcategory'));
    }

    public function authorrecipe($name)
    {
        $cookbookitems = CookbookItem::latest()->where('recipeby', $name)->simplePaginate(8);
        $allcookbookitems = CookbookItem::all();
        $popularitems = CookbookItem::latest()->orderBy('view_count')->take(5)->get();
        $latestitems = CookbookItem::latest()->take(5)->get();
        $cookbookcategories = CookbookCategory::latest()->take(5)->get();

        return view('frontend.authorrecipe', compact('cookbookitems', 'allcookbookitems', 'popularitems', 'latestitems', 'cookbookcategories', 'name'));
    }

    public function searchitem($id, $slug)
    {
        $menuitem = Menuitem::findorfail($id);
        $branchmenu = BranchMenu::where('menuitem_id', $menuitem->id)->simplePaginate(12);

        return view('frontend.searchitem', compact('menuitem', 'branchmenu'));
    }

    public function registerSubscriber(Request $request)
    {
        $data = $this->validate($request, [
            'email'=>'required|email',
        ]);

        $exsitingsubscriber = Subscriber::where('email', $data['email'])->first();
        if($exsitingsubscriber)
        {
            return redirect()->route('index')->with('success', 'You have already subscribed. Thank you!!');
        }
        else{
            $subscriber = Subscriber::create([
                'email'=>$data['email'],
                'is_verified'=>0,
                'verification_code'=>sha1(time())
            ]);
            $subscriber->save();
            $mailData = [
                'verification_code' => $subscriber->verification_code,
            ];
            Mail::to($data['email'])->send(new RegisterSubscriber($mailData));

            return redirect()->route('index')->with('success', 'We have sent a confirmation code to your email account for subscription. Please Check your email.');
        }
    }

    public function subscriberconfirm()
    {
        $verification_code = \Illuminate\Support\Facades\Request::get('code');
        $subscriber = Subscriber::where('verification_code', $verification_code)->first();
        if( $subscriber != null)
        {
            $subscriber->is_verified = 1;
            $subscriber->save();
            return redirect()->route('index')->with('success', 'Thank you for subscribing.');
        }
        return redirect()->route('index')->with('failure', 'Sorry, Your subscribtion is not confirmed. Please try again!');
    }

    public static function sendsubscribermail($item_id)
    {
        $menuitem = Menuitem::findorfail($item_id);
        $menuitem_slug = Str::slug($menuitem->title);
        $menuitemimage = MenuitemImage::where('menuitem_id', $item_id)->first();
        $url = 'http://127.0.0.1:8000/searchitem/' . $menuitem->id . '/' . $menuitem_slug;
        $setting = Setting::first();
        $mailData = [
            'menuitem' => $menuitem,
            'menuitemimage' => $menuitemimage,
            'url' => $url,
            'setting' => $setting,
        ];

        $subscribers = Subscriber::where('is_verified', 1)->get();
        foreach($subscribers as $subscriber)
        {
            Mail::to($subscriber->email)->send(new SubscriberMail($mailData));
        }

    }

    public function wishlist()
    {
        $wishlistproducts = Wishlist::latest()->where('user_id', Auth::user()->id)->get();
        return view('frontend.wishlist', compact('wishlistproducts'));
    }

    public function addtowishlist($id)
    {
        $wishlist = Wishlist::where('branchmenu_id', $id)->where('user_id', Auth::user()->id)->first();
        if($wishlist) {
            return redirect()->back()->with('failure', 'Item is already in wishlist. Go to wishlist.');
        } else{
            $wishlistproduct = Wishlist::create([
                'user_id' => Auth::user()->id,
                'branchmenu_id' => $id,
            ]);

            $wishlistproduct->save();
            return redirect()->back()->with('success', 'Item is added in wishlist successfully.');
        }
    }

    public function removefromwishlist($id)
    {
        $wishlist = Wishlist::findorfail($id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Item is removed from wishlist successfully.');
    }

    public function viewfaqs()
    {
        $faqs = Faq::latest()->get();
        return view('frontend.viewfaqs', compact('faqs'));
    }
}
