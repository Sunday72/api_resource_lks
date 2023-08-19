@extends('layouts.app')
@section('title', 'create')
@section('content')
<a href="javascript:history.back()" class="btn btn-sm btn-dark mb-4"><< back</a>

<form action="{{route('shop.store')}}" method="post">
    @csrf
    <div class="input-group mb-3">
        <label for="" class="input-group-text">Product Name</label>
        <input type="text" class="form-control" name="product_name">
    </div>
    <div class="input-group mb-3">
        <label for="" class="input-group-text">Description</label>
        <input type="text" class="form-control" name="description">
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
</form>
@endsection
