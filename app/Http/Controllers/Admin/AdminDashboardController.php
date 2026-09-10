<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // General Statistics
        $totalSales = Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        // Low stock products alert (stock <= 5)
        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Chart Data: Sales per day for the last 7 days
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_amount) as total')
        )
        ->whereIn('status', ['paid', 'shipped', 'completed'])
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $chartLabels = [];
        $chartTotals = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            $found = $salesData->firstWhere('date', $date);
            $chartTotals[] = $found ? (float) $found->total : 0;
        }

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'lowStockProducts',
            'recentOrders',
            'chartLabels',
            'chartTotals'
        ));
    }

    public function orders(): View
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $newStatus = $request->input('status');
        $oldStatus = $order->status;

        // If changing status to cancelled, ensure stock is restored if not previously cancelled
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            DB::transaction(function () use ($order, $newStatus) {
                $order->update(['status' => $newStatus]);
                foreach ($order->items as $item) {
                    $item->product->increment('stock', $item->quantity);
                }
            });
        } else {
            $order->update(['status' => $newStatus]);
        }

        return back()->with('success', "อัปเดตสถานะคำสั่งซื้อ #{$order->order_number} เป็น {$newStatus} เรียบร้อยแล้ว");
    }
}
