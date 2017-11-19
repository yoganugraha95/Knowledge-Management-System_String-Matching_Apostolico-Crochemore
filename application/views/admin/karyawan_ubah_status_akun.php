    <!-- Styling validasi form password -->
    <style type="text/css">
        .labelfrm {
            display:block;
            font-size:small;
            margin-top:5px;
        }
        .error {
        font-size:small;
        color:red;
        }
    </style>
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h3 class="my-4"><?php echo $ktp; ?></h3>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>karyawan/daftar" class="list-group-item active">Daftar Karyawan</a>
                    <a href="<?php echo base_url() ?>karyawan/input" class="list-group-item">Tambah Karyawan</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Ubah Status Akun Karyawan dengan No. KTP : <?php echo $ktp; ?>
                    </div>
                    <div class="card-body">
                        <?php
                            foreach($profil_karyawan->result() as $row)
                            {
                        ?>
                        <div class="row">
                            <div class="col-lg-9">
                                <table class="table">
                                    <tr>
                                        <td>No. KTP</td>
                                        <td>:</td>
                                        <td><a href="<?php echo base_url();?>karyawan/profil/<?php echo $row->ktp; ?>" title="<?php echo $row->ktp;?>"><?php echo $row->ktp; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td>:</td>
                                        <td><?php echo $row->nik; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Lengkap</td>
                                        <td>:</td>
                                        <td><?php echo $row->nama; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Divisi</td>
                                        <td>:</td>
                                        <td><?php echo $row->nama_divisi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>:</td>
                                        <td><?php echo $row->nama_jabatan; ?></td>
                                    </tr>
                                </table>
                                <hr />
                                <form action="<?php echo base_url();?>karyawan/perbarui_status_akun" method="post">
                                    <div class="form-group">
                                        <label>Status Akun</label>
                                        <select name="status_aktif" class="form-control" id="status_aktif">
                                            <option value="TRUE">Aktif</option>
                                            <option value="FALSE">Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="ktp" value="<?php echo $row->ktp; ?>" />
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
                                </form>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->

        </div>

    </div>
    <!-- /.container -->