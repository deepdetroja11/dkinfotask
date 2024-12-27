<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stocks = Stock::with('store', 'user')->get();
            return DataTables::of($stocks)
                ->addColumn('store_name', function ($stock) {
                    return $stock->store->name ?? 'N/A';
                })
                ->addColumn('action', function ($stock) {
                    return '
                        <form id="deleteForm-' . $stock->id . '" action="' . route('admin.stock.destroy', $stock->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger deleteBtn" data-form-id="deleteForm-' . $stock->id . '">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('stock.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $stores = Store::all();
        return view('stock.create', compact('stores'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'store_id.*' => 'required|exists:stores,id',
            'item_name.*' => 'required|string|max:255',
            'quantity.*' => 'required|integer',
            'location.*' => 'required|string|max:255',
            'stock_no.*' => 'required|string|max:255',
            'item_code.*' => 'required|string|max:255|unique:stocks,item_code',
            'in_stock_date.*' => 'required|date',
        ]);

        try {
            foreach ($request['store_id'] as $index => $storeId) {
                Stock::create([
                    'user_id' => Auth::id(),
                    'store_id' => $storeId,
                    'stock_no' => $request['stock_no'][$index],
                    'item_code' => $request['item_code'][$index],
                    'item_name' => $request['item_name'][$index],
                    'quantity' => $request['quantity'][$index],
                    'location' => $request['location'][$index],
                    'in_stock_date' => $request['in_stock_date'][$index],
                ]);
            }

            return response()->json([
                'redirect_url' => route('admin.stock.index'),
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                'message' => 'An error occurred while creating the stock. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::find($id);

        if ($stock) {
            $stock->delete();

            return response()->json([
                'success' => true,
                'message' => 'Stock deleted successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Stock not found.',
        ], 404);
    }

    public function tabulatorList()
    {
        $authToken = auth()->user()->createToken('api-token')->plainTextToken;
        return view('stock.tabulator_list', compact('authToken'));
    }

}
