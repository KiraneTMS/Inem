<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Variety;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Requests\VarietyRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Ui\Presets\Vue;

class VarietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $varieties = Variety::where('user_id', Auth::id())->get();
        return view('admin.varieties.index', compact('varieties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::whereNotIn('id', function ($query) {
            $query->select('product_id')->from('varieties')->where('user_id', Auth::id());
        })->get();

        return view('admin.varieties.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(VarietyRequest $request): RedirectResponse
    {
        $product = Product::where('id', $request->product_id)->first();

        $existingVariety = Variety::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if ($existingVariety) {
            return redirect()->back()->with('error', 'Produk sudah digunakan dalam tabel Variety.');
        }

        $variety = new Variety();
        $variety->product_id = $request->product_id;
        $variety->user_id = Auth::id();
        $variety->option_1 = $request->option_1;
        $variety->option_2 = $request->option_2;
        $variety->option_3 = $request->option_3;
        $variety->option_4 = $request->option_4;
        $variety->option_5 = $request->option_5;
        $variety->option_6 = $request->option_6;
        $variety->option_7 = $request->option_7;
        $variety->save();

        return redirect()->route('varieties.index')->with([
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

     //buat detil data
    public function show(Variety $variety, $id)
    {
        $user = Auth::user();
        $variety = Variety::where('user_id', $user->id)->findOrFail($id);
        return view('admin.varieties.show', compact('variety'));
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
        $variety = Variety::where('user_id', $user->id)->findOrFail($id);
        $products = Product::all();
        return view('admin.varieties.edit', compact('variety', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VarietyRequest $request, Variety $variety): RedirectResponse
    {
        // $user = Auth::user();
        // $variety = Variety::where('user_id', $user->id)->findOrFail($id);
        // $variety->product_id = $request->product_id;
        $variety->update($request->validated());
        return redirect()->route('varieties.index')->with([
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
        $variety = Variety::where('user_id', $user->id)->findOrFail($id);
        $variety->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function search(Request $request, $id){
        $variety = Variety::find($id);
        if ($variety->user_id != Auth::id())
        {
            return redirect()->back()->with('error', 'Access denied.');
        }
        $variety = Variety::where('option_1', 'like', '%' . $request->search . '%')->get();
        return json_encode($variety);
    }
}
