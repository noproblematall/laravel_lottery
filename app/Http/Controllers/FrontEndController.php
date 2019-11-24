<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Invoice;
use App\Setting;
use App\InvoicePayment;
use App\InvoicePendingPayment;
use App\Ticket;
use App\Lottery;
use CustomHelper;

use Auth;

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
        $today_bitcoin = 0;
        $next_time = Setting::first()->time_of_prize1;
        $bit_per_ticket = Setting::first()->cost_of_ticket;
        $current_lottery = Lottery::where('is_end', 0);
        if ($current_lottery->exists()) {
            $today_bitcoin = $current_lottery->first()->total_bitcoin;
            if ($current_lottery->first()->time_of_prize2 == null) {
                $next_time = $current_lottery->first()->time_of_prize2;
            } else {
                $current_lottery->first()->time_of_prize3;
            }
            
        }else{
            $current_tickets = Ticket::whereNull('lottery_id');
            if ($current_tickets->exists()) {
                $today_bitcoin = $bit_per_ticket * $current_tickets->count();
            }
        }

        $last_lottery = Lottery::where('is_end', 1)->orderBy('created_at', 'desc');
        // $last_bitcoin = $last_lottery->total_bitcoin;
        if (Lottery::where('is_end', 1)->orderBy('created_at', 'desc')->exists()) {
            $last_four_lottery = Lottery::where('is_end', 1)->orderBy('created_at', 'desc')->get()->take(4);
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

        return view('welcome', compact('usd', 'today_bitcoin', 'next_time', 'last_lottery', 'last_four_lottery', 'sent_sum', 'prize_number'));
    }    
    
    public function post_home(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'wallet_address' => 'required',
            'bit_number' => 'required'
        ]);

        $data = $request->all();
        $email = $data['email'];

        $amount = $data['bit_number'] * Setting::first()->cost_of_ticket;
        $wallet_address = $data['wallet_address'];
        $invoice_id = uniqid();
        $secret = md5(uniqid());
        $invoice = Invoice::create([
            'secret' => $secret,
            'my_invoice_id' => $invoice_id,
            'price_in_bitcoin' => $amount,
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
    
                for ($i=0; $i < $invoice->number_of_ticket; $i++) {
    
                    mt_srand();
                    $random_number = mt_rand(1000000, 9999999);
                    
                    Ticket::create([
                        'invoice_id' => $invoice->my_invoice_id,
                        'number' => $random_number,
                        'user_id' => $invoice->user_id,
                    ]);
                }
            }


            // $temp_address = TempAddress::where('invoice_id', $invoice_id);
            // if ($temp_address->exists()) {
            //     $temp_address->delete();
            // }
            
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
}
