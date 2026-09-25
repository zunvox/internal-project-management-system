<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Claim;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        /*Greeting*/

        $user = auth()->user();

        $hour = now()->hour;

        if ($hour < 12) {
            $greeting = 'Good Morning';
        } elseif ($hour < 18) {
            $greeting = 'Good Afternoon';
        } else {
            $greeting = 'Good Evening';
        }

        $displayName =
            $user->username
            ?: $user->fullname
            ?: 'Admin';


        /*Cash Flow Summary*/

        $totalCashIn =
            CashFlow::where('type', 'Cash In')
                ->sum('amount');

        $totalCashOut =
            CashFlow::where('type', 'Cash Out')
                ->sum('amount');

        $cashFlowBalance =
            $totalCashIn - $totalCashOut;

        $totalTransactions =
            CashFlow::count();


        /*Project Status Overview*/

        $totalProjects =
            Project::count();

        /*Latest 3 projects selected first, then displayed oldest -> newest.*/

        $projects =
            Project::orderByDesc('created_at')
                ->take(4)
                ->get()
                ->sortBy('created_at')
                ->values();

        /*Invoice Review Progress*/

        $totalSubmittedInvoices =
            Invoice::whereNotNull('submitted_at')
                ->count();

        $reviewedInvoices =
            Invoice::whereNotNull('submitted_at')
                ->whereIn('status', [
                    'Approved',
                    'Rejected',
                ])
                ->count();

        $invoiceReviewedPercentage =
            $totalSubmittedInvoices > 0
                ? round(
                    ($reviewedInvoices / $totalSubmittedInvoices) * 100
                )
                : 0;


        /*Claim Review Progress*/

        $totalSubmittedClaims =
            Claim::whereNotNull('submitted_at')
                ->count();

        $reviewedClaims =
            Claim::whereNotNull('submitted_at')
                ->whereIn('status', [
                    'Approved',
                    'Rejected',
                ])
                ->count();

        $claimReviewedPercentage =
            $totalSubmittedClaims > 0
                ? round(
                    ($reviewedClaims / $totalSubmittedClaims) * 100
                )
                : 0;


        /*Latest Review Items*/

        $recentInvoices =
            Invoice::whereIn(
                'status',
                [
                    'Submitted',
                    'Approved',
                    'Rejected',
                ]
            )
                ->latest('updated_at')
                ->take(3)
                ->get()
                ->map(function ($invoice) {
                    return [
                        'type' => 'invoice',

                        'id' => $invoice->id,

                        'code' =>
                            $invoice->invoice_code,

                        'amount' =>
                            (float) $invoice->grand_total,

                        'status' =>
                            $invoice->status,

                        'updated_at' =>
                            $invoice->updated_at,
                    ];
                });


        $recentClaims =
            Claim::whereIn(
                'status',
                [
                    'Submitted',
                    'Approved',
                    'Rejected',
                ]
            )
                ->latest('updated_at')
                ->take(3)
                ->get()
                ->map(function ($claim) {
                    return [
                        'type' => 'claim',

                        'id' => $claim->id,

                        'code' =>
                            $claim->claim_code,

                        'amount' =>
                            (float) $claim->amount,

                        'status' =>
                            $claim->status,

                        'updated_at' =>
                            $claim->updated_at,
                    ];
                });


        $reviewItems =
            $recentInvoices
                ->concat($recentClaims)
                ->sortByDesc('updated_at')
                ->take(3)
                ->values();


        return view(
            'admin.dashboard',
            compact(
                'greeting',
                'displayName',
                'totalCashIn',
                'totalCashOut',
                'cashFlowBalance',
                'totalTransactions',
                'totalProjects',
                'projects',
                'reviewedInvoices',
                'totalSubmittedInvoices',
                'invoiceReviewedPercentage',
                'reviewedClaims',
                'totalSubmittedClaims',
                'claimReviewedPercentage',
                'reviewItems',
            )
        );
    }
}