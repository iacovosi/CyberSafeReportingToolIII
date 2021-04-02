@if (session('success-info'))
<div class="alert alert-success">
    <p class="text-center" style="font-size:3em;"><i class="fa fa-check-square-o" aria-hidden="true"></i></p>
    <p class="text-center">{{ session('success-info') }}</p>
    <p class="text-center" style="margin:20px 0 10px;"><a class="btn btn-success" href="/helpline/gr/form" >Επιστροφή στη φόρμα αναφοράς</a></p>
</div>
@endif

@if (session('error-info'))
<div class="alert alert-danger">
     {{ session('error-info') }}
</div>
@endif
