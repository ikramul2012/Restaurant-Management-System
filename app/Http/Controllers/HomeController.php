<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use App\Models\Book;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function my_home()
    {
        $data = Food::all();
        return view('home.index', compact('data'));
    }

    public function index()
    {
        if (Auth::id()) {
            $usertype = Auth()->user()->usertype;
            if ($usertype == 'user') {
                $data = Food::all();
                return view('home.index', compact('data'));
            } else {
                $total_user = User::where('usertype', '=', 'user')->count();
                $total_food = Food::count();
                $total_order = Order::count();
                $total_delivered = Order::where('delivery_status', '=', 'Delivered')->count();
                return view('admin.index', compact('total_user', 'total_food', 'total_order', 'total_delivered'));
            }
        }
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $food = Food::find($id);
            $cart = new Cart;
            $cart->title = $food->title;
            $cart->details = $food->detail;
            $cart->price = Str::remove('$', $food->price) * $request->qty;
            $cart->image = $food->image;
            $cart->quantity = $request->qty;
            $cart->userid = Auth()->user()->id;
            $cart->save();
            return redirect()->back();
        } else {
            return redirect("login");
        }
    }

    public function my_cart()
    {
        $user_id = Auth()->user()->id;
        $data = Cart::where('userid', '=', $user_id)->get();
        return view('home.my_cart', compact('data'));
    }

    public function remove_cart($id)
    {
        Cart::find($id)->delete();
        return redirect()->back();
    }

    public function confirm_order(Request $request)
    {
        $user_id = Auth()->user()->id;
        $cart_items = Cart::where('userid', '=', $user_id)->get();

        if ($cart_items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        foreach ($cart_items as $cart) {
            $order = new Order;
            $order->name = $request->name;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->address = $request->address;
            $order->title = $cart->title;
            $order->quantity = $cart->quantity;
            $order->price = $cart->price;
            $order->image = $cart->image;
            $order->save();
            $cart->delete();
        }

        return redirect('/')->with('success', 'Your order has been placed successfully!');
    }

    public function book_table(Request $request)
    {
        $data = new Book;
        $data->phone = $request->phone;
        $data->guest = $request->n_guest;
        $data->time = $request->time;
        $data->date = $request->date;
        $data->advance = $request->advance;
        $data->save();
        return redirect()->back();
    }
}
