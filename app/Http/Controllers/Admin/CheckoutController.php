<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Mail;
use App\Mail\Checkout\Paid;

class CheckoutController extends Controller
{
    function update(Request $request, Checkout $checkout) 
    {
        $checkout->is_paid = true;
        $checkout->save();
        Mail::to($checkout->User->email)->send(new Paid($checkout));
        $request->session()->flash('success', "Checkout with ID {$checkout->id} has been updated!");
        return redirect(route('admin.dashboard'));
    }
}
