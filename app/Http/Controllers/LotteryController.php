<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

use Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Lottery;
use App\Payment;
use CustomHelper;
use App\Ticket;
use App\Setting;

class LotteryController extends Controller
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

    private function dataLog($content) {
        $filename = storage_path() . '/datalogs/datalogs.log';
        
        if ($handle = fopen($filename, 'a')) {
            if (fwrite($handle, $content . " \n") === FALSE) {
                return FALSE;
            }
            fclose($handle);
            return TRUE;
        }

        return FALSE;
    }

    public function lottery_manage(Request $request)
    {
        session(['page' => 'lottery_manage']);
        if ($request->has('pagesize')) {
            $this->pagesize = $request->get('pagesize');
            if($this->pagesize == 'all'){
                $this->pagesize = Lottery::all()->count();
            }
        }
        $usd = CustomHelper::get_usd();
        $pagesize = $this->pagesize;
        $lottery = Lottery::with(['tickets'])->where('is_end', 1)->orderBy('created_at', 'desc')->paginate($pagesize);
        return view('admin.lottery', compact('lottery', 'pagesize', 'usd'));
        
    }

    public function lottery_detail($id)
    {
        $usd = CustomHelper::get_usd();
        $lottery = Lottery::find($id);
        return view('admin.lottery_detail', compact('lottery', 'usd'));
    }

    private function lottery_start_email($name, $email, $prize) {
        $data = array('name'=>$name, 'prize'=>$prize);
        Mail::send('emails.lottery_start', $data, function($message) use($email, $name) {
           $message->to($email, $name)->subject('New Lottery Start');
        });
     }

    public function lottery_prize1()
    {
        $setting = Setting::first();
        $tickets = Ticket::whereNull('lottery_id')->orWhere('lottery_id', 0);
        // $tickets = Ticket::where('lottery_id', 1);
        if ($tickets->exists()) {
            $invoice_array = $tickets->get()->pluck('invoice_id')->toArray();
            $total_bitcoin = Invoice::whereIn('my_invoice_id', $invoice_array)->get()->sum('price_in_bitcoin');
            // $total_bitcoin = $tickets->count() * $setting->cost_of_ticket;
            $min_of_btc = $setting->min_of_btc;
            if ($total_bitcoin < $min_of_btc) {
                // $this->dataLog('hey not ready');
                $setting->is_ready1 = 1;
                $setting->save();
                return;
            }
            $now = date('Y-m-d H:i:s');
            $result = "Let's start today lottery prize 1 " . " --- " . $now;
            // $this->dataLog($result);
            
            if (!$setting) {
                $result = 'You have to set time and cost.' . ' -- ' . $now;
                // $this->dataLog($result);
                return $result;
            }
            $lottery = Lottery::create([
                'date' => date('Y-m-d'),
                'cost_of_ticket' => $setting->cost_of_ticket,
                'time_of_prize1' => $setting->time_of_prize1,
                'time_of_prize2' => $setting->time_of_prize2,
                'time_of_prize3' => $setting->time_of_prize3,
            ]);
            // $tickets = Ticket::where('lottery_id', 1);
            if (!$tickets->exists()) {
                $result = 'There are not any tickets.' . ' -- ' . $now;
                // $this->dataLog($result);
                return $result;
            }
            // $total_bitcoin = $tickets->count() * $setting->cost_of_ticket;
            $tickets->update([
                'lottery_id' => $lottery->id,            
            ]);
    
            $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
            foreach ($users as $user) {
                if($user->email_verified_at != null){
                    $this->lottery_start_email($user->username, $user->email, 'prize1');
                }
            }
            $tickets = Ticket::where('lottery_id', $lottery->id);
            // ------ Win Ticket algothrism ---------   
            $ticket_number = $tickets->count();
            if ($ticket_number == 1) {
                $result = 'There is only one ticket.' . ' -- ' . $now;
                // $this->dataLog($result);
                return $result;
            }
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
            $result = 'The winner of prize1 is => ' . $prize1_ticket->number . ' -- ' . $now;
            
            Payment::create([
                'ticket_id' => $prize1_ticket->id,
                'lottery_id' => $lottery->id,
                'prize_type' => '5',
                'amount' => $lottery->total_bitcoin * 0.05,
            ]);
            if ($setting->is_ready1) {
                $setting->is_ready1 = 0;
                $setting->is_ready2 = 1;
                $setting->save();
            }
            
    
            $ticket = Ticket::find($prize1_ticket->id);
            $winner_email = $ticket->user->email;
            $winner_name = $ticket->user->name;
            $data = array('name'=>$winner_name, 'prize'=>'prize1', 'amount_bit'=>$total_bitcoin * 0.05);
            Mail::send('emails.winner', $data, function($message) use($winner_email, $winner_name) {
               $message->to($winner_email, $winner_name)->subject('You are winner.');
            });
            return $result;
            
        }
    }

    public function lottery_prize2()
    {
        $setting = Setting::first();
        $now = date('Y-m-d H:i:s');
        $result = "Let's start today lottery prize 2 " . " --- " . $now;
        // $this->dataLog($result);
        $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 0)->orderBy('created_at', 'desc')->first();
        $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
        foreach ($users as $user) {
            // $this->dataLog($user->email . '  email sent');
            if($user->email_verified_at != null){
                $this->lottery_start_email($user->username, $user->email, 'prize2');
            }
        }

        $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1);
        
        // ------ Win Ticket algothrism ---------   
        $ticket_number = $tickets->count();
        // $this->dataLog($ticket_number);
        if ($ticket_number == 1) {
            $result = 'There is only one ticket.' . ' -- ' . $now;
            // $this->dataLog($result);
            return $result;
        }
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
        $result = 'The winner of prize1 is => ' . $prize2_ticket->number . ' -- ' . $now;
        // $this->dataLog($result);
        Payment::create([
            'ticket_id' => $prize2_ticket->id,
            'lottery_id' => $lottery->id,
            'prize_type' => '15',
            'amount' => $lottery->total_bitcoin * 0.15,
        ]);
        
        if ($setting->is_ready2) {
            $setting->is_ready2 = 0;
            $setting->is_ready3 = 1;
            $setting->save();
        }
        
        
        $ticket = Ticket::find($prize2_ticket->id);
        $winner_email = $ticket->user->email;
        $winner_name = $ticket->user->name;
        $data = array('name'=>$winner_name, 'prize'=>'prize2', 'amount_bit'=>$lottery->total_bitcoin * 0.15);
        Mail::send('emails.winner', $data, function($message) use($winner_email, $winner_name) {
           $message->to($winner_email, $winner_name)->subject('You are winner.');
        });
        return $result;
    }

    public function lottery_prize3()
    {
        $setting = Setting::first();
        $now = date('Y-m-d H:i:s');
        $result = "Let's start today lottery prize 3 " . " --- " . $now;
        // $this->dataLog($result);
        $now = date('Y-m-d H:i:s');
        $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 0)->orderBy('created_at', 'desc')->first();
        $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
        foreach ($users as $user) {
            if($user->email_verified_at != null){
                $this->lottery_start_email($user->username, $user->email, 'prize3');
            }
        }

        $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1)->where('id', '!=', $lottery->win_of_prize2);

        // ------ Win Ticket algothrism ---------   
        $ticket_number = $tickets->count();
        if ($ticket_number == 1) {
            $result = 'There is only one ticket.' . ' -- ' . $now;
            // $this->dataLog($result);
            return $result;
        }
        mt_srand();
        $random_number = mt_rand(1, $ticket_number);
        $temp_tickets = $tickets->get()->random($random_number);
        $prize3_ticket = $temp_tickets->random();
        // ---------------------------------------
        $prize3_ticket->is_win = 40;
        $prize3_ticket->save();
        $lottery->update([
            'win_of_prize3' => $prize3_ticket->id,
            'is_end' => 1,
        ]);
        $result = 'The winner of prize3 is => ' . $prize3_ticket->number . ' -- ' . $now;
        // $this->dataLog($result);

        Payment::create([
            'ticket_id' => $prize3_ticket->id,
            'lottery_id' => $lottery->id,
            'prize_type' => '40',
            'amount' => $lottery->total_bitcoin * 0.4,
        ]);

        if ($setting->is_ready3) {
            $setting->is_ready3 = 0;
            $setting->save();
        }
        

        $ticket = Ticket::find($prize3_ticket->id);
        $winner_email = $ticket->user->email;
        $winner_name = $ticket->user->name;
        $data = array('name'=>$winner_name, 'prize'=>'prize3', 'amount_bit'=>$lottery->total_bitcoin * 0.4);
        Mail::send('emails.winner', $data, function($message) use($winner_email, $winner_name) {
           $message->to($winner_email, $winner_name)->subject('You are winner.');
        });
        return $result;
    }

    public function lottery_delete($id)
    {
        if (Lottery::find($id)) {
            Lottery::find($id)->delete();
            return back()->withSuccess('Deleted successfully.');
        }
    }

    public function win_payment(Request $request)
    {
        $request->validate([
            'hash_code' => 'required',
        ]);
        
        $hash_code = $request->get('hash_code');
        $lottery_id = $request->get('lottery_id');
        $prize_type = $request->get('prize_type');
        $payment = Payment::where('lottery_id', $lottery_id)->where('prize_type', $prize_type)->first();
        $payment->hash_code = $hash_code;
        $payment->save();

        $user = $payment->ticket->user;
        $winner_name = $user->name;
        $winner_email = $user->email;
        $amount = $payment->amount;
        $wallet = $payment->ticket->invoice->wallet_address;
        $data = array('name'=>$winner_name, 'prize'=>$prize_type, 'hash_code' =>$hash_code, 'amount'=>$amount, 'wallet'=>$wallet);
        Mail::send('emails.paid', $data, function($message) use($winner_email, $winner_name) {
           $message->to($winner_email, $winner_name)->subject('We paid for you.');
        });

        $flag = 0;
        $payments = Payment::where('lottery_id', $lottery_id)->get();
        foreach ($payments as $payment) {
            if ($payment->hash_code == null) {
                $flag = 1;
            }
        }
        if (!$flag) {
            $lottery = Lottery::find($lottery_id);
            $lottery->is_paid = 1;
            $lottery->save();
        }
        return back();

    }


    
}
