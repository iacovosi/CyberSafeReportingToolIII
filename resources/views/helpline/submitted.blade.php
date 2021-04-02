@extends('layouts.generic')

@section('content')

<div class="container-fluid">
    {{-- @include('partials.info') --}}

    <div class="alert alert-success">
        <p class="text-center" style="font-size:3em;"><i class="fa fa-check-square-o" aria-hidden="true"></i></p>
        <p class="text-center">{{ session('success-info') }}</p>
        <p class="text-center" style="margin:20px 0 10px;"><a class="btn btn-success" href="{{ url()->previous() }}" >{{ $backtoform }}</a></p>
    </div>

</div>
@endsection

@section('scripts')
<!-- Make iframe automatically adjust height according to the contents in it using javascript (Support Cross-Domain) -->
<script>
    setInterval(function() {
        window.top.postMessage(document.body.scrollHeight, "https://www.cybersafety.cy/helpline-report");
    }, 500);
</script>
@endsection
