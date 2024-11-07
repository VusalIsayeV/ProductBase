<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Way;
use Exception;

class MoveController extends Controller
{
    public function index()
    {
        try {
            $way = Way::all();
            return response()->json($way, 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Ürünləri çəkmək mümkün olmadı: ' . $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            // Gelen verileri doğrula
            $validated = $request->validate([
                'product_id' => 'required|exists:product,id',
                'from_base' => 'required|exists:base,id',
                'to_base' => 'required|exists:base,id',
                'count' => 'required|integer|min:1',
            ]);

            // `Register` tablosunda kaynak bazadaki ürün miktarını al
            $register = Register::where('ProductId', $validated['product_id'])
                ->where('BaseId', $validated['from_base'])
                ->first();

            if (!$register) {
                return response()->json([
                    'message' => 'Bu bazada bu ürün bulunmamaktadır.',
                ], 404); // Hedeflenen ürün, kaynak bazada bulunmuyor
            }

            // Kaynak bazadaki mevcut ürün miktarını kontrol et
            if ($register->Count < $validated['count']) {
                return response()->json([
                    'message' => 'Bu bazada bu üründen yeterli miktar yok. Var olan miktar: ' . $register->Count,
                ], 400); // Yetersiz miktar hatası
            }

            // Kaynak bazadaki ürün sayısını güncelle (taşıma yapılıyor)
            $register->Count -= $validated['count'];
            $register->save();

            // `Way` tablosunda taşıma işlemini kaydet
            Way::create([
                'FromBase' => $validated['from_base'],
                'ToBase' => $validated['to_base'],
                'product_id' => $validated['product_id'],
                'SendNum' => $validated['count'],
            ]);

            // Hedef base'de ürün sayısını güncelle
            $toRegister = Register::where('ProductId', $validated['product_id'])
                ->where('BaseId', $validated['to_base'])
                ->first();

            if ($toRegister) {
                // Eğer hedef bazada varsa, sayısını artır
                $toRegister->Count += $validated['count'];
                $toRegister->save();
            } else {
                // Hedef baza yeni ürün ekleyebilirsiniz
                Register::create([
                    'ProductId' => $validated['product_id'],
                    'BaseId' => $validated['to_base'],
                    'Count' => $validated['count'],
                ]);
            }

            return response()->json([
                'message' => 'Ürün başarıyla taşındı!',
                'data' => $validated
            ]);
        } catch (Exception $e) {
            // Hata durumunda geri dönüş
            return response()->json([
                'message' => 'Bir hata oluştu.',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 hata kodu
        }
    }
}
