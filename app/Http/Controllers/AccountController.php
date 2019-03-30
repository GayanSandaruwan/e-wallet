<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;


class AccountController extends Controller
{
    //

    private $add_account_form = "account.add_account";

    public function showAddAccountForm()
    {
        return view($this->add_account_form);
    }


    /**
     * Get a validator for an incoming add account request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'account_name' => ['required', 'string', 'max:255','unique:accounts'],
            'account_desc' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new Account instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Account
     */
    protected function create(array $data)
    {
        return Account::create([
            'account_name' => $data['account_name'],
            'account_desc' => $data['account_desc'],
            'user_id'      => Auth::user()->getAuthIdentifier(),
            'state'        => true,
        ]);
    }

    /**
     * Handle a add account request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addAccount(Request $request)
    {
        Log::debug("Add Account method");
        $this->validator($request->all())->validate();

        $account = $this->create($request->all());

        Log::debug($account);
        return View::make($this->add_account_form)->with("account",$account);
    }

}
