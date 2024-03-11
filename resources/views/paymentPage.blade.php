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

        <div class="payment-section row justify-content-center">
            <div class="payment-options col-12 col-lg-6 d-flex align-items-center justify-content-around">
                <button x-on:click="mpesaOpen = true" class="btn btn-success me-2 me-md-0">M-pesa</button>
                <button x-on:click="mpesaOpen = false" class="btn btn-primary me-2 me-md-0 d-flex justify-content-center align-items-center"><i class="bi bi-credit-card"></i> Card</button>
                <button class="btn btn-primary"><i class="bi bi-paypal"></i> Paypal</button>
            </div>
        </div>
        <div class='mpesa-form row justify-content-center mt-5' x-show="mpesaOpen">
            <div class='col-12 col-lg-6'>
                <form action="/order/new" method="POST">
                    @csrf
                    <label for="first-name" class="fw-bold form-label">
                            Mobile number
                    </label>
                    <div class="row">
                    <div class="col-3 col-lg-2 me-0">
                        <input
                            type="text"
                            class="form-control"
                            readOnly
                            value={{$customer['phonecountry']}}
                        />
                    </div>
                    <div class="col-9 col-lg-10">
                        <input
                            autoComplete="off"
                            type="number"
                            id="phone"
                            maxLength="9"
                            placeholder="712345678"
                            class="form-control"
                            value={{$customer['phone']}}
                            required
                        />
                    </div>
                </div>
                <button type="submit" class="btn purchase mb-4">Continue to purchase</button>
                </form>
            </div>
        </div>

        <div class='card-form row justify-content-center mt-5' x-show="!mpesaOpen">
            <div class='col-12 col-lg-6'>
                <form>
                    <label for="card-number" class="fw-bold form-label">
                            Card number
                    </label>
                    <input id='card-number' maxLength='19' value='' onchange="handleCardNumberChange(e)" type='text' placeholder='0000 0000 0000 0000' class='form-control mb-4' required/>
                    <div class="row mt-4">
                        <div class="col">
                            <label for="expiration" class="fw-bold form-label">
                                Expiration
                            </label>
                            <input
                                type="text"
                                id='expiration'
                                maxLength="5"
                                placeholder="01/23"
                                class="form-control"
                                value=''
                                onchange="handleExpirationChange(e)"
                                required
                            />
                        </div>
                        <div class="col">
                            <label for="cvv" class="fw-bold form-label">
                                CVV
                            </label>
                            <input
                                autoComplete="off"
                                type="number"
                                id="cvv"
                                maxLength="3"
                                placeholder="000"
                                class="form-control"
                                value=''
                                handleChangeCvv(e)
                                required
                            />
                        </div>
                    </div>
                    <button class="btn purchase mt-4 mb-4">Continue to purchase</button>
                </form>
            </div>
        </div>
    </div>
@endsection