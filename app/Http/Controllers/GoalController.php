<?php

namespace App\Http\Controllers;

use App\Account;
use App\Goal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class GoalController extends Controller
{

    private $add_goal_form = "goal.add_goal";

    private $completed_goals = "goal.completed";

    private $incompleted_goals = "goal.incomplete";


    public function showAddGoalForm()
    {

//        $accounts = User::where('id',Auth::user()->getAuthIdentifier())->accounts();
        $accounts = Auth::user()->accounts->all();
//        var_dump($accounts);
        return View::make($this->add_goal_form)->with("accounts",$accounts);

    }

    public function showCompletedGoals(){
        $goals_waith_accounts = Goal::with("account")
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where("state","success")
            ->orderBy("updated_at","DESC")
            ->get()->all();
//        var_dump($goals_waith_accounts[0]);
        return View::make($this->completed_goals)->with('goals',$goals_waith_accounts);
    }

    public function showIncompleteGoals(){
        $goals_waith_accounts = Goal::with("account")
            ->where('user_id', Auth::user()->getAuthIdentifier())
            ->where("state","created")
            ->orderBy("updated_at","DESC")
            ->get()->all();
//        var_dump($goals_waith_accounts[0]);
        return View::make($this->incompleted_goals)->with('goals',$goals_waith_accounts);
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
            'goal_name' => ['required', 'string', 'max:255','unique:goals'],
            'account_id' => ['required', 'exists:accounts,id'],
            'target_value' => ['required', 'numeric'],

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
        return Goal::create([
            'goal_name' => $data['goal_name'],
            'account_id' => $data['account_id'],
            'user_id'      => Auth::user()->getAuthIdentifier(),
            'state'        => "created",
            'notified'     => false,
            'target_value' => $data['target_value'],
        ]);
    }

    /**
     * Handle a add account request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addGoal(Request $request)
    {
        Log::debug("Add Goal method");
        $this->validator($request->all())->validate();

        $goal = $this->create($request->all());

        Log::debug($goal);
        return $this->showAddGoalForm()->with("goal",$goal);
    }
}
