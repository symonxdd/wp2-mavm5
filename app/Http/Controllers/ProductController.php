<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Product;
use App\Order;
use Illuminate\Http\Request;

use routes;
use Session;
use Auth;

class ProductController extends Controller
{
    public function getIndex()
    {
        /*
        sources:
        https://laravel.com/docs/7.x/pagination#paginating-eloquent-results &
        https://laravel.com/docs/7.x/pagination#displaying-pagination-results
        */

        $products = Product::paginate(3);
        return view('shop.index', ['products' => $products]);
    }

    public function getAddToCart(Request $request, $id) {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        $request->session()->put('cart', $cart);
        //volgende regel code dient er enkel voor om te kijken of een click op een film daadwerkelijk iets doet
        //dd($request->session()->get('cart'));
        return redirect()->route('product.index');
    }

    public function getCart() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getCheckout() {
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout', ['total' => $total]);
    }

    // bestelling plaatsen
    public function postCheckout(Request $request) {
        if (!Session::has('cart')) {
            return redirect()->route('shop.shoppingCart');
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;

        $order = new Order();

        // serialize() = neem PHP object en zet om naar een string
        $order->cart = serialize($cart);

        $order->name = $request->input('name');
        $order->address = $request->input('address');
        $order->sum = $request->input('sum');

        if(Auth::id() == null) {
            $order->user_id = 1;
        } else {
            $order->user_id = Auth::id();
        }


        // store the order in the orders table

        // er moet een user ingelogd zijn
        //Auth::user()->orders()->save($order);

        // als niet geeft Laravel een error --> we hbb geen catch voor deze error (buiten bestek van opgave + beperkte tijd met komende examens, etc.)
        // dus doen we dit (login niet nodig):
        $order->save();

        Session::forget('cart'); // shopping cart leegmaken

        return redirect()->route('product.index')->with('success', 'Purchase Successful');
    }
}
