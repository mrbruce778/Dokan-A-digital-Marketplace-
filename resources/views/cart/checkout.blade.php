@extends('dashboard')
<style>::after
{
    box-sizing: border-box;
}
    body
    {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .form-group
    {
        margin-bottom: 15px;
    }
    .checkout-form
    {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    label
    {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    textarea,
    select
    {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .checkout-btn
    {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .checkout-btn:hover
    {
        background-color: #218838;
    }
</style>
@section('content')
<form action="{{ route('orders.place') }}" method="POST" class="checkout-form">
    @csrf
    <div class="form-group">
        <label for="address">Delivery Address</label>
        <textarea name="address" id="address" rows="4" required>{{ old('address') }}</textarea>
    </div>

    <div class="form-group">
        <label for="phone_number">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" required value="{{ old('phone_number') }}">
    </div>

    <div class="form-group">
        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="1">Cash on Delivery</option>
            <option value="2">bKash</option>
            <option value="3">Nagad</option>
            <option value="4">Rocket</option>
        </select>
    </div>

    <button type="submit" class="checkout-btn">
        <i class="fa-solid fa-credit-card"></i> Place Order
    </button>
</form>
@endsection