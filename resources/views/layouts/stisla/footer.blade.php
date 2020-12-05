</div>
</div>

<!-- General JS Scripts -->
<script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ url('assets/js/popper.min.js') }}"></script>
<script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('assets/js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ url('assets/js/moment.min.js') }}"></script>
<script src="{{ url('assets/js/stisla.js') }}"></script>

<!-- JS Libraies -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- Template JS File -->
<script src="{{ url('assets/js/scripts.js') }}"></script>
<script src="{{ url('assets/js/custom.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ url('assets/js/page/index-0.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script src="{{ asset('js/scripts.js') }}"></script>

<livewire:scripts></livewire:scripts>


<script>
    $(document).ready(function() {
        $("#datatable").DataTable({
            "lengthMenu": [5, 10, 15],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
            }
        });
    })
</script>

@stack('modal')

@stack('js')

</body>

</html>