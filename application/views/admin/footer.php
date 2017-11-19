    <!-- JavaScript -->
    <script src="<?php echo base_url();?>asset/jquery/jquery-3.2.1.slim.min.js""></script>
    <script src="<?php echo base_url();?>asset/jquery/jquery.validate.min.js""></script>
    <script src="<?php echo base_url();?>asset/jquery/popper.min.js"></script>
    <script src="<?php echo base_url();?>asset/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>asset/datatables/jquery.dataTables.js"></script>
    
    <!-- Validasi Tambah Data Karyawan -->
    <script type="text/javascript">
        $(document).ready(function() {
			$('#form-regis').validate({
				rules: {
				    ktp: {
						required: true
					},
                    nik: {
						required: true
					},
                    nama: {
						required: true
					},
                    no_hape: {
					   required: true
					},
                    alamat: {
						required: true
					},
					email: {
						required: true,
                        email: true
					},
					situs: {
						url: true
					},
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
					ktp: {
						required: "Nomor Kartu Tanda Penduduk harus diisi"
					},
                    nik: {
						required: "Nomor Induk Karyawan harus diisi"
					},
                    nama: {
						required: "Nama Lengkap harus diisi"
					},
					email: {
						required: "Email harus diisi",
						email: "Format email tidak valid"
					},
                    no_hp: {
					    required: "Nomor Handphone harus diisi"
					},
                    alamat: {
						required: "Alamat harus diisi"
					},
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
