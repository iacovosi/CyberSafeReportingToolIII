@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            {{$errors->first()}}
        </ul>
    </div>
@endif

<div id="success-panel" class="alert alert-success" style="display:none;">

</div>

<div id="error-panel" class="alert alert-danger" style="display:none;">
</div>
