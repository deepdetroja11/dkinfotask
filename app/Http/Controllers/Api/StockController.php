<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StockController extends Controller
{

    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (!Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.',
                ], 401);
            }

            $user = auth()->user();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login. Please try again later.',
            ], 500);
        }
    }

    public function index()
    {
        $stocks = Stock::with('store', 'user')->get();

        $response = $stocks->map(function ($stock) {
            return [
                'id' => $stock->id,
                'name' => $stock->item_name,
                'item_code' => $stock->item_code,
                'quantity' => $stock->quantity,
                'store_name' => $stock->store->name,
                'stock_status' => $stock->stock_status,
                'location' => $stock->location,
                'user_name' => $stock->user->name,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $response,
            'message' => 'Stock list fetched successfully',
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'store_id' => 'required|array',
                'store_id.*' => 'required|exists:stores,id',
                'item_name' => 'required|array',
                'item_name.*' => 'required|string|max:255',
                'quantity' => 'required|array',
                'quantity.*' => 'required|integer',
                'location' => 'required|array',
                'location.*' => 'required|string|max:255',
                'stock_no' => 'required|array',
                'stock_no.*' => 'required|string|max:255',
                'item_code' => 'required|array',
                'item_code.*' => 'required|string|max:255|unique:stocks,item_code',
                'in_stock_date' => 'required|array',
                'in_stock_date.*' => 'required|date',
                'user_id' => 'required|exists:users,id',
            ]);


            \DB::beginTransaction();

            foreach ($request['store_id'] as $index => $storeId) {
                Stock::create([
                    'user_id' => $request['user_id'],
                    'store_id' => $storeId,
                    'stock_no' => $request['stock_no'][$index],
                    'item_code' => $request['item_code'][$index],
                    'item_name' => $request['item_name'][$index],
                    'quantity' => $request['quantity'][$index],
                    'location' => $request['location'][$index],
                    'in_stock_date' => $request['in_stock_date'][$index],
                ]);
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Stocks have been successfully created.',
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the stock. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
