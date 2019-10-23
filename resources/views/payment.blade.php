@extends('layouts.layout')
@section('content')
@include('errors')
<form class="payment" action="/payment" method="post">
	@csrf
	<div><input type="text" name="from" placeholder="Your credit card" value="{{ old('from') }}"></div>
	@foreach($banks as $bank)
	<div>{{$bank->name}} - <input type="radio" name="bank" value="{{$bank->id}}"> </div>
	@endforeach
	<div><input type="text" name="price" placeholder="Price" value="{{ old('price') }}"></div>
	<div><input type="date" name="date" value="{{ old('date') }}"></div>
	<div><input type="text" name="ks" placeholder="KS" value="{{ old('ks') }}"></div>
	<div><input type="text" name="vs" placeholder="VS" value="{{ old('vs') }}" ></div>
	<div><input type="text" name="ss" placeholder="SS" value="{{ old('ss') }}"></div>
	<div><input type="text" name="note" placeholder="Note" value="{{ old('note') }}"></div>
	<div><button class="button bigger" type="submit">Odoslat objednavku</button>
</form>


@endsection