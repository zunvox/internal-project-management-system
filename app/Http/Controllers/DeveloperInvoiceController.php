<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperInvoiceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $invoices = Invoice::with([
            'project',
            'items',
        ])
        ->where('user_id', )
    }
}
