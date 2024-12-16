@extends('layouts.app')

@section('title', 'Payment Success')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/success.css') }}">
@endpush

@section('content')
<div class="success-container">
    <h1 class="success-title">Payment Successful!</h1>
    <p class="success-message">Your booking is confirmed. Show this confirmation at the cinema counter.</p>
    <div class="qr-code">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Booking Confirmed: QR" alt="QR Code">
    </div>
    <a href="/" class="success-btn">Go Back to Home</a>
</div>
@endsection
