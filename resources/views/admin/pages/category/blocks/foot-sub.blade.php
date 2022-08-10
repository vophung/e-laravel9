<script src="{{ asset('assets/js/extensions/datatables.js') }}"></script>
<script src="{{ asset('assets/js/extensions/toastr.min.js') }}"></script>
<script>
    @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true,
    }
            toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('warning'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.warning("{{ session('warning') }}");
    @endif

    @if(Session::has('error'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.error("{{ session('error') }}");
    @endif
</script>
<script>
    const config = {
        routes : {
            store : "{{ route('category.store') }}"
        }
    }
</script>
<script src="{{ asset('scripts/category.js') }}"></script>