<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Price;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Requests\PriceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\Vue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prices = Price::where('user_id', Auth::id())->get();
        return view('admin.prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::whereNotIn('id', function ($query) {
            $query->select('product_id')->from('prices')->where('user_id', Auth::id());
        })->get();

        return view('admin.prices.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriceRequest $request): RedirectResponse
    {
        $product = Product::where('id', $request->product_id)->first();

        $existingPrice = Price::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if ($existingPrice) {
            return redirect()->back()->with('error', 'Produk sudah digunakan dalam tabel Price.');
        }

        $price = new Price();
        $price->product_id = $request->product_id;
        $price->user_id = Auth::id();
        $price->price_1 = $request->price_1;
        $price->price_2 = $request->price_2;
        $price->price_3 = $request->price_3;
        $price->price_4 = $request->price_4;
        $price->price_5 = $request->price_5;
        $price->price_6 = $request->price_6;
        $price->price_7 = $request->price_7;
        $price->save();

        return redirect()->route('prices.index')->with([
            'message' => 'successfully added!',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     //buat detail data
    public function show(Price $price, $id)
    {
        $user = Auth::user();
        $price = Price::where('user_id', $user->id)->findOrFail($id);
        return view('admin.prices.show', compact('price'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $price = Price::where('user_id', $user->id)->findOrFail($id);
        $products = Product::all();
        return view('admin.prices.edit', compact('price', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PriceRequest $request, Price $price): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'price_1' => 'integer | nullable',
            'price_2' => 'integer | nullable',
            'price_3' => 'integer | nullable',
            'price_4' => 'integer | nullable',
            'price_5' => 'integer | nullable',
            'price_6' => 'integer | nullable',
            'price_7' => 'integer | nullable',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput()->with([
                'message' => 'there was a mistake !',
                'alert-type' => 'danger'
            ]);;
        }
        // $user = Auth::user();
        // $price = Price::where('user_id', $user->id)->findOrFail($id);
        // $price->product_id = $request->product_id;
        $price->update($request->validated());
        return redirect()->route('prices.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $price = Price::where('user_id', $user->id)->findOrFail($id);
        $price->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function search(PriceRequest $request, $id){
        $price = Price::find($id);
        if ($price->user_id != Auth::id())
        {
            return redirect()->back()->with('error', 'Access denied.');
        }
        $price = Price::where('price_1', 'like', '%' . $request->search . '%')->get();
        return json_encode($price);
    }
}
