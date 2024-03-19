@extends('layout')

@section('content')
    @include('products.partials.navbar')
    @include('products.partials.carousel')
    @include('products.partials.designsSection')
    @include('products.partials.productsSection')
    @include('products.partials.footer')
    {{-- @include('partials.cartOffcanvas') --}}
@endsection