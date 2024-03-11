@extends('layout')

@section('content')
    @include('admin.partials.admin-navbar')
    <div class="container-fluid  admin-body mt-5">
        <div class="admin-body-header d-flex">
            <h2 class="mb-5 text-secondary fw-light ps-5 w-25">Laras Admin</h2>
            @if (session()->has('success'))
                <div class="w-75 d-flex justify-content-center">
                    <div class="alert alert-info text-center w-50 border-0 fw-bold" role="alert">
                        {{session('success')}}
                    </div>
                </div>
            @endif
        </div>
        <div class="admin-flex d-flex justify-content-between">
            <div class="admin-flex-left ps-5">
                <h2 class="text-danger">Collections</h2>
                <ul class="collections">
                    <li class="collection collection-one d-flex align-items-center">
                        <a href="/adminpage?collection=products" class=" btn btn-link text-dark text-decoration-none d-flex align-items-center w-75"><p class="lead mb-0">Products</p></a>
                        <a href="/adminpage/products/create" class="create "><i class="bi bi-plus"></i></a>
                    </li>
                    <li class="collection collection-one d-flex align-items-center ">
                        <a href="/adminpage?collection=users" class="btn btn-link text-dark text-decoration-none h-100 w-75 text-start"><p class="lead">Admins</p></a>
                        <a href="/adminpage/registeradmin" class="create"><i class="bi bi-plus"></i></a>
                    </li>
                    <li class="collection">
                        <a href="/adminpage?collection=orders" class="btn btn-link text-dark text-decoration-none"><p class="lead">Orders</p></a>
                    </li>
                    <li class="collection collection-one d-flex align-items-center">
                        <a href="/adminpage?collection=customers" class="btn btn-link text-dark text-decoration-none h-100 w-75 text-start"><p class="lead">Past Customers</p></a>
                        <a href="#" class="create "><i class="bi bi-plus"></i></a>
                    </li>
                </ul>
            </div>
            <div class="admin-flex-right">
                @if (count($collection) < 1)
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="lead">No items to display</p>
                    </div>
                @else
                @if ($request == 'products')
                    <form action="" class="w-75 d-flex mb-2">
                        <input type="text" placeholder="Search..." class="form-control w-50 ps-3" name="search" id="search">
                        <input type="submit" name="submit-search" class="form-control btn btn-outline-dark ms-2" style="width: 10%;" value="search">
                    </form>
                    <table class="table table-striped">
                        <thead class="table-danger">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Model</th>
                                <th scope="col">Category</th>
                                <th scope="col">Color</th>
                                <th scope="col">Description</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $product)
                                <tr>
                                    <td><img src={{$product['image']}} alt="" style="width: 100px; height: auto;"></td>
                                    <td>{{$product['name']}}</td>
                                    <td>{{$product['brand']}}</td>
                                    <td>{{$product['model']}}</td>
                                    <td>{{$product['category']}}</td>
                                    <td>{{$product['color']}}</td>
                                    <td>{{$product['description']}}</td>
                                    <td>sh {{$product['price']}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="/products/{{$product->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                            <a href="/adminpage/products/edit/{{$product->id}}" class="btn btn-link text-warning"><i class="bi bi-pencil-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if ($request == 'users')
                    <table class="table table-striped w-50">
                        <thead class="table-danger">
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $user)
                                <tr>
                                    <td>{{$user['name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <form action="/users/{{$user->id}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                            <a href="/adminpage/admins/edit/{{$user->id}}" class="btn btn-link text-warning"><i class="bi bi-pencil-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                  
                @if ($request == 'orders')
                    <table class="table table-striped">
                        <thead class="table-danger">
                        <tr>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($collection as $order)
                                <tr>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @endif
            </div>
        </div>
    </div>
@endsection