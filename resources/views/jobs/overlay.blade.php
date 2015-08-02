@extends('app')

@section('content')
    <a href="/jobs">back</a>

    @foreach ($ids as $id)

        <img src="/images/test{{ $id }}.png" style="opacity: {{ $alpha }}; position: absolute; top: 50px; left: 50px;">
    @endforeach
@endsection