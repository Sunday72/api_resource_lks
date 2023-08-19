<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(5);
        return new ProductResource(true, 'List Data Produk', $products); // (status_response, message, data)
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            'product_name' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan produk',
                'message' => $validator->errors()
            ]);
        }

        $image = $request->file('image');
        $image->storeAs('products', $image->hashName(), 'public');

        $product = Product::create([
            'image' => $image->hashName(),
            'product_name' => $request->product_name,
            'description' => $request->description
        ]);

        return new ProductResource(true, 'Berhasil tambah produk!', $product);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if ($product) {
            return new ProductResource(true, 'Berhasil Menampilkan Detail Produk!', $product);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan!',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan!'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'product_name'  => 'required',
            'description'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengupdate produk!',
                'data' => $validator->errors()
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('products', $image->hashName(), 'public');
            Storage::delete('products/' . basename($product->image));

            $product->update([
                'image' => $image->hashName(),
                'product_name' => $request->product_name,
                'description' => $request->description
            ]);
        } else {
            $product->update([
                'product_name' => $request->product_name,
                'description' => $request->description
            ]);
        }

        return new ProductResource(true, 'Berhasil Update Data Produk!', $product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        Storage::delete('products/'.basename($product->image));
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak ditemukan!'
            ]);
        }
        $product->delete();
        return new ProductResource(true, 'Berhasil Hapus Data Produk!', $product);
    }
}
