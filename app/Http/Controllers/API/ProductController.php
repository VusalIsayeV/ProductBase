<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Register;  
use Illuminate\Http\Request;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json($products, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ürünləri çəkmək mümkün olmadı: ' . $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ProductName' => 'required|string|max:255',  
                'Category' => 'required|string|max:255',     
                'Unit' => 'required|string|max:255',         
                'Status' => 'required|string|max:255',       
                'Barcode' => 'required|string|max:255',      
                'Count' => 'required|integer',               
            ]);

            
            $existingProduct = Product::where('ProductName', $validatedData['ProductName'])
                ->where('Category', $validatedData['Category'])
                ->where('Unit', $validatedData['Unit'])
                ->where('Status', $validatedData['Status'])
                ->where('Barcode', $validatedData['Barcode'])
                ->first();

            if ($existingProduct) {
                
                $register = Register::where('ProductId', $existingProduct->id)->first();

                if ($register) {
                    $register->Count += $validatedData['Count'];  
                    $register->save();
                    return response()->json(['message' => 'Ürün mevcut, sayısı başarıyla artırıldı.', 'register' => $register], 200);
                } else {
                    return response()->json(['message' => 'Register kaydı bulunamadı.'], 404);
                }
            }

            
            $product = Product::create([
                'ProductName' => $validatedData['ProductName'],
                'Category' => $validatedData['Category'],
                'Unit' => $validatedData['Unit'],
                'Status' => $validatedData['Status'],
                'Barcode' => $validatedData['Barcode'],
            ]);

            
            $productId = $product->id;

            
            Register::create([
                'ProductId' => $productId,
                'Count' => $validatedData['Count'],
                'BaseId' => 5,  // Sabit BaseId
            ]);

            return response()->json(['message' => 'Ürün başarıyla eklendi', 'product' => $product], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Ürün bulunamadı'], 404);
            }

            $validatedData = $request->validate([
                'ProductName' => 'required|string|max:255',  
                'Category' => 'required|string|max:255',     
                'Unit' => 'required|string|max:255',         
                'Status' => 'required|string|max:255',       
                'Barcode' => 'required|string|max:255',      
            ]);

            
            $product->update($validatedData);

            return response()->json(['message' => 'Ürün başarıyla güncellendi', 'product' => $product], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    
    public function destroy($id)
    {
        try {
            
            $product = Product::find($id);
            if (!$product) {
                return response()->json(['message' => 'Ürün bulunamadı'], 404);
            }

            
            $product->delete();

            return response()->json(['message' => 'Ürün başarıyla silindi'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
