<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Seller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'web_store_name' => ['required', 'string', 'max:255'],
            'seller_name' => ['required', 'string', 'max:255'],
            'seller_tp_1' => ['required', 'string', 'size:10'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'payment_period' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'branch_name' => ['required', 'string', 'max:255'],
            'account_no' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * //     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::transaction(function () use ($data) {

            $user = User::create([
                'name' => $data['web_store_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $seller = Seller::create([
                'seller_name' => $data['seller_name'],
                'seller_tp_1' => $data['seller_tp_1'],
                'address_line_1' => $data['address_line_1'],
                'city_id' => $data['city_id'],
                'district_id' => $data['district_id'],
                'payment_period' => $data['payment_period'],
                'user_id' => $user->id
            ]);

            Bank::create([
                'bank_name' => $data['bank_name'],
                'branch_name' => $data['branch_name'],
                'account_no' => $data['account_no'],
                'seller_id' => $seller->seller_id
            ]);

            $user->assignRole('Seller');

        });
    }
}
