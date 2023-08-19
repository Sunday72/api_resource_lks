<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProductController extends Controller
{
    protected $client;

    public function __construct(){
        $this->client = new Client();
    }
    public function index()
    {
        $response = $this->client->get('http://127.0.0.1:8000/api/products');
        $responseData = json_decode($response->getBody(), true);
        return view('index', ['products' => $responseData["data"]["data"]]);
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $dataToSend = $request->all();
        $response = $this->client->post('http://127.0.0.1:8000/api/products', [
            'json' => $dataToSend
        ]);

        if($response->getStatusCode() == 201){
            return redirect()->route('shop.index')->with('success', 'Berhasil tambah data!');
        } else {
            return redirect()->back()->with('error', 'Gagal tambah data!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
