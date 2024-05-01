<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Camps;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\Checkout\Store;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\Checkout\AfterCheckout;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Camps $camp, Request $request)
    {
        if ($camp->isRegistered) {
            $request->session()->flash('error', "You already registered on {$camp->title} camp.");
            return redirect(route('user.dashboard'));
        }
        return view('checkout.create', [
            'camp' => $camp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request, Camps $camp)
    {
        // mapping request data
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camp->id;

        // update user data
        // $user = User::findOrFail(Auth::id());
        // $user->email = $data['email'];
        // $user->name = $data['name'];
        // $user->ocupation = $data['ocupation'];
        // $user->save();
        // update user data
        $user = User::findOrFail(Auth::id());
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->ocupation = $data['ocupation'];
        $user->save();

        return view($user);

        // create checkout
        // $checkout = Checkout::create($data);
        // $checkout->headers->set('Accept', 'application/json');
        // // sending email
        // Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        // return redirect(route('checkout.success'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
    public function success()
    {
        return view('checkout.success');
    }

    public function invoice(Checkout $checkout)
    {
        return $checkout;
    }

    
}
