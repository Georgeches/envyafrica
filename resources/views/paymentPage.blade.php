@extends('layout')

@php
    $customer = session()->get('customer');
@endphp

@section('content')
    @include('products.partials.navbar')
    <div class="container payment-page" x-data="{ mpesaOpen: true }">
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-6">
                <div class="card contacts">
                    <div class="card-header pb-0 pt-2 d-flex justify-content-between align-items-center bg-white">
                        <p class="lead fw-normal">
                            Contact Information
                        </p>
                        <a href="/customerinfo" class="text-dark">Edit</a>
                    </div>
                    <div class="card-body h-25 text-start">
                        <p class="mb-3"><b>Email: </b> {{$customer['email']}}</p>
                        <p class=""><b>Phone: </b> {{$customer['phonecountry'].$customer['phone']}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-12 col-lg-6">
                <div class="card contacts">
                    <div class="card-header pb-0 pt-2 d-flex justify-content-between align-items-center bg-white">
                        <p class="lead fw-normal">
                            Shipping Information
                        </p>
                        <a href="/customerinfo" class="text-dark">Edit</a>
                    </div>
                    <div class="card-body h-25 text-start">
                        <p class=" mb-3" style="textTransform: capitalize"><b>Address: </b> {{$customer['addressone']}}, {{$customer['addresstwo']}}, {{$customer['city']}}</p>
                        <h6 class=""><b>Country: </b> {{$customer['country']}}</h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-12 col-lg-6">
                <div class="card contacts">
                    <div class="card-header pb-0 pt-2 d-flex justify-content-between align-items-center bg-white">
                        <p class="lead fw-normal">
                            Cost Summary
                        </p>
                    </div>
                    <div class="card-body h-25 text-start">
                        <p class=" mb-3"><b>Subtotal cost: </b> Ksh. {{$subtotal}}</p>
                        <p class=" mb-3"><b>Shipping cost: </b >Ksh. {{$shipping}}</p>
                        <p class=" mb-3"><b>Tax: </b> Ksh. {{$tax}}</p>
                        <p class="fw-bold"><b>TOTAL: </b>Ksh. {{$total}}</p>
                    </div>
                </div>
                <hr class="mt-5"/>
            </div>
        </div>

        <div class='mpesa-form row justify-content-center' x-show="mpesaOpen">
            <div class='col-12 col-lg-6'>
                <form action="/order/new" method="POST">
                    @csrf
                    <label for="first-name" class="fw-bold form-label">
                            Mobile number
                    </label>
                    <input
                        autoComplete="off"
                        type="number"
                        id="phone"
                        name="phone"
                        placeholder="0712345678"
                        class="form-control"
                        required
                    />
                    @error('phone')
                        <p class="text-danger w-100">{{$message}}</p>
                    @enderror
                    <button type="submit" class="btn purchase mb-4">Continue to purchase</button>
                </form>
            </div>
        </div>
    </div>
@endsection