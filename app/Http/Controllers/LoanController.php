<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function getLoans()
    {
        $loans = Loan::all();
        return response()->json($loans);
    }

    public function getLoan($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        return response()->json($loan);
    }

    public function createLoan(Request $request)
    {
        $loan = Loan::create($request->all());
        return response()->json($loan, 201);
    }

    public function deleteLoan($id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        $loan->delete();
        return response()->json(['message' => 'Loan deleted successfully']);
    }

    public function updateLoan(Request $request, $id)
    {
        $loan = Loan::find($id);
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        $loan->fill($request->all());
        $loan->save();
        return response()->json($loan);
    }
}
