<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(){
        
       $totalIncome = Order::sum('total');
        $users = User::where('is_admin', 0)->latest()->take(5)->get();
        $orders = Order::latest()->get();
 $totalOrders = Order::count(); 
  $loginCount = User::whereNotNull('name')->count();
  $activeUsers = User::where('last_seen_at', '>=', Carbon::now()->subMinutes(5))->count();
        return view('Admin.dashboard',compact('users','orders','totalOrders','totalIncome','loginCount','activeUsers'));
    }
    
}
