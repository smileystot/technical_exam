<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;

class ChartController extends Controller
{
    public function GetChartData(){
        return Expense::select('expenses.*','categories.CategoryName')->join('categories','categories.id','expenses.ExpenseCategory')->get();
    }
}
