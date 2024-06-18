<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $category = Category::with('products')->get();
            return ApiFormatter::sendResponse(200, 'success', $category);
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
        try {
            // validasi
            $this->validate($request, [
                'name' => 'required',
                'category' => 'required',
            ]);

            // proses ambil data
            $data = Category::create([
                'name' => $request->name,
                'category' => $request->category,
            ]);

            return ApiFormatter::sendResponse(200, 'success', $data);
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
           $this->validate($request, [
               'name' => 'required',
               'category' => 'required',
           ]);
    
            // Find the Category by id and update it
           $checkProses = Category::where('id', $id)->update([
               'name' => $request->name,
               'category' => $request->category,
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
            $category = Category::findOrFail($id);

            // Check if there are related models
            if ($category->products()->exists()) {
            return ApiFormatter::sendResponse(400, 'bad request', 'Tidak Dapat Menghapus Data category karena ada relasi terkait.');
        }

        // If no related models, proceed with deletion
        $category->delete();

        return ApiFormatter::sendResponse(200, 'success', 'Data Category Berhasil Dihapus!');
        } catch (\Exception $err) {
            return ApiFormatter::sendResponse(400, 'bad request', $err->getMessage());
        }
    }
}
