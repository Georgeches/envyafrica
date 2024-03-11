@extends('layout')

@php
    $customer = [
        'firstname' => '',
        'secondname' => '',
        'email' => '',
        'addressone' => '',
        'addresstwo' => '',
        'phone' => '',
        'phonecountry' => '',
        'city' => '',
        'country' => '',
    ];
    $customerSession = session()->get('customer');
    if(isset($customerSession)){
        $customer['firstname'] = $customerSession['firstname'];
        $customer['secondname'] = $customerSession['secondname'];
        $customer['email'] = $customerSession['email'];
        $customer['phone'] = $customerSession['phone'];
        $customer['phonecountry'] = $customerSession['phonecountry'];
        $customer['addressone'] = $customerSession['addressone'];
        $customer['addresstwo'] = $customerSession['addresstwo'];
        $customer['city'] = $customerSession['city'];
        $customer['country'] = $customerSession['country'];
    }

    function getCountry($countries, $value): array{
        $remainingCountries = array_filter($countries, function($country) use($value){
            return $country['value'] != $value;
        });
        foreach ($countries as $country) {
            if($country['value'] == $value){
                return [
                    'value' => $value,
                    'label' => $value.' '.$country['label'],
                    'remaining' => $remainingCountries,
                ];
            }
        }
        return [
            'value' => '',
            'label' => '',
            'remaining' => '',
        ];
    }
@endphp

@section('content')
    @include('products.partials.navbar')
    <div class="container-fluid checkout-page" style="position: relative; top: 80px;">
        <div class="row contact-info">
            <form action="/customer/new" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <label for="first-name" class="form-label">
                            First name
                        </label>
                        <input
                            autoComplete="off"
                            type="text"
                            name="firstname"
                            id="first-name"
                            placeholder="First name"
                            class="form-control"
                            value='{{$customer['firstname']}}'
                            spellCheck="false"
                            required
                        />
                        @error('firstname')
                            <p class="text-danger w-100">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="second-name" class="form-label">
                            Second name
                        </label>
                        <input
                            autoComplete="off"
                            type="text"
                            name="secondname"
                            id="second-name"
                            placeholder="Second name"
                            class="form-control"
                            value="{{$customer['secondname']}}"
                            spellCheck="false"
                            required
                        />
                        @error('secondname')
                            <p class="text-danger w-100">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <label for="email" class="form-label">
                    Email address
                </label>
                <input
                    type="text"
                    id="email"
                    name="email"
                    placeholder="example@gmail.com"
                    class="form-control"
                    value='{{$customer['email']}}'
                    spellCheck="false"
                    required
                />
                @error('email')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
                <label for="phone" class="form-label">
                    Phone number
                </label>
                <div class="row">
                    <div class="col-4 col-lg-3">
                        @if ($customer['phonecountry'] !== '')
                            <select name="phonecountry">
                                <option value={{$customer['phonecountry']}}>{{getCountry($countries, $customer['phonecountry'])['label']}}</option>
                                @foreach ($countries as $country)
                                    <option value={{$country['value']}}>{{$country['value'].' '.$country['label']}}</option>
                                @endforeach
                            </select>
                        @else
                            <select name="phonecountry">
                                @foreach ($countries as $country)
                                    <option value={{$country['value']}}>{{$country['value'].' '.$country['label']}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-8 col-lg-9">
                        <input
                            autoComplete="off"
                            type="number"
                            id="phone"
                            name="phone"
                            placeholder="712345678"
                            class="form-control"
                            value='{{$customer['phone']}}'
                            spellCheck="false"
                            required
                        />
                    </div>
                    @error('phonecountry')
                        <p class="text-danger w-100">{{$message}}</p>
                    @enderror
                    @error('phone')
                        <p class="text-danger w-100">{{$message}}</p>
                    @enderror
                </div>
                <label for="address-one" class="form-label">
                    Address Line 1
                </label>
                <input
                    type="text"
                    name="addressone"
                    autoComplete="off"
                    placeholder="Address 1 e.g street"
                    class="form-control"
                    value='{{$customer['addressone']}}'
                    spellCheck="false"
                    required
                />
                @error('addressone')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
                <label for="address-two" class="form-label">
                    Address Line 2
                </label>
                <input
                    type="text"
                    name="addresstwo"
                    autoComplete="off"
                    placeholder="Address 2 e.g Apartment"
                    class="form-control"
                    value='{{$customer['addresstwo']}}'
                    spellCheck="false"
                    required
                />
                @error('addresstwo')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
                <label for="city" class="form-label">
                    City
                </label>
                <input
                    type="text"
                    name="city"
                    autoComplete="off"
                    placeholder="Nairobi"
                    class="form-control"
                    value='{{$customer['city']}}'
                    spellCheck="false"
                    required
                />
                @error('city')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
                <label for="country" class="form-label">
                    Country
                </label>
                @if ($customer['country'] != '')
                    <select class="mb-3" name="country">
                        <option value={{$customer['country']}}>{{$customer['country']}}</option>
                        @foreach ($countries as $country)
                            <option value={{$country['label']}}>{{$country['label']}}</option>
                        @endforeach
                    </select>
                @else
                    <select class="mb-3" name="country">
                        @foreach ($countries as $country)
                            <option value={{$country['label']}}>{{$country['label']}}</option>
                        @endforeach
                    </select>
                @endif
                @error('country')
                    <p class="text-danger w-100">{{$message}}</p>
                @enderror
                <button class="btn btn-dark mt-4 next-btn">Next</button>
            </form>
        </div>
    </div>
@endsection