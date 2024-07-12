<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Product;
use App\Models\User;
use App\Models\StocksHistory;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StockRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\Vue;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = Stock::where('user_id', Auth::id())->get();
        return view('admin.stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::whereNotIn('id', function ($query) {
            $query->select('product_id')->from('stocks')->where('user_id', Auth::id());
        })->get();

        return view('admin.stocks.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request): RedirectResponse
    {
        $product = Product::where('id', $request->product_id)->first();

        $existingStock = Stock::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if ($existingStock) {
            return redirect()->back()->with('error', 'Produk sudah digunakan dalam tabel Stock.');
        }

        $stock = new Stock();
        $stock->product_id = $request->product_id;
        $stock->user_id = Auth::id();
        $stock->stock_1 = $request->stock_1;
        $stock->stock_2 = $request->stock_2;
        $stock->stock_3 = $request->stock_3;
        $stock->stock_4 = $request->stock_4;
        $stock->stock_5 = $request->stock_5;
        $stock->stock_6 = $request->stock_6;
        $stock->stock_7 = $request->stock_7;
        $stock->save();

        return redirect()->route('stocks.index')->with([
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
    public function show(Stock $stock, $id)
    {
        $user = Auth::user();
        $stock = Stock::where('user_id', $user->id)->findOrFail($id);
        return view('admin.stocks.show', compact('stock'));
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
        $stock = Stock::where('user_id', $user->id)->findOrFail($id);
        $products = Product::all();
        return view('admin.stocks.edit', compact('stock', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockRequest $request, Stock $stock, Product $product): RedirectResponse
    {
        // $user = Auth::id();
        // $stock = Stock::where('user_id', $user)->findOrFail($id);
        // $stock->product_id = $request->product_id;

        // $s = $stock->only(['id', 'product_id', 'user_id', 'stock_1', 'stock_2', 'stock_3', 'stock_4', 'stock_5', 'stock_6', 'stock_7']);
        $oldStockValues = $stock->getOriginal();
        // $selectedOldStockValues = array_diff(array_keys($oldStockValues), ['updated_at', 'created_at']);

        $stock->update($request->validated());

        $product = Product::findOrFail($stock->product_id);
        $atributStokBerubah = array_keys($stock->getChanges());
        // $atributStokBerubah = array_diff(array_keys($stock->getChanges()), ['updated_at']);
        // $selectedAtributStokBerubah = array_diff(array_keys($atributStokBerubah), ['updated_at']);
        // $atributStokBerubah = array_filter(array_keys($stock->getChanges()), function ($atribut) {
        //     return $atributStokBerubah !== 'updated_at';
        // });

        // dd($atributStokBerubah, $oldStockValues);

        foreach ($atributStokBerubah as $atribut) {
            $oldValue = $oldStockValues[$atribut];
            $newValue = $stock->$atribut;
            $jenisPemakaian = $this->getJenisPemakaian($oldValue, $newValue);

            // dd($oldValue, $newValue);

            StocksHistory::create([
                'stock_id' => $stock->id,
                'user_id' => auth()->user()->id,
                'product_id' => $stock->product_id,
                'product_name' => $product->name,
                'jenis_stock' => $atribut,
                'old_stock' => $oldValue,
                'new_stock' => $newValue,
                'selisih_stock' => $newValue - $oldValue,
                'jenis_pemakaian' => $jenisPemakaian,
            ]);
        }

        // dd($atributStokBerubah);

        return redirect()->route('stocks.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    private function getJenisPemakaian($oldValue, $newValue)
    {
        switch (true) {
            case $newValue > $oldValue:
                return 'penambahan stok';
            case is_null($newValue) && !is_null($oldValue):
                return 'pengurangan seluruh stok';
            case $newValue < $oldValue:
                return 'pengurangan stok';
            default:
                return '';
        }
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
        $stock = Stock::where('user_id', $user->id)->findOrFail($id);
        $stock->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function search(StockRequest $request, $id){
        $stock = Stock::find($id);
        if ($stock->user_id != Auth::id())
        {
            return redirect()->back()->with('error', 'Access denied.');
        }
        $stock = Stock::where('stock_1', 'like', '%' . $request->search . '%')->get();
        return json_encode($stock);
    }
}
