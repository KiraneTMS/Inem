<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StocksHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class StocksHistoriesController extends Controller
{
    public function index()
    {
        $histories = StocksHistory::where('user_id', Auth::id())->get();
        return view('admin.histories.index', compact('histories'));
    }
}
