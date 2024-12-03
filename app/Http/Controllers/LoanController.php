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
    $product = $loan->product;
    if ($product->quantity <= 0) {
        return response()->json(['message' => 'No hay suficientes productos disponibles'], 400);
    }

    $loan->state = 2; // Cambia el estado a "aceptado"
    $loan->loan_date = $request->input('loan_date'); // Fecha proporcionada en la solicitud
    $loan->save();

    $product->quantity -= 1;
    $product->save();

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

    $product = $loan->product; // Obtiene el producto asociado al préstamo

    // Cambia el estado a "entregado"
    $loan->state = 3; 
    $loan->return_date = $request->input('return_date'); // Fecha proporcionada en la solicitud
    $loan->save();

    // Suma 1 a la cantidad disponible del producto
    $product->quantity += 1;
    $product->save();

    return response()->json([
        'message' => 'Loan handed in successfully',
        'loan' => $loan,
        'product' => $product
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
