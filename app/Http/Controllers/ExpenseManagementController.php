<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Expense;

class ExpenseManagementController extends Controller
{
    public function GetCategories(){
        return Category::where('deleted_at',null)->get();
    }

    public function AddCategory(Request $req){
        
        $cat = new Category;
        $cat->CategoryName = $req->CategoryName;
        $cat->CategoryDescription = $req->CategoryDescription;
        $cat->save();
    }

    public function DeleteCategory(Request $req){
        $cat = Category::find($req->id);
        $cat->deleted_at = date('Y-m-d H:i:s');
        $cat->save();
    }

    public function UpdateCategory(Request $req){
        $cat = Category::find($req->id);
        $cat->CategoryName = $req->CategoryName;
        $cat->CategoryDescription = $req->CategoryDescription;
        $cat->save();
        
    }

    public function AddExpense(Request $req){
        $ex = new Expense;
        $ex->ExpenseCategory = $req->ExpenseCategory;
        $ex->ExpenseAmount = $req->Amount;
        $ex->updated_at = $req->date;
        $ex->save();
    }

    public function GetExpense(Request $req){
        return Expense::select('expenses.*','categories.CategoryName',DB::raw('DATE(expenses.updated_at) as date'))
        ->join('categories','categories.id','expenses.ExpenseCategory')
        ->where('expenses.deleted_at',null)
        ->get();
    }

    public function UpdateExpense(Request $req){
        $ex = Expense::find($req->id);
        $ex->ExpenseCategory = $req->ExpenseCategory;
        $ex->updated_at = $req->date;
        $ex->ExpenseAmount = $req->ExpenseAmount;
        $ex->save();
    }

    public function DeleteExpense(Request $req){
        $ex = Expense::find($req->id);
        $ex->deleted_at = date('Y-m-d H:i:s');
        $ex->save();
        
    }
}

