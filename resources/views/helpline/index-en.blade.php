@extends('layouts.external')

@section('content')
    <div class="container">
        <h1>HelpLine</h1>

        <a href="{{ route('create-helpline') }}" class="btn btn-danger">Report</a>
    </div>
@endsection