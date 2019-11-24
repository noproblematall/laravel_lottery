<?php

namespace App\Http\Controllers;

use App\Helper\CustomHelper as AppCustomHelper;
use Illuminate\Http\Request;
use App\User;
use App\Lottery;
use App\Ticket;
use App\Setting;
use App\Invoice;
use CustomHelper;

class AdminController extends Controller
{
    private $pagesize;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pagesize = 10;
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        session(['page' => 'home']);
        $usd = CustomHelper::get_usd();
        $bit_per_ticket = Setting::first()->cost_of_ticket;
        $sent_sum = 0;
        $get_sum = 0;
        $today_bitcoin = 0;
        $lottery = Lottery::where('is_end', 1);
        if($lottery->exists()) {
            foreach ($lottery->get()->pluck('total_bitcoin') as $item) {
                 $sent_sum += $item * 0.6;
                 $get_sum += $item;
            }
        }
        $current_lottery = Lottery::where('is_end', 0);
        if ($current_lottery->exists()) {
            $today_bitcoin = $current_lottery->first()->total_bitcoin;
        }else{
            $current_tickets = Ticket::whereNull('lottery_id');
            if ($current_tickets->exists()) {
                $today_bitcoin = $bit_per_ticket * $current_tickets->count();
            }
        }
        $total_user = 0;
        $real_user = 0;
        $user = User::where('role_id', '!=', 1);
        if ($user->exists()) {
            $total_user = $user->count();
            $real_user = $user->whereNotNull('email_verified_at')->count();
        }
        return view('admin.index', compact('sent_sum', 'usd', 'get_sum', 'today_bitcoin', 'total_user', 'real_user'));
    }

    public function user_manage(Request $request)
    {
        session(['page' => 'user_manage']);
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = User::where('role_id', '2')->count();
            }
        }
        $pagesize = $this->pagesize;
        $user = User::where('role_id', '2')->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.user_manage', compact('user', 'pagesize'));
    }

    public function user_delete($id)
    {
        if (User::where('id', $id)->exists()) {
            User::find($id)->delete();
            return back()->withSuccess('Deleted Successfully.');
        } else {
            return back()->withErrors(['exist'=>'The User is not exist.']);
        }
        
    }

    public function setting()
    {
        session(['page' => 'setting']);
        if (!Setting::first()) {
            $setting = null;
            return view('admin.setting', compact('setting'));
        } else {
            $setting = Setting::first();
            return view('admin.setting', compact('setting'));
        }
        
    }

    public function time_cost(Request $request)
    {
        $request->validate([
            'time_of_prize1' => 'required',
            'time_of_prize2' => 'required',
            'time_of_prize3' => 'required',
            'cost_of_ticket' => 'required',
        ]);

        if (!Setting::first()) {
            Setting::create($request->all());
            return back()->withSuccess('Created successfully.');
        } else {
            Setting::first()->update($request->all());            
            return back()->withSuccess('Updated successfully.');
        }

    }

    public function order_manage(Request $request)
    {
        session(['page' => 'order_manage']);
        $pagesize = 10;
        if ($request->has('pagesize')) {
            $pagesize = $request->get('pagesize');
            if($pagesize == 'all'){
                $pagesize = Invoice::all()->count();
            }
        }
        $invoice = Invoice::orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.order_manage', compact('invoice', 'pagesize'));
    }

    public function order_detail($id)
    {
        if (Invoice::where('id', $id)->exists()) {
            $invoice = Invoice::with(['user', 'tickets', 'invoice_payment', 'invoice_pending_payment'])->find($id);
            return view('admin.order_detail', compact('invoice'));
        }else{
            return back();
        }
    }
    
}
