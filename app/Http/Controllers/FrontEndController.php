<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Payment;
use App\Setting;
use App\InvoicePayment;
use App\InvoicePendingPayment;
use App\Ticket;
use App\Lottery;
use DB;
use CustomHelper;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Faker\Factory as Faker;

use Auth;
use Session;
use Mail;

class FrontEndController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usd = CustomHelper::get_usd();
        $btc = 1/$usd;
        $today_bitcoin = 0;
        $next_time = Setting::first()->time_of_prize1;
        $next_prize = 0;
        $prize1 = 0;
        $prize2 = 0;
        $prize3 = 0;
        $remaing_time = 0;
        $today_date = date('Y-m-d');
        // dd(time());
        // dd($today);
        // dd(date('Y-m-d H:i:s', strtotime($today . '14:20')));
        $bit_per_ticket = Setting::first()->cost_of_ticket;
        $current_lottery = Lottery::where('is_end', 0)->orderBy('created_at', 'desc');
        $date = date('m/d/Y') . ' - Today at ';
        $more_flag = 0;
        if ($current_lottery->exists()) {
            $today_bitcoin = $current_lottery->first()->total_bitcoin;
            if ($current_lottery->first()->win_of_prize2 == null) {
                $next_time = $current_lottery->first()->time_of_prize2;
                $next_prize = $today_bitcoin * 0.15;
                $prize2 = $next_prize;
                $prize3 = $today_bitcoin * 0.4;
                $remaing_time = strtotime($today_date . $next_time) - time();
            } else {
                $next_time = $current_lottery->first()->time_of_prize3;
                $next_prize = $today_bitcoin * 0.4;
                $prize3 = $next_prize;
                $remaing_time = strtotime($today_date . $next_time) - time();
            }
        }else {
            $current_tickets = Ticket::whereNull('lottery_id')->orWhere('lottery_id', 0);
            if(Lottery::where('is_end', 1)->whereDate('created_at', '=', date('Y-m-d'))->exists()){
                $date = date("m/d/Y", strtotime("+1 day")) . ' - Tomorrow at ';
                $remaing_time = strtotime(date("m/d/Y", strtotime("+1 day")) . $next_time) - time();
                
            }else {
                $remaing_time = strtotime($today_date . $next_time) - time();
                if ($remaing_time < 0) {
                    $remaing_time = strtotime(date("m/d/Y", strtotime("+1 day")) . $next_time) - time();
                    $invoice_array = $current_tickets->get()->pluck('invoice_id')->toArray();
                    $today_bitcoin = Invoice::whereIn('my_invoice_id', $invoice_array)->get()->sum('price_in_bitcoin');
                    // $today_bitcoin = $bit_per_ticket * $current_tickets->count();
                    $next_prize = $today_bitcoin * 0.05;
                    $prize1 = $next_prize;
                    $prize2 = $today_bitcoin * 0.15;
                    $prize3 = $today_bitcoin * 0.4;
                } else {
                    $invoice_array = $current_tickets->get()->pluck('invoice_id')->toArray();
                    $today_bitcoin = Invoice::whereIn('my_invoice_id', $invoice_array)->get()->sum('price_in_bitcoin');
                    // $today_bitcoin = $bit_per_ticket * $current_tickets->count();
                    $next_prize = $today_bitcoin * 0.05;
                    $prize1 = $next_prize;
                    $prize2 = $today_bitcoin * 0.15;
                    $prize3 = $today_bitcoin * 0.4;
                }
            }
            
        }

        $last_lottery = Lottery::with(['tickets'])->where('is_end', 1)->orderBy('created_at', 'desc');
        // $last_bitcoin = $last_lottery->total_bitcoin;
        if ($last_lottery->exists()) {

            $last_four_lottery = $last_lottery->get()->take(4);
            if ($last_lottery->count() > 4) {
                $more_flag = 1;
            }
        }else{
            $last_four_lottery = collect([]);
        }
        $sent_sum = 0;
        $prize_number = 0;
        $lottery = Lottery::where('is_end', 1);
        if($lottery->exists()) {
            $prize_number = $lottery->count() * 3;
            foreach ($lottery->get()->pluck('total_bitcoin') as $item) {
                 $sent_sum += $item * 0.6;
            }
        }
        $result = $date  . date('h:i a', strtotime($next_time));
        return view('welcome', compact('usd','bit_per_ticket', 'remaing_time', 'next_prize', 'prize1', 'prize2', 'prize3', 'today_bitcoin', 'next_time', 'last_lottery', 'last_four_lottery', 'sent_sum', 'prize_number', 'result', 'more_flag'));
    }    
    
    public function post_home(Request $request)
    {
        $rule = [
            'wallet_address' => 'required|regex:/^[13][a-km-zA-HJ-NP-Z0-9]{26,33}$/im',
            'bit_number' => 'required',
            'g-recaptcha-response' => 'recaptcha',
        ];
        if (!Auth::user()) {
            $rule['email'] = 'required|email';
        }
        $request->validate($rule);

        $data = $request->all();
        
        $usd = CustomHelper::get_usd();
        $btc = 1/$usd;
        $price_per_ticket = Setting::first()->cost_of_ticket;
        // $amount_usd = (int)$data['bit_number'] * $price_per_ticket;
        // $amount_btc = $amount_usd * $btc;

        if ($data['bit_number'] == 1) {
            $amount_usd = $price_per_ticket;
        }else if($data['bit_number'] == 5){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.02);
        }else if($data['bit_number'] == 10){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.05);
        }else if($data['bit_number'] == 50){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.075);
        }else if($data['bit_number'] == 100){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.1);
        }else if($data['bit_number'] == 250){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.15);
        }else if($data['bit_number'] == 500){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.2);
        }else if($data['bit_number'] == 1000){
            $amount_usd = (int)$data['bit_number'] * $price_per_ticket - ((int)$data['bit_number'] * $price_per_ticket * 0.25);
        }else{
            return back();
        }
        
        $amount_btc = $amount_usd * $btc;
        $wallet_address = $data['wallet_address'];
        $invoice_id = uniqid();
        $secret = md5(uniqid());
        Invoice::create([
            'secret' => $secret,
            'my_invoice_id' => $invoice_id,
            'price_in_bitcoin' => round($amount_btc, 8),
            'price_in_usd' => $amount_usd,
            'number_of_ticket' => $data['bit_number'],
            'wallet_address' => $wallet_address,
        ]);

        $data['invoice_id'] = $invoice_id;
        $request->session()->put('payment_flag', 1);
        $request->session()->put('visit_flag', 1);
        $request->session()->put('post_home', $data);
        
        $auth_user = Auth::user();
        if($auth_user) {
            return redirect(route('payment'));
        } else {
            $email = $data['email'];
            $user = User::whereEmail($email)->first();
            if($user) {
                return redirect(route('login'));
            } else {
                return redirect(route('register'));
            }
        }
    }

    public function callback(Request $request)
    {
        $data = $request->all();
        if (empty($data)) {
            return;
        }
        // CustomHelper::datalog(json_encode($data));
        $invoice_id = $data['invoice_id'];
        $transaction_hash = $data['transaction_hash'];
        $address = $data['address'];
        $confirmations = $data['confirmations'];
        $secret = $data['secret'];
        $value_in_btc = $data['value'] / 100000000;
        $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
        if ($invoice->address != $address) {
            echo 'Incorrect Receiving Address';
            return;
        }
        if ($invoice->secret != $secret) {
            echo 'Invalid Secret';
            return;
        }
        if ($confirmations >= 1) {
            InvoicePayment::create([
                'transaction_hash' => $transaction_hash,
                'value' => $value_in_btc,
                'invoice_id' => $invoice_id,
            ]);
            $paid_btc = $invoice->invoice_payment()->get()->sum('value');
            $price_btc = $invoice->price_in_bitcoin;
            if ($paid_btc >= $price_btc) {
                $invoice->is_paid = 1;
                $invoice->save();
                $current_tickets = array();
                $tickets = Ticket::where('lottery_id', null)->orWhere('lottery_id', 0);
                DB::transaction(function () use($invoice, $tickets, $current_tickets) {
                    for ($i=0; $i < $invoice->number_of_ticket; $i++) {
                        mt_srand();
                        $current_tickets = $tickets->get()->pluck('number')->toArray();
                        do {
                            $random_number = mt_rand(1000000, 9999999);
                        } while (in_array($random_number, $current_tickets));
                        Ticket::create([
                            'invoice_id' => $invoice->my_invoice_id,
                            'number' => $random_number,
                            'user_id' => $invoice->user_id,
                        ]);
                        array_push($current_tickets, $random_number);
                    }
                });
            }


            $pending_payment = InvoicePendingPayment::where('invoice_id', $invoice_id)->where('transaction_hash', $transaction_hash);
            if ($pending_payment->exists()) {
                $pending_payment->delete();
            }

            echo "*ok*";
        }else{
            $invoice_pending = InvoicePendingPayment::where('invoice_id', $invoice_id)->where('transaction_hash', $transaction_hash);
            if (!$invoice_pending->exists()) {
                InvoicePendingPayment::create([
                    'transaction_hash' => $transaction_hash,
                    'value' => $value_in_btc,
                    'invoice_id' => $invoice_id,
                ]);                
            }
            echo "Waiting for confirmations";
        }
    }

    
    public function payment_verify(Request $request)
    {
        $data = array();
        $paid_btc = 0;
        $pending_btc = 0;
        $invoice_id = $request->get('invoice_id');
        $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
        $amount = $invoice->price_in_bitcoin;
        $invoice_payment = InvoicePayment::where('invoice_id', $invoice_id);
        $invoice_pending = InvoicePendingPayment::where('invoice_id', $invoice_id);
        if ($invoice_payment->exists()) {
            $paid_btc = $invoice->invoice_payment()->get()->sum('value');
            $data['paid_btc'] = $paid_btc;
            if ($paid_btc >= $amount) {

                $user = $invoice->user;
                $user_name = $user->username;
                $user_email = $user->email;
                $data = array('name'=>$user_name, 'paid_btc'=>$paid_btc);
                    Mail::send('emails.payment_confirm', $data, function($message) use($user_email, $user_name) {
                    $message->to($user_email, $user_name)->subject('Payment Confirmed');
                });

                $data['status'] = 1;
                return response()->json($data);
            }else if($invoice_pending->exists()){
                $pending_btc = $invoice->invoice_pending_payment()->get()->sum('value');
                $data['pending_btc'] = $pending_btc;
                $data['status'] = 0;
                return response()->json($data);
            }else{
                $data['pending_btc'] = 0;
                $data['status'] = 0;
                return response()->json($data);
            }
        }else if ($invoice_pending->exists()) {
            $pending_btc = $invoice->invoice_pending_payment()->get()->sum('value');
            $data['pending_btc'] = $pending_btc;
            $data['status'] = 0;
            $data['paid_btc'] = 0;
            return response()->json($data);
        }else{
            $data['pending_btc'] = 0;
            $data['status'] = 2;
            $data['paid_btc'] = 0;
            return response()->json($data);
        }
    }

   
    public function clear_seesion(Request $request)
    {
        Session::forget(['payment_flag', 'post_home']);
        Session::save();
        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function more_view($id)
    {
        $lottery = Lottery::where('is_end', 1)->orderBy('created_at', 'desc');
        if ($lottery->exists() && ($id == 1 || $id == 2 || $id || 3)) {
            $usd = CustomHelper::get_usd();
            $lottery = $lottery->paginate(20);
            $id = $id;
            return view('more_view', compact('lottery', 'id', 'usd'));
        }else{
            return back();
        }
    }

    public function get_wallet_data()
    {
        $chart_end = Carbon::now();
        $chart_start = $chart_end->copy()->subDays(7);
        $period = CarbonPeriod::create($chart_start,$chart_end);
        $key_array = $btc_in =  $btc_out = array();
        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $key_display = $date->format('d/m/Y');
            array_push($key_array, $key_display);
            // $tweet = Tweet::where('date',$key)->get()->count();
            $in = Invoice::whereDate('updated_at', '<=', $key)->where('is_paid', 1)->get()->sum('price_in_bitcoin');
            $out = Payment::whereDate('updated_at', '<=',  $key)->where('hash_code', '!=', 'null')->sum('amount');
            array_push($btc_in, round($in - $out, 8));
            // array_push($btc_out,$out);
        }
        return response()->json([
            'btc_in' => $btc_in,
            // 'btc_out' => $btc_out,
            'key_display' => $key_array
        ]);
    }



    public function fake_data()
    {
        $faker = Faker::create();
        $fake_btc = 0.19;
        $time = strtotime('2019-11-21 05:00:00');
        $newformat = date('Y-m-d h:i:s',$time);
        foreach (range(1,3) as $value) {
            $user = User::create([
                'username' => strtolower($faker->unique()->firstName()),
                'email' => $faker->email,
                'password' => bcrypt('11111111'),
                'role_id' => 2,
            ]);
            $user->email_verified_at = $newformat;
            $user->created_at = $newformat;
            $user->updated_at = $newformat;
            $user->save();
        }
        $users = User::orderBy('created_at', 'asc')->get()->take(3);
        foreach(range(1,16) as $super_index){
            foreach ($users as $user) {
                
                $wallet_address = '14mQfhdhn5UVXViyz1fJNRbzMxJbLmXquA';
                $invoice_id = uniqid();
                $secret = md5(uniqid());
                $fake_btc += 0.01;
                $invoice = Invoice::create([
                    'user_id' => $user->id,
                    'secret' => $secret,
                    'my_invoice_id' => $invoice_id,
                    'price_in_bitcoin' => $fake_btc,
                    'price_in_usd' => 1400,
                    'number_of_ticket' => 5,
                    'wallet_address' => $wallet_address,
                    'address' => '17UTQtGB4aJDTojNcdvNktGFsargHUZvR5',
                    'is_paid' => 1,
                ]);
                $invoice->created_at = $newformat;
                $invoice->updated_at = $newformat;
                $invoice->save();
    
                InvoicePayment::create([
                    'transaction_hash' => 'a4c5aabf889f1f1228bbb445eee9bfe5723e98c3f4f598df1833c01a282e12d8',
                    'value' => $fake_btc,
                    'invoice_id' => $invoice->my_invoice_id,
                ]);
                // ------------------------------ Prize 1 ----------------------------------
                $tickets = Ticket::where('lottery_id', null)->orWhere('lottery_id', 0);
                $current_tickets = array();
                foreach (range(1,5) as $t_index){
                    mt_srand();
                    $current_tickets = $tickets->get()->pluck('number')->toArray();
                    do {
                        $random_number = mt_rand(1000000, 9999999);
                    } while (in_array($random_number, $current_tickets));
                    Ticket::create([
                        'invoice_id' => $invoice->my_invoice_id,
                        'number' => $random_number,
                        'user_id' => $invoice->user_id,
                    ]);
                    array_push($current_tickets, $random_number);
                }
    
            }
            $tickets = Ticket::whereNull('lottery_id')->orWhere('lottery_id', 0);
            $invoice_array = $tickets->get()->pluck('invoice_id')->toArray();
            $total_bitcoin = Invoice::whereIn('my_invoice_id', $invoice_array)->get()->sum('price_in_bitcoin');
            $lottery = Lottery::create([
                'date' => $newformat,
                'cost_of_ticket' => 280,
                'time_of_prize1' => '16:00',
                'time_of_prize2' => '17:00',
                'time_of_prize3' => '18:00',
            ]);
            $tickets->update([
                'lottery_id' => $lottery->id,            
            ]);
            $tickets = Ticket::where('lottery_id', $lottery->id);
            $ticket_number = $tickets->count();
            mt_srand();
            $random_number = mt_rand(1, $ticket_number);
            $temp_tickets = $tickets->get()->random($random_number);
            $prize1_ticket = $temp_tickets->random();
            // ---------------------------------------
            $prize1_ticket->is_win = 5;
            $prize1_ticket->save();
            $lottery->update([
                'win_of_prize1' => $prize1_ticket->id,
                'total_bitcoin' => $total_bitcoin
            ]);
    
            $payment = Payment::create([
                'ticket_id' => $prize1_ticket->id,
                'lottery_id' => $lottery->id,
                'prize_type' => '5',
                'amount' => $lottery->total_bitcoin * 0.05,
                'hash_code' => 'a4c5aabf889f1f1228bbb445eee9bfe5723e98c3f4f598df1833c01a282e12d8'
            ]);
            $payment->created_at = $newformat;
            $payment->updated_at = $newformat;
            $payment->save();
            // --------------------------------- Prize 2 ---------------------------------
            $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1);
            $ticket_number = $tickets->count();
            mt_srand();
            $random_number = mt_rand(1, $ticket_number);
            
            $temp_tickets = $tickets->get()->random($random_number);
            $prize2_ticket = $temp_tickets->random();
            // ---------------------------------------
            $prize2_ticket->is_win = 15;
            $prize2_ticket->save();
            $lottery->update([
                'win_of_prize2' => $prize2_ticket->id,
            ]);
            $payment = Payment::create([
                'ticket_id' => $prize2_ticket->id,
                'lottery_id' => $lottery->id,
                'prize_type' => '15',
                'amount' => $lottery->total_bitcoin * 0.15,
                'hash_code' => 'a4c5aabf889f1f1228bbb445eee9bfe5723e98c3f4f598df1833c01a282e12d8'
            ]);
            $payment->created_at = $newformat;
            $payment->updated_at = $newformat;
            $payment->save();
            // ------------------------ Prize 3 ----------------------------------
            $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1)->where('id', '!=', $lottery->win_of_prize2);
            $ticket_number = $tickets->count();
            mt_srand();
            $random_number = mt_rand(1, $ticket_number);
            $temp_tickets = $tickets->get()->random($random_number);
            $prize3_ticket = $temp_tickets->random();
            $prize3_ticket->is_win = 40;
            $prize3_ticket->save();
            $lottery->update([
                'win_of_prize3' => $prize3_ticket->id,
                'is_end' => 1,
                'is_paid' => 1
            ]);
            $lottery->created_at = $newformat;
            $lottery->updated_at = $newformat;
            $lottery->save();
            $payment = Payment::create([
                'ticket_id' => $prize3_ticket->id,
                'lottery_id' => $lottery->id,
                'prize_type' => '40',
                'amount' => $lottery->total_bitcoin * 0.4,
                'hash_code' => 'a4c5aabf889f1f1228bbb445eee9bfe5723e98c3f4f598df1833c01a282e12d8'
            ]);
            $payment->created_at = $newformat;
            $payment->updated_at = $newformat;
            $payment->save();

            $newformat = date('Y-m-d h:i:s', strtotime($newformat . ' +1 day'));
        }
        echo 'Success';
    }
}
