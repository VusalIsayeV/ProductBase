<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\Stock;
use Illuminate\Http\Request;
use Exception;

class RegisterController extends Controller
{
    public function index()
    {
        try {
            // Register cədvəlindəki bütün məlumatları çəkmək
            $registers = Register::with('product')->get();
            return response()->json($registers, 200); // 200 OK döndür
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Məlumatı çəkmək mümkün olmadı: ' . $e->getMessage()
            ], 500); // 500 Internal Server Error döndür
        }
    }

    // RegisterController.php

    public function store(Request $request)
    {
        try {
            // Giriş verilerini doğruluyoruz
            $validatedData = $request->validate([
                'ProductId' => 'required|exists:product,id',  // ProductId doğrulaması
                'BaseId' => 'required|exists:base,id',        // BaseId doğrulaması
                'Count' => 'required|integer|min:1',           // Count doğrulaması
            ]);

            // Yeni Register kaydını oluşturuyoruz
            $register = Register::create([
                'ProductId' => $validatedData['ProductId'],
                'BaseId' => $validatedData['BaseId'],
                'Count' => $validatedData['Count'],
            ]);

            // Başarılı yanıt döndürme
            return response()->json([
                'message' => 'Məlumat uğurla əlavə edildi',
                'data' => $register // İlgili register verisini de dönüyoruz
            ], 201); // 201 Created döndür
        } catch (Exception $e) {
            // Hata durumunda detaylı hata mesajı ile birlikte geri döndürme
            return response()->json([
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500); // 500 Internal Server Error döndür
        }
    }
}
