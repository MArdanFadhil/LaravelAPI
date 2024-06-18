<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $product = Product::with('user', 'category')->get();
            return ApiFormatter::sendResponse(200, 'success', $product);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request, [
                'category_id' => 'required',
                'user_id' => 'required',
                'harga' => 'required|numeric',
                'name' => 'required|max:255',
                'total' => 'required',
            ]);

            $product = Product::create([
                'category_id' => $request->category_id,
                'user_id' => $request->user_id,
                'harga' => $request->harga,
                'name' => $request->name,
                'total' => $request->total,
            ]);

            return ApiFormatter::sendResponse(200, 'Successfully Create A Product Data', $product);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
           $this->validate($request, [
                'category_id' => 'required',
                'user_id' => 'required',
                'harga' => 'required|numeric',
                'name' => 'required|max:255',
                'total' => 'required',
           ]);
    
           $checkProses = Category::where('id', $id)->update([
                'category_id' => required,
                'user_id' => $request->user_id,
                'harga' => $request->user_id,
                'name' => $request->name,
                'total' => $request->total,
           ]);
    
           if ($checkProses) {
               $data = Category::find($id);
               return ApiFormatter::sendResponse(200, 'success', $data);
           } else {
               return ApiFormatter::sendResponse(400, 'bad request', 'Gagal Mengubah Data!');
           }
       } catch (\Exception $err) {
           return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
        
            if ($product->user()->exists() || $product->category()->exists()) {
                return ApiFormatter::sendResponse(400, 'bad request', 'Tidak dapat menghapus data Product karena ada relasi terkait.');
            }
        
            $product->delete();
        
            return ApiFormatter::sendResponse(200, 'success', 'Data Product berhasil dihapus!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
        
    }
}
