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

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

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

				$(".delete-button").click(function(e) {
					e.preventDefault();
            Swal.fire({
                title: "Hapus?",
                text: "Data tidak akan bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
								reverseButtons: true
            }).then(result => {
                if (result.value) {
                    $(this).parent().submit();
                }
            });
        });

				$(".logout").click(function(e) {
					e.preventDefault();
            Swal.fire({
                title: "Keluar?",
                text: "Anda akan keluar dari aplikasi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal",
								reverseButtons: true
            }).then(result => {
                if (result.value) {
                    $(this).parent().submit();
                }
            });
        });
    })
</script>

@stack('modal')

@stack('js')

</body>

</html>
