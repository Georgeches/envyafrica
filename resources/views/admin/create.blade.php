@extends('layout')

@section('content')
    @include('admin.partials.admin-navbar')
    <div class="xform container-fluid mt-5">
        <form action="/products" method="POST">
            @csrf
            <h2 class="mb-3 w-75 border-bottom pb-3">New Product</h2>
            <div class="form-group w-100">
                <input type="text" name="name" placeholder="Name of product" id="name"/>
                @error('name')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="brand" placeholder="Product brand" id="brand"/>
                @error('brand')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="model" placeholder="Enter product model" id="model"/>
                @error('model')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="category" placeholder="Enter product category eg shoes, tshirt" id="category"/>
                @error('category')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="color" placeholder="Enter color of product" id="color"/>
                @error('color')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="image" placeholder="Enter link to product image" id="image"/>
                @error('image')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="number" name="price" placeholder="Enter price of product" id="price"/>
                @error('price')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group w-100">
                <input type="text" name="description" placeholder="Enter product description" id="description"/>
                @error('description')
                    <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <input type="submit" class="submit-create-product" name="submit-create-product">
        </form>
    </div>
@endsection