<?php

namespace App\Http\Controllers;

use App\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SummaryController extends Controller
{
    //

    private $transaction_summary_page = "summary.transaction_summary";
    private $monthToMonthName = ["","Jan", "Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];

    public function showTransactionSummaryForm()
    {

//        $accounts = User::where('id',Auth::user()->getAuthIdentifier())->accounts();
        $accounts = Auth::user()->accounts->all();
//        var_dump($accounts);
        return View::make($this->transaction_summary_page)->with("accounts",$accounts);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'account_id' => ['required', 'exists:accounts,id'],
            'start_month'       => ['date'],
            'end_month' => ['date'],

        ]);
    }

    public function transactionSummary(Request $request)
    {
        $this->validator($request->all())->validate();

        $balances = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as balance, MONTH(effective_date) as month, YEAR(effective_date) as year'))
            ->where('account_id',$request['account_id'])
            ->whereDate('effective_date','>=',$request['start_month'])
            ->whereDate('effective_date','<', date(strval($request['end_month'])))
            ->groupBy(DB::raw('YEAR(effective_date) , MONTH(effective_date)'))
            ->get()->all();
        $expenses = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as balance, MONTH(effective_date) as month, YEAR(effective_date) as year'))
            ->where('account_id',$request['account_id'])
            ->whereDate('effective_date','>=',date(strval($request['start_month'])))
            ->whereDate('effective_date','<', date(strval($request['end_month'])))
            ->where('type','expense')
            ->groupBy(DB::raw('YEAR(effective_date) , MONTH(effective_date)'))
            ->get()->all();
        $incomes = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as balance, MONTH(effective_date) as month, YEAR(effective_date) as year'))
            ->where('account_id',$request['account_id'])
            ->whereDate('effective_date','>=',date(strval($request['start_month'])))
            ->whereDate('effective_date','<', date(strval($request['end_month'])))
            ->where('type','income')
            ->groupBy(DB::raw('YEAR(effective_date) , MONTH(effective_date)'))
            ->get()->all();
        $months = array();
        $balance_progress = array();
        $total_bal = 0;

        $income_values = array();
        $expense_values = array();

        foreach ($balances as $balance){
            array_push($months,$this->monthToMonthName[$balance->month]."-".strval($balance->year));
            $total_bal += $balance->balance;
            array_push($balance_progress, $total_bal);
        }

        $lastIncomeIndex = 0;
        $lastExpenseIndex = 0;
        $months_size = sizeof($months);
        $incomes_size = sizeof($incomes);
        $expenses_size = sizeof($expenses);
        for ($i=0; $i< $months_size; $i++){
            $balance = $balances[$i];

            $found_income = false;
            for ($j=$lastIncomeIndex; $j<$incomes_size; $j++){

                if(strcmp(strval($balance->month).strval($balance->year),strval($incomes[$j]->month).strval($incomes[$j]->year)) == 0){
                    array_push($income_values,$incomes[$j]->balance);
                    $lastIncomeIndex = $j;
                    $found_income = true;
                    break;
                }
            }
            if(!$found_income){
                array_push($income_values,0);
            }

            $found_expense = false;
            for ($k=$lastExpenseIndex; $k<$expenses_size; $k++){

                if(strcmp(strval($balance->month).strval($balance->year),strval($expenses[$k]->month).strval($expenses[$k]->year)) == 0){
                    array_push($expense_values,$expenses[$k]->balance);
                    $lastExpenseIndex = $k;
                    $found_expense = true;
                    break;
                }
            }
            if(!$found_expense){
                array_push($expense_values,0);
            }
        }

        $account = Account::where('id',1)->get()->all()[0];
        return $this->showTransactionSummaryForm()->with('balances',$balance_progress)
            ->with('incomes',$income_values)
            ->with('expenses',$expense_values)
            ->with('labels', $months)
            ->with('available_balance',$total_bal)
            ->with('summary_account',$account);

    }


}
