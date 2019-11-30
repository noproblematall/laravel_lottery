<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Lottery;
use App\Setting;
use App\Transaction;
use App\Ticket;
use App\Invoice;
use App\Helper\CustomHelper;


class HomeController extends Controller
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
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->type;
        if ($role == 'admin') {
            return redirect()->route('admin.home');
        }else if($role == 'user'){
            $payment_flag = session('payment_flag');
            $visit_flag = session('visit_flag');
            if($payment_flag && $visit_flag) {
                return redirect(route('payment'));
            }
            session(['page' => 'home']);
            $success_ticket = null;
            $income_lottery = '';
            $current_bitcoin = '';
            $available_number = '';
            $ticket_for_prize1 = '';
            $ticket_for_prize2 = '';
            $ticket_for_prize3 = '';
            $cost_of_ticket = Setting::first()->cost_of_ticket;
            $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 0)->orderBy('created_at', 'desc');
            if ($lottery->exists()) {
                $lottery = $lottery->first();
                if ($lottery->win_of_prize2 == null) {
                    $income_lottery = '15%';
                    $user_id = Ticket::find($lottery->win_of_prize1)->user_id;
                    if ($user->id == $user_id) {
                        $ticket_for_prize1 = '5';
                    }

                }else if($lottery->win_of_prize3 == null){
                    $income_lottery = '40%';
                    $user_id = Ticket::find($lottery->win_of_prize2)->user_id;
                    if ($user->id == $user_id) {
                        $ticket_for_prize2 = '15';
                    }
                }
                $today_ticket = $user->tickets()->where('lottery_id', $lottery->id);
                if ($today_ticket->exists()) {
                    $available_number = implode(', ', $today_ticket->get()->pluck('number')->toArray());
                }
                $current_bitcoin = $lottery->tickets()->count() * $lottery->cost_of_ticket;
            }else{
                $income_lottery = '5%';
                $current_bitcoin = Ticket::where('lottery_id', null)->count() * $cost_of_ticket;
                $today_ticket = $user->tickets()->where('lottery_id', null);
                if ($today_ticket->exists()) {
                    $available_number = implode(', ', $today_ticket->get()->pluck('number')->toArray());
                }
            }

            $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 1)->orderBy('created_at', 'desc');
            if ($lottery->exists()) {
                $user_id = Ticket::find($lottery->first()->win_of_prize1)->user_id;
                if ($user->id == $user_id) {
                    $ticket_for_prize1 = '5';
                }
                $user_id = Ticket::find($lottery->first()->win_of_prize2)->user_id;
                if ($user->id == $user_id) {
                    $ticket_for_prize2 = '15';
                }
                $user_id = Ticket::find($lottery->first()->win_of_prize3)->user_id;
                if ($user->id == $user_id) {
                    $ticket_for_prize3 = '40';
                }
            }
            $unpaid_flag = 0;
            if ($user->invoices()->exists()) {
                if($user->invoices()->orderBy('created_at', 'desc')->first()->address != null && $user->invoices()->orderBy('created_at', 'desc')->first()->is_paid == 0){
                    $unpaid_flag = 1;
                }
            }
            return view('home', compact('user', 'income_lottery', 'current_bitcoin', 'available_number', 'cost_of_ticket', 'ticket_for_prize1', 'ticket_for_prize2', 'ticket_for_prize3', 'unpaid_flag'));
        }
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        session(['page' => 'history']);
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = $user->tickets()->count();
            }
        }
        $pagesize = $this->pagesize;
        $tickets = $user->tickets()->orderBy('created_at', 'desc')->with(['invoice'])->paginate($pagesize);
        return view('history', compact('tickets', 'pagesize'));
    }

    public function order_history(Request $request)
    {
        $user = Auth::user();
        session(['page' => 'order_history']);
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = $user->invoices()->count();
            }
        }
        $pagesize = $this->pagesize;
        $invoice = $user->invoices()->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('order_history', compact('invoice', 'pagesize'));
    }

    public function change_password(Request $request)
    {
        $cur_password = $request['old_password'];
        $new_password = $request['new_password'];
        if(!Hash::check($cur_password, Auth::user()->password)){
            $errors = ['error' => 'The old password is incorrect.'];
            return $errors;
        }else{
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'password' => Hash::make($new_password),
            ]);
            return [
                'success' => 'The password was changed successfully.'
            ];
        }
    }

    public function change_profile(Request $request)
    {
        $user = Auth::user();
        if($request->get('username') != ''){
            $user->username = $request->get('username');
        }
        
        if($request->get('email') != ''){
            $user->email = $request->get('email');
        }
        if($request->hasfile('photo')){
            $fileName = time() . '.' . request()->photo->getClientOriginalExtension();
            request()->photo->move(public_path('img/avatar'),$fileName);
            $user->photo = 'img/avatar/' . $fileName;
        }
        $user->update();
        return [
            'success' => 'success'
        ];
    }

    public function payment(Request $request) {
        $payment_flag = session('payment_flag');
        $data = session('post_home');
        $user = Auth::user();
        if ($payment_flag) {
            session()->forget('visit_flag');
            $invoice_id = $data['invoice_id'];
            $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
            $usd = CustomHelper::get_usd();
            $secret = $invoice->secret;
            $amount = $invoice->price_in_bitcoin;
            $amount_usd = $amount * $usd;
            if($invoice->address != null && $invoice->is_paid == 0){
                $address = $invoice->address;
                return view('payment', compact('address', 'amount', 'invoice_id', 'amount_usd'));
            }
            // else if (Invoice::where('is_paid', 0)->where('user_id', null)->exists()) {
            //     $temp_invoice = Invoice::where('is_paid', 0)->where('user_id', null)->first();

            //     $temp_invoice->update([
            //         'user_id' => Auth::id(),
            //         'price_in_bitcoin' => $amount
            //     ]);
            //     $address = $temp_invoice->address;
            //     return view('payment', compact('address', 'amount', 'invoice_id'));
                else{
                $callback_url = config('app.call_back_root') . "callback?invoice_id=" . $invoice_id . "&secret=" . $secret;
    
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => config('app.block_receive_root') . "v2/receive?key=" . config('app.bitcoin_api_key') . "&callback=" . urlencode($callback_url) . "&xpub=" . config('app.xpub'),
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Accept: */*",
                        "Accept-Encoding: gzip, deflate",
                        "Cache-Control: no-cache",
                        "Connection: keep-alive",
                        "Host: api.blockchain.info",
                        "cache-control: no-cache"
                    ),
                ));
    
                $response = curl_exec($curl);
                $response = json_decode($response);
                $err = curl_error($curl);
                curl_close($curl);
    
                if ($err) {
                    return $err;
                }
                if(property_exists($response, 'message')){
                    return redirect(route('home'));
                }else{
                    $invoice->update([
                        'address' => $response->address,
                        'user_id' => Auth::id(),
                    ]);
                    $address = $response->address;
                    return view('payment', compact('address', 'amount', 'invoice_id', 'amount_usd'));
                }
            }

        }else if($user->invoices()->exists()){
            if ($user->invoices()->orderBy('created_at', 'desc')->first()->address != null && $user->invoices()->orderBy('created_at', 'desc')->first()->is_paid == 0) {
                $usd = CustomHelper::get_usd();
                $invoice_id = $user->invoices()->orderBy('created_at', 'desc')->first()->my_invoice_id;
                $amount = $user->invoices()->orderBy('created_at', 'desc')->first()->price_in_bitcoin;
                $amount_usd = $amount * $usd;
                $address = $user->invoices()->orderBy('created_at', 'desc')->first()->address;
                return view('payment', compact('address', 'amount', 'invoice_id', 'amount_usd'));                
            }else{
                return redirect(route('home'));
            }
        }else {
            return redirect(route('home'));
        }
    }

}
