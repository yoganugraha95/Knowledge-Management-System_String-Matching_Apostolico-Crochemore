    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h3 class="my-4"><?php echo $ktp; ?></h3>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Data Karyawan dengan No. KTP : <?php echo $ktp; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                            <?php
                                if($profil_superintendent->row()->foto == NULL)
                                {
                            ?>
                                <img src="<?php echo base_url(); ?>asset/image/nophoto.png" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $ktp; ?>" />
                            <?php
                                }
                                else
                                {
                            ?>
                                <img src="<?php echo base_url(); ?>upload/image/<?php echo $profil_superintendent->row()->foto; ?>" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $ktp; ?>" />
                            <?php 
                                }
                            ?>
                            </div>
                            <div class="col-lg-8">
                                <?php
                                    foreach($profil_superintendent->result() as $row)
                                    {
                                ?>
                                <p><strong>Data Pribadi</strong></p>
                                <table class="table">
                                    <tr>
                                        <td>No. KTP</td>
                                        <td>:</td>
                                        <td><?php echo $row->ktp; ?></td>
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
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?php echo $row->email ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Handphone</td>
                                        <td>:</td>
                                        <td><?php echo $row->no_hp; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $row->alamat; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status Akun</td>
                                        <td>:</td>
                                        <td>
                                            <?php
                                                if($row->status_aktif == 'TRUE')
                                                {
                                                    echo 'Aktif';
                                                }
                                                else
                                                {
                                                    echo 'Tidak Aktif';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->

        </div>

    </div>
    <!-- /.container -->