    <!-- JavaScript -->
    <script src="<?php echo base_url();?>asset/jquery/jquery-3.2.1.slim.min.js""></script>
    <script src="<?php echo base_url();?>asset/jquery/jquery.validate.min.js""></script>
    <script src="<?php echo base_url();?>asset/jquery/popper.min.js"></script>
    <script src="<?php echo base_url();?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>asset/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url();?>asset/datatables/jquery.dataTables.js"></script>
    
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

    <!-- Summernote -->
    <script>
    $(document).ready(function() {
      $('.summernote').summernote();
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
