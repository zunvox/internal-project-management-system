<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\View\View;

class DeveloperDashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        /*Current Month*/

        $now = now();

        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();


        /*Greeting*/

        $hour = (int) $now->format('H');

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
            ?: 'Developer';


        /*Assigned Projects*/

        $assignedProjectsQuery = Project::whereHas(
            'assignedUsers',
            function ($query) use ($user) {
                $query->where('users.id', $user->id);
            }
        )
        ->whereIn('status', [
            'Ongoing',
            'Completed',
            'On Hold',
        ]);


        /*Total visible assigned projects*/

        $assignedProjectsCount =
            (clone $assignedProjectsQuery)->count();


        /*Get latest 3 projects first, then display those 3 from oldest -> newest.*/

        $assignedProjects =
            (clone $assignedProjectsQuery)
                ->orderByDesc('created_at')
                ->take(3)
                ->get()
                ->sortBy('created_at')
                ->values();


        /*Pending Invoices*/

        $pendingInvoicesCount =
            Invoice::where('user_id', $user->id)
                ->where('status', 'Submitted')
                ->count();


        /*Pending Claims*/

        $pendingClaimsCount =
            Claim::where('user_id', $user->id)
                ->where('status', 'Submitted')
                ->count();


        /*Latest Invoices*/

        $latestInvoices =
            Invoice::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->take(3)
                ->get()
                ->sortBy('created_at')
                ->values();


        /*Total Submitted Request Amount This Month*/

        $submittedInvoiceAmount =
            Invoice::where('user_id', $user->id)
                ->whereNotNull('submitted_at')
                ->where('status', '!=', 'Rejected')
                ->whereBetween(
                    'submitted_at',
                    [
                        $currentMonthStart,
                        $currentMonthEnd,
                    ]
                )
                ->sum('grand_total');


        $submittedClaimAmount =
            Claim::where('user_id', $user->id)
                ->whereNotNull('submitted_at')
                ->where('status', '!=', 'Rejected')
                ->whereBetween(
                    'submitted_at',
                    [
                        $currentMonthStart,
                        $currentMonthEnd,
                    ]
                )
                ->sum('amount');


        $submittedRequestAmount =
            $submittedInvoiceAmount
            + $submittedClaimAmount;


        /*Approved Amount This Month*/

        $approvedInvoiceAmount =
            Invoice::where('user_id', $user->id)
                ->where('status', 'Approved')
                ->whereNotNull('submitted_at')
                ->whereBetween(
                    'submitted_at',
                    [
                        $currentMonthStart,
                        $currentMonthEnd,
                    ]
                )
                ->sum('grand_total');


        $approvedClaimAmount =
            Claim::where('user_id', $user->id)
                ->where('status', 'Approved')
                ->whereNotNull('submitted_at')
                ->whereBetween(
                    'submitted_at',
                    [
                        $currentMonthStart,
                        $currentMonthEnd,
                    ]
                )
                ->sum('amount');


        $approvedAmount =
            $approvedInvoiceAmount
            + $approvedClaimAmount;


        /*Approved Percentage*/

        $approvedPercentage =
            $submittedRequestAmount > 0
                ? min(
                    100,
                    round(
                        ($approvedAmount / $submittedRequestAmount) * 100
                    )
                )
                : 0;


        /*Dashboard*/

        return view(
            'developer.dashboard',
            compact(
                'greeting',
                'displayName',
                'assignedProjectsCount',
                'assignedProjects',
                'pendingInvoicesCount',
                'pendingClaimsCount',
                'latestInvoices',
                'approvedAmount',
                'submittedRequestAmount',
                'approvedPercentage',
            )
        );
    }
}