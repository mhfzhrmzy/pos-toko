<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }
}
