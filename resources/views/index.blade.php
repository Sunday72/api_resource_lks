@extends('layouts.app')
@section('title', 'index')
@section('content')
<a href="{{route('shop.create')}}" class="btn btn-sm btn-success mb-4">+ Tambah</a>

<table class="table table-sm">
    <thead class="table-success">
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Deskripsi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$product['product_name']}}</td>
            <td>{{$product['description']}}</td>
            <td>
                <div class="d-flex">
                    <a href="" class="btn btn-sm btn-warning me-1">edit</a>
                    <form action="" method="post">
                        @csrf
                        <button class="btn btn-sm btn-danger">delete</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
