    <!-- Validasi Ubah Password -->
    <script type="text/javascript">
        $(document).ready(function() {
			$('#form-password').validate({
				rules: {
					password: {
                        required: true,
                        minlength: 8
                    },
                    passconf: {
                        required: true,
                        equalTo: "#password"
                    },
				},
				messages: {
					password: {
                        required: "Password harus diisi",
                        minlength: "Password harus minimal 8 karakter"
                    },
                    passconf: {
                        required: "Konfirmasi Password Harus Diisi",
                        equalTo: "Password tidak sama"
                    },
				}
			});
		});
    </script>

    <!-- DataTables -->
    <script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
    </script>

  </body>

</html>
