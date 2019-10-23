@extends('layouts.layout')
@section('content')

@include('errors')
<form class="payment" action="/new-bank" method="post">
	@csrf
	<div><input type="text" name="bank_name" placeholder="Name of the bank"></div>
	<div><input type="text" name="account_number" placeholder="Account number"></div>
	<div><button class="button bigger" type="submit">Add method</button>
</form>



@endsection