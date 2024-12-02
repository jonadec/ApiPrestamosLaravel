<?php

namespace App\Http\Controllers;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function getLoans()
    {
        $loans = Loan::with(['user', 'product'])->get();
        return response()->json($loans);
    }

    public function getLoan($id)
    {
        $loan = Loan::with(['user', 'product'])->find($id); // Incluye relaciones
        if (!$loan) {
            return response()->json(['message' => 'Loan not found'], 404);
        }
        return response()->json($loan);
    }
    public function acceptLoan(Request $request, $id)
{
    $loan = Loan::find($id);

    if (!$loan) {
        return response()->json(['message' => 'Loan not found'], 404);
    }

    $loan->state = 2; // Cambia el estado a "aceptado"
    $loan->loan_date = $request->input('loan_date'); // Fecha proporcionada en la solicitud
    $loan->save();

    return response()->json([
        'message' => 'Loan accepted successfully',
        'loan' => $loan
    ]);
}

public function handinLoan(Request $request, $id)
{
    $loan = Loan::find($id);

    if (!$loan) {
        return response()->json(['message' => 'Loan not found'], 404);
    }

    $loan->state = 3; // Cambia el estado a "aceptado"
    $loan->return_date = $request->input('return_date'); // Fecha proporcionada en la solicitud
    $loan->save();

    return response()->json([
        'message' => 'Loan accepted successfully',
        'loan' => $loan
    ]);
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
