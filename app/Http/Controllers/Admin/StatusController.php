<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StatusRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Ui\Presets\Vue;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::where('user_id', Auth::id())->get();
        return view('admin.statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::whereNotIn('id', function ($query) {
            $query->select('product_id')->from('statuses')->where('user_id', Auth::id());
        })->get();

        return view('admin.statuses.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusRequest $request): RedirectResponse
    {
        $product = Product::where('id', $request->product_id)->first();

        $existingStatus = Status::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if ($existingStatus) {
            return redirect()->back()->with('error', 'Produk sudah digunakan dalam tabel status.');
        }

        $status = new Status();
        $status->product_id = $request->product_id;
        $status->user_id = Auth::id();
        $status->status = $request->status;
        $status->save();

        return redirect()->route('statuses.index')->with([
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
    public function show(Status $status, $id)
    {
        $user = Auth::user();
        $status = Status::where('user_id', $user->id)->findOrFail($id);
        return view('admin.statuses.show', compact('status'));
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
        $status = Status::where('user_id', $user->id)->findOrFail($id);
        $products = Product::all();
        return view('admin.statuses.edit', compact('status', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StatusRequest $request, Status $status): RedirectResponse
    {
        // $user = Auth::user();
        // $status = Status::where('user_id', $user->id)->findOrFail($id);
        // $status->product_id = $request->product_id;
        $status->update($request->validated());
        return redirect()->route('statuses.index')->with([
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
        $status = Status::where('user_id', $user->id)->findOrFail($id);
        $status->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }

    public function search(Request $request, $id){
        $status = Status::find($id);
        if ($status->user_id != Auth::id())
        {
            return redirect()->back()->with('error', 'Access denied.');
        }
        $status = Status::where('option_1', 'like', '%' . $request->search . '%')->get();
        return json_encode($status);
    }
}
