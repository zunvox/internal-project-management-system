<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DeveloperInvoiceController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $invoices = Invoice::with([
            'project',
            'items',
        ])
        ->where('user_id', $user->id)
        ->latest()
        ->get();

        return view('developer.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $user = auth()->user();

        $projects = Project::whereHas('assignedUsers', function ($query) use ($user)
        {
            $query->where('users.id', $user->id);
        })
        ->orderBy('name')
        ->get();

        return view('developer.invoices.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'subject' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'status' => [
                'required',
                'in:Draft,Submitted',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.item_name' => [
                'required',
                'string',
                'max:200',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tax_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        /*Assigned developers to the selected project*/

        $project = Project::where('id', $validated['project_id'])
        ->whereHas('assignedUsers', function($query) use ($user)
        {
            $query->where('users.id', $user->id);
        })
        ->firstOrFail();

        /*Calculate invoice total*/

        $subtotal = 0;

        foreach ($validated['items'] as $item)
            {
                $subtotal +=
                $item['quantity'] * $item['unit_price'];
            }

            $taxAmount = $validated['tax_amount'] ?? 0;
            $discountAmount = $validated['discount_amount'] ?? 0;

            $grandTotal = $subtotal + $taxAmount - $discountAmount;

            /*Upload supporting document*/
        
            $attachmentPath = null;

            if($request->hasFile('attachment'))
                {
                    $attachmentPath = $request->file('attachment')
                    ->store('invoice-attachments', 'public');
                }

                /*Save invoice*/

                DB::transaction(function () use(
                    $validated,
                    $user,
                    $project,
                    $subtotal,
                    $taxAmount,
                    $discountAmount,
                    $grandTotal,
                    $attachmentPath,
                ){
                    $invoice = Invoice::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                        'invoice_code' => $this->generateInvoiceCode(),
                        'subject' => $validated['subject'],
                        'description' => $validated['description'] ?? null,
                        'attachment' => $attachmentPath,
                        'status' => $validated['status'],
                        'subtotal' => $subtotal,
                         'tax_amount' => $taxAmount,
                         'discount_amount' => $discountAmount,
                         'grand_total' => $grandTotal,
                         'submitted_at' =>
                         
                         $validated['status'] === 'Submitted'
                        ? now()
                        : null,
                    ]);

                    foreach ($validated['items'] as $item)
                        {
                            $totalPrice = $item['quantity'] * $item['unit_price'];

                            InvoiceItem::create([
                                'invoice_id' => $invoice->id,
                                'item_name' => $item['item_name'],
                                'quantity' => $item['quantity'],
                                'unit_price' => $item['unit_price'],
                                'total_price' => $totalPrice,
                            ]);
                        }
                });

                return redirect()
                ->route('developer.invoices.index')
                ->with(
                    'success',
                    $validated['status'] === 'Draft'
                    ? 'Invoice saved as draft successfully.'
                    : 'Invoice submitted successfully.'
                );
    }

    public function show(Invoice $invoice): View
    {
        $user = auth()->user();

        abort_unless( $invoice->user_id === $user->id, 403);

        $invoice->load([
            'project',
            'items',
        ]);

        return view(
            'developer.invoices.show',
            compact('invoice')
        );
    }

    public function edit(Invoice $invoice): View
    {
        $user = auth()->user();

        abort_unless($invoice->user_id === $user->id, 403);

        abort_unless($invoice->status === 'Draft', 403);

        $projects = Project::whereHas('assignedUsers', function ($query) use ($user)
        {
            $query->where(
                'users.id',
                $user->id
            );
        })
        ->orderBy('name')
        ->get();

        $invoice->load('items');

        return view(
            'developer.invoices.edit',
            compact(
                'invoice',
                'projects'
            )
        );
    }

    /*Delete an invoice*/

    public function destroy(Invoice $invoice)
    {
        $user = auth()->user();

        abort_unless($invoice->user_id === $user->id, 403);

        /*Only draft can be deleted*/

        abort_unless($invoice->status === 'Draft', 403);

        if($invoice->attachment)
            {
                Storage::disk('public')
                ->delete($invoice->attachment);
            }

            $invoice->delete();

            return redirect()
            ->route('developer.invoices.index')
            ->with(
                'success',
                'Invoice deleted successfully.'
            );
    }

    /*Generate unique invoice number*/

    private function generateInvoiceCode(): string
    {
        do
        {
            $code = 'INV-' .
            now()->format('Ymd') .
            '-' .
            strtoupper(substr(uniqid(),-5));
        }
        while(Invoice::where('invoice_code', $code)->exists());

        return $code;
    }
}
