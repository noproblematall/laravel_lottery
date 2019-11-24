<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Lottery;
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
        //    $message->from('xyz@gmail.com','Virat Gandhi');
        });
     }

    public function lottery_prize1()
    {
        $now = date('Y-m-d H:i:s');
        $result = "Let's start today lottery prize 1 " . " --- " . $now;
        $this->dataLog($result);
        $setting = Setting::first();
        if (!$setting) {
            $result = 'You have to set time and cost.' . ' -- ' . $now;
            $this->dataLog($result);
            return $result;
        }
        $lottery = Lottery::create([
            'date' => date('Y-m-d'),
            'cost_of_ticket' => $setting->cost_of_ticket,
            'time_of_prize1' => $setting->time_of_prize1,
            'time_of_prize2' => $setting->time_of_prize2,
            'time_of_prize3' => $setting->time_of_prize3,
        ]);
        $tickets = Ticket::where('lottery_id', 1);
        // $tickets = Ticket::whereNull('lottery_id');
        if (!$tickets->exists()) {
            $result = 'There are not any tickets.' . ' -- ' . $now;
            $this->dataLog($result);
            return $result;
        }
        $total_bitcoin = $tickets->count() * $setting->cost_of_ticket;
        $tickets->update([
            'lottery_id' => $lottery->id,            
        ]);

        $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
        foreach ($users as $user) {
            $this->lottery_start_email($user->username, $user->email, 'prize1');
        }
        $tickets = Ticket::where('lottery_id', $lottery->id);
        // ------ Win Ticket algothrism ---------   
        $ticket_number = $tickets->count();
        if ($ticket_number == 1) {
            $result = 'There is only one ticket.' . ' -- ' . $now;
            $this->dataLog($result);
            return $result;
        }
        mt_srand();
        $random_number = mt_rand(1, $ticket_number);
        $temp_tickets = $tickets->get()->random($random_number);
        $prize1_ticket = $temp_tickets->random();
        // ---------------------------------------

        $lottery->update([
            'win_of_prize1' => $prize1_ticket->id,
            'total_bitcoin' => $total_bitcoin
        ]);
        $result = 'The winner of prize1 is => ' . $prize1_ticket->number . ' -- ' . $now;
        $this->dataLog($result);
        return $result;
    }

    public function lottery_prize2()
    {
        $now = date('Y-m-d H:i:s');
        $result = "Let's start today lottery prize 2 " . " --- " . $now;
        $this->dataLog($result);
        $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 0)->first();
        $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
        foreach ($users as $user) {
            $this->dataLog($user->email . '  email sent');
            $this->lottery_start_email($user->username, $user->email, 'prize2');
        }

        $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1);
        
        // ------ Win Ticket algothrism ---------   
        $ticket_number = $tickets->count();
        $this->dataLog($ticket_number);
        if ($ticket_number == 1) {
            $result = 'There is only one ticket.' . ' -- ' . $now;
            $this->dataLog($result);
            return $result;
        }
        mt_srand();
        $random_number = mt_rand(1, $ticket_number);
        
        $temp_tickets = $tickets->get()->random($random_number);
        $prize2_ticket = $temp_tickets->random();
        // ---------------------------------------
        $lottery->update([
            'win_of_prize2' => $prize2_ticket->id,
        ]);
        $result = 'The winner of prize1 is => ' . $prize2_ticket->number . ' -- ' . $now;
        $this->dataLog($result);
        return $result;
    }

    public function lottery_prize3()
    {
        $now = date('Y-m-d H:i:s');
        $result = "Let's start today lottery prize 3 " . " --- " . $now;
        $this->dataLog($result);
        $now = date('Y-m-d H:i:s');
        $lottery = Lottery::whereDate('created_at', '=', date('Y-m-d'))->where('is_end', 0)->first();
        $users = User::where('role_id', 2)->whereNotNull('email_verified_at')->get();
        foreach ($users as $user) {
            $this->lottery_start_email($user->username, $user->email, 'prize3');
        }

        $tickets = Ticket::where('lottery_id', $lottery->id)->where('id', '!=', $lottery->win_of_prize1)->where('id', '!=', $lottery->win_of_prize2);

        // ------ Win Ticket algothrism ---------   
        $ticket_number = $tickets->count();
        if ($ticket_number == 1) {
            $result = 'There is only one ticket.' . ' -- ' . $now;
            $this->dataLog($result);
            return $result;
        }
        mt_srand();
        $random_number = mt_rand(1, $ticket_number);
        $temp_tickets = $tickets->get()->random($random_number);
        $prize3_ticket = $temp_tickets->random();
        // ---------------------------------------
        $lottery->update([
            'win_of_prize3' => $prize3_ticket->id,
            'is_end' => 1,
        ]);
        $result = 'The winner of prize3 is => ' . $prize3_ticket->number . ' -- ' . $now;
        $this->dataLog($result);
        return $result;
    }

    public function lottery_delete($id)
    {
        if (Lottery::find($id)) {
            Lottery::find($id)->delete();
            return back()->withSuccess('Deleted successfully.');
        }
    }

    // public function lottery_new()
    // {
    //     return view('admin.lottery_new');
    // }

    // public function lottery_create(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required',
    //         'time_of_prize1' => 'required',
    //         'time_of_prize2' => 'required',
    //         'time_of_prize3' => 'required',
    //         'cost_of_ticket' => 'required',
    //     ]);

    //     $data = $request->all();
    //     Lottery::create($data);
    //     return back()->withSuccess('Created successfully.');
    // }

    // public function lottery_update(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required',
    //         'time_of_prize1' => 'required',
    //         'time_of_prize2' => 'required',
    //         'time_of_prize3' => 'required',
    //         'cost_of_ticket' => 'required',
    //     ]);

    //     $data = $request->all();
    //     unset($data['_token']);
    //     unset($data['id']);
    //     Lottery::where('id', $request->id)->update($data);
    //     return back()->withSuccess('Updated successfully.');
    // }

    // public function lottery_edit($id)
    // {
    //     $lottery = Lottery::find($id);
    //     return view('admin.lottery_edit', compact('lottery'));
    // }

    
}
