<?php

namespace App\Http\Controllers;

use App\Account;
use App\Goal;
use App\Mail\GoalReached;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class TransactionController extends Controller
{
    private $add_transaction_form = "transaction.add_transaction";

    private $view_transaction = "transaction.view_transaction";

    public function showAddTransactionForm()
    {

//        $accounts = User::where('id',Auth::user()->getAuthIdentifier())->accounts();
        $accounts = Auth::user()->accounts->all();
//        var_dump($accounts);
        return View::make($this->add_transaction_form)->with("accounts",$accounts);

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
            'trans_desc' => ['required', 'string', 'max:255'],
            'type'       => [Rule::in(['income','expense'])],
            'account_id' => ['required', 'exists:accounts,id'],
            'amount' => ['required', 'numeric'],
            'effective_date' => ['required','date']
        ]);
    }

    /**
     * Create a new Transaction instance .
     *
     * @param  array  $data
     * @return \App\Transaction
     */
    protected function create(array $data)
    {
        $amount = 0;
        if (strcmp($data['type'],"income") == 0){
            $amount = abs($data['amount']);
        }
        elseif (strcmp($data['type'],"expense") == 0){
            $amount = -abs($data['amount']);
        }
        return Transaction::create([
            'trans_desc' => $data['trans_desc'],
            'type'       => $data['type'],
            'effective_date'=> date($data['effective_date']),
            'account_id' => $data['account_id'],
            'user_id'      => Auth::user()->getAuthIdentifier(),
            'amount'        => abs($data['amount']),
        ]);
    }

    protected function updateAccount(array $data){
        $account = Account::where("id",$data['account_id'])->get()[0];
        if (strcmp($data['type'],"income") == 0){
            $account->balance = ($account->balance + $data['amount']);
        }
        elseif (strcmp($data['type'],"expense") == 0){
            $account->balance = ($account->balance - $data['amount']);
        }

        $account->save();

        return $account;

    }

    protected function checkGoalNotification(Request $request){

        $data = $request->all();
        $account = Account::where("id",$data['account_id'])->get()[0];
        $goals = Goal::where('account_id',$data['account_id'])
            ->where('target_value',"<=", $account->balance)
            ->where('notified',"!=",true)
            ->get()->all();

        $goalsarr = array();

        foreach ($goals as $goal){
            $goal->notified = true;
            array_push($goalsarr, $goal->goal_name);
            $goal->save();

        }
        if(sizeof($goals) > 0){
            Mail::to($request->user())->send(new GoalReached($goalsarr,route('incompleteGoals')));
        }
    }
    /**
     * Handle a add account request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addTransaction(Request $request)
    {
        Log::debug("Add Goal method");
        $this->validator($request->all())->validate();

        $transaction = $this->create($request->all());

        $updated_account = $this->updateAccount($request->all());
        $this->checkGoalNotification($request);

        Log::debug($transaction);
        return $this->showAddTransactionForm()->with("transaction",$transaction)->with('updated_account',$updated_account);
    }


    public function showTransactions(){

        $user_id = Auth::user()->getAuthIdentifier();
        $transactions_db = Transaction::with('account')->where('user_id',$user_id)->get()->all();

        $transactions = array();
        foreach ($transactions_db as $transaction){
            $trans_obj = array(
                'trans_desc' => $transaction->trans_desc,
                'type' => $transaction->type,
                'effective_date' => $transaction->effective_date,
                'amount' => $transaction->amount,
                'account_name' => $transaction->account["account_name"],
                'transaction_id' => $transaction->id,
                'account_id' =>$transaction->account_id

            );

            array_push($transactions, $trans_obj);

        }
//        var_dump($transactions);


        return View::make($this->view_transaction)->with("transactions",$transactions);
    }

    public function editTransactions(Request $request){
        $this->validator($request->all())->validate();


        $transaction = Transaction::where("id",$request["transaction_id"])->first();
        $account = Account::where("id",$request["account_id"])->first();

        if (strcmp($transaction["type"],"income") ==0 and strcmp($request["type"],"income") ==0){
            $account->balance = $account->balance - $transaction->amount + abs($request["amount"]);
        }
        else if (strcmp($transaction["type"],"income") ==0 and strcmp($request["type"],"expense") ==0){
            $account->balance = $account->balance - $transaction->amount - abs($request["amount"]);
        }
        else if (strcmp($transaction["type"],"expense") ==0 and strcmp($request["type"],"income") ==0){
            $account->balance = $account->balance + $transaction->amount + abs($request["amount"]);
        }
        else if (strcmp($transaction["type"],"expense") ==0 and strcmp($request["type"],"expense") ==0){
            $account->balance = $account->balance + $transaction->amount - abs($request["amount"]);
        }

        $account->save();

        $transaction->amount = $request["amount"];
        $transaction->trans_desc = $request["trans_desc"];
        $transaction->type = $request["type"];
        $transaction->effective_date = $request["effective_date"];

        $transaction->save();

//        var_dump($transaction);
        return redirect(route("viewTransactions"));

    }

    public function deleteTransactions(Request $request){
//        $this->validator($request->all())->validate();


        $transaction = Transaction::find($request["transaction_id"]);
        var_dump($transaction);
        $account = Account::where("id",$request["account_id"])->first();

        if (strcmp($transaction["type"],"income") ==0){
            $account->balance = $account->balance - $transaction->amount;
        }
        else if (strcmp($transaction["type"],"expense") ==0){
            $account->balance = $account->balance + $transaction->amount;
        }

        $account->save();

        $transaction->delete();

//        var_dump($transaction);
        return redirect(route("viewTransactions"));

    }
}
