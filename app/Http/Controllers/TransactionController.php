<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public  function index()
    {
        $transactions = Transaction::query()->where('user_id',Auth::id())->paginate();
        $wallet = Wallet::query()->where('user_id',Auth::id())->first();
        return view('transactions.index')
            ->with(['data'=>$transactions,'wallet'=>$wallet]);
    }
    public function create()
    {
        $category = Category::query()->where('user_id',Auth::id())->orWhere('user_id',null)->get();
        return view('transactions.forms.create')
            ->with(['category'=>$category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'amount'=>'required',
            'note'=>'required',
        ]);
        $transaction =  Transaction::query();

        $category = Category::find($request->category_id);

        $wallet = Wallet::where('user_id',Auth::id());
        if (count($wallet->get())>0)
        {
            if ($category->type == '0')
            {
                $transaction->create([
                    'category_id' => $request->category_id,
                    'amount' => $request->amount,
                    'note'=>$request->note,
                    'user_id' => Auth::id(),
                ]);

                $wallet_income = $wallet->first()->total_income + $request->amount;
                $wallet_balance = $wallet->first()->wallet_balance + $request->amount;


                $wallet->update([
                    'total_income'=>$wallet_income,
                    'wallet_balance'=>$wallet_balance,

                ]);
                return redirect()->back();
            }
            elseif ($category->type == '1')
            {
                if ($wallet->first()->wallet_balance >= $request->amount )
                {
                    $transaction->create([
                        'category_id' => $request->category_id,
                        'amount' => $request->amount,
                        'note'=>$request->note,
                        'user_id' => Auth::id(),
                    ]);
                    $total_expenses = $wallet->first()->total_expenses + $request->amount;
                    $wallet_balance = $wallet->first()->wallet_balance - $request->amount;


                    $wallet->update([
                        'total_expenses' => $total_expenses,
                        'wallet_balance' => $wallet_balance,

                    ]);
                    return redirect()->back();
                }
                return redirect()->back();
            }

        }
        else
        {
            if ($category->type == '0')
            {
                $transaction->create([
                    'category_id' => $request->category_id,
                    'amount' => $request->amount,
                    'note'=>$request->note,
                    'user_id' => Auth::id(),
                ]);
                $wallet->create([
                    'wallet_balance'=>$request->amount,
                    'total_income'=>$request->amount,
                    'total_expenses'=>0,
                    'user_id'=>Auth::id(),
                ]);
                return redirect()->back();
            }
            else
            {
                return redirect()->back();
            }
        }

    }
    public function chart($type)
    {
        if ($type == 'Daily')
        {
            $transactions_income = Transaction::where('user_id',Auth::id())
                ->orderBy('created_at')->get()->groupBy(function ($item) {
                    return $item->created_at->format('d');
                });
            $income=[];
            $expenses=[];
            foreach ($transactions_income as $transaction)
            {
                foreach ($transaction as $item)
                {
                    if ($item->type == 0 )
                    {

                        if (!array_key_exists($item->created_at->format('d'),$income))
                        {
                            $income[$item->created_at->format('d')]=$item->amount;
                        }else{
                            $income[$item->created_at->format('d')]=$income[$item->created_at->format('d')]+$item->amount;
                        }
                    }

                    if ($item->type == 1 )
                    {
                        if (!array_key_exists($item->created_at->format('d'),$expenses))
                        {
                            $expenses[$item->created_at->format('d')]=$item->amount;
                        }else{
                            $expenses[$item->created_at->format('d')]=$expenses[$item->created_at->format('d')]+$item->amount;
                        }
                    }
                }
            }
            $incomeArrayKeys=array_keys($income);
            $expensesArrayKeys=array_keys($expenses);
            foreach ($incomeArrayKeys as $key)
            {
                if (!array_key_exists($key,$expenses))
                {
                    $expenses[$key]=0.0;
                }
            }
            foreach ($expensesArrayKeys as $key)
            {
                if (!array_key_exists($key,$income))
                {
                    $income[$key]=0.0;
                }
            }
//            dd($incomeArrayKeys,$expensesArrayKeys);
            ksort($income);
            ksort($expenses);

            foreach ($income as $key => $value)
            {
                $data[] = $key;
                $total_income[] = $value;
            }
            foreach ($expenses as $key => $value)
            {
                $total_expenses[] = $value;
            }


        }
        elseif ($type == 'Monthly')
        {
            $transactions_income = Transaction::where('user_id',Auth::id())
                ->orderBy('created_at')->get()->groupBy(function ($item) {
                    return $item->created_at->format('m');
                });
            $income=[];
            $expenses=[];
            foreach ($transactions_income as $transaction)
            {
                foreach ($transaction as $item)
                {
                    if ($item->type == 0 )
                    {

                        if (!array_key_exists($item->created_at->format('m'),$income))
                        {
                            $income[$item->created_at->format('m')]=$item->amount;
                        }else{
                            $income[$item->created_at->format('m')]=$income[$item->created_at->format('m')]+$item->amount;
                        }
                    }

                    if ($item->type == 1 )
                    {
                        if (!array_key_exists($item->created_at->format('d'),$expenses))
                        {
                            $expenses[$item->created_at->format('m')]=$item->amount;
                        }else{
                            $expenses[$item->created_at->format('m')]=$expenses[$item->created_at->format('m')]+$item->amount;
                        }
                    }
                }
            }
            $incomeArrayKeys=array_keys($income);
            $expensesArrayKeys=array_keys($expenses);
            foreach ($incomeArrayKeys as $key)
            {
                if (!array_key_exists($key,$expenses))
                {
                    $expenses[$key]=0.0;
                }
            }
            foreach ($expensesArrayKeys as $key)
            {
                if (!array_key_exists($key,$income))
                {
                    $income[$key]=0.0;
                }
            }
//            dd($incomeArrayKeys,$expensesArrayKeys);
            ksort($income);
            ksort($expenses);

            foreach ($income as $key => $value)
            {
                $data[] = $key;
                $total_income[] = $value;
            }
            foreach ($expenses as $key => $value)
            {
                $total_expenses[] = $value;
            }

        }
        elseif ($type == 'Yearly')
        {
            $transactions_income = Transaction::where('user_id',Auth::id())
                ->orderBy('created_at')->get()->groupBy(function ($item) {
                    return $item->created_at->format('y');
                });
            $income=[];
            $expenses=[];
            foreach ($transactions_income as $transaction)
            {
                foreach ($transaction as $item)
                {
                    if ($item->type == 0 )
                    {

                        if (!array_key_exists($item->created_at->format('y'),$income))
                        {
                            $income[$item->created_at->format('y')]=$item->amount;
                        }else{
                            $income[$item->created_at->format('y')]=$income[$item->created_at->format('y')]+$item->amount;
                        }
                    }

                    if ($item->type == 1 )
                    {
                        if (!array_key_exists($item->created_at->format('y'),$expenses))
                        {
                            $expenses[$item->created_at->format('y')]=$item->amount;
                        }else{
                            $expenses[$item->created_at->format('y')]=$expenses[$item->created_at->format('y')]+$item->amount;
                        }
                    }
                }
            }
            $incomeArrayKeys=array_keys($income);
            $expensesArrayKeys=array_keys($expenses);
            foreach ($incomeArrayKeys as $key)
            {
                if (!array_key_exists($key,$expenses))
                {
                    $expenses[$key]=0.0;
                }
            }
            foreach ($expensesArrayKeys as $key)
            {
                if (!array_key_exists($key,$income))
                {
                    $income[$key]=0.0;
                }
            }
//            dd($incomeArrayKeys,$expensesArrayKeys);
            ksort($income);
            ksort($expenses);

            foreach ($income as $key => $value)
            {
                $data[] = $key;
                $total_income[] = $value;
            }
            foreach ($expenses as $key => $value)
            {
                $total_expenses[] = $value;
            }

        }


        return view('transactions.chart',compact(['data','total_income','total_expenses','type']));
    }
}
