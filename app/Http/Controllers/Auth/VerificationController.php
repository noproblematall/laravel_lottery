<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Invoice;
use stdClass;
use Mail;
use App\Helper\CustomHelper;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }else{
            $user = Auth::user();
            $payment_flag = session('payment_flag');
            if ($payment_flag) {
                $data = session('post_home');
                $invoice_id = $data['invoice_id'];
                $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
                $usd = CustomHelper::get_usd();
                $btc = 1/$usd;
                $amount_usd = $invoice->price_in_usd;
                $amount = round($amount_usd * $btc, 8);
                $invoice->price_in_bitcoin = $amount;
                $invoice->save();
                $response = $this->payment($data);
                if (property_exists($response, 'message')) {
                    session()->forget('visit_flag');
                    return view('auth.verify', compact('response'));
                }else{
                    $address = $response->address;
                    return view('auth.email_payment', compact('address', 'invoice_id', 'amount', 'amount_usd'));
                }
            } else if($user->invoices()->exists()){
                if (($user->invoices()->orderBy('created_at', 'desc')->first()->address != null && $user->invoices()->orderBy('created_at', 'desc')->first()->is_paid == 0)) {
                    $usd = CustomHelper::get_usd();
                    $btc = 1/$usd;
                    $invoice_id = $user->invoices()->orderBy('created_at', 'desc')->first()->my_invoice_id;
                    $amount_usd = $user->invoices()->orderBy('created_at', 'desc')->first()->price_in_usd;
                    $amount = round($amount_usd * $btc, 8);
                    $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
                    $invoice->price_in_bitcoin = $amount;
                    $invoice->save();
                    $address = $user->invoices()->orderBy('created_at', 'desc')->first()->address;
                    return view('auth.email_payment', compact('address', 'invoice_id', 'amount', 'amount_usd'));                    
                }else{
                    return view('auth.verify');
                }
            }else {
                return view('auth.verify');
            }
        }
        
    }

    private function payment($data) {
        $invoice_id = $data['invoice_id'];
        $invoice = Invoice::where('my_invoice_id', $invoice_id)->first();
        $secret = $invoice->secret;
        if($invoice->address != null && $invoice->is_paid == 0){
            $address = $invoice->address;
            $response = new stdClass();
            $response->address = $address;
            return $response;
        }
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
            if (property_exists($response, 'message')) {
                return $response;
            }else{
                $user = Auth::user();
                $email = $user->email;
                $name = $user->username;
                $data = array('email'=>$email, 'name'=>$name, 'invoice_id'=>$invoice_id, 'number_of_ticket'=>$invoice->number_of_ticket, 'price_in_bitcoin'=>$invoice->price_in_bitcoin, 'address'=>$response->address);
                    Mail::send('emails.order', $data, function($message) use($email, $name) {
                    $message->to($email, $name)->subject('New Order');
                });

                $invoice->update([
                    'address' => $response->address,
                    'user_id' => Auth::id(),
                ]);
                
                return $response;
            }
        }
    }   
}
