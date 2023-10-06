@if(session()->get('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

@if(session()->get('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
@endif

@if(session()->get('errors'))
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach
@endif
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    // Automatically close the success alert after 5 seconds
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
