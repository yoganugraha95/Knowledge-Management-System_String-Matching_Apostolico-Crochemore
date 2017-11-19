    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h3 class="my-4"><?php echo $ktp; ?></h3>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>profil" class="list-group-item active">Profil</a>
                    <a href="<?php echo base_url() ?>profil/ubah_profil" class="list-group-item">Ubah Profil</a>
                    <a href="<?php echo base_url() ?>profil/ubah_password" class="list-group-item">Ubah Password</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Profil
                    </div>
                    <div class="card-body">
                    <div class="row">
                            <div class="col-lg-4">
                            <?php
                                if($profil_karyawan->row()->foto == NULL)
                                {
                            ?>
                                <img src="<?php echo base_url(); ?>asset/image/nophoto.png" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $ktp; ?>" />
                            <?php
                                }
                                else
                                {
                            ?>
                                <img src="<?php echo base_url(); ?>upload/image/<?php echo $profil_karyawan->row()->foto; ?>" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $ktp; ?>" />
                            <?php 
                                }
                            ?>
                            </div>
                            <div class="col-lg-8">
                                <?php
                                    foreach($profil_karyawan->result() as $row)
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
                                </table>
                                <?php
                                    }
                                ?>
                                <p><strong>Data Jumlah Knowledge</strong></p>
                                <table class="table">
                                    <tr>
                                        <td>Explicit Knowledge</td>
                                        <td>:</td>
                                        <td><?php echo $jumlah_explicit; ?> buah</td>
                                    </tr>
                                    <tr>
                                        <td>Tacit Knowledge</td>
                                        <td>:</td>
                                        <td><?php echo $jumlah_tacit; ?> buah</td>
                                    </tr>
                                </table>
                                
                                <p><strong>Data Hak Akses</strong></p>
                                <ol>
                                    <?php
                                        foreach($hak_akses->result() as $row)
                                        {
                                    ?>
                                    <li><?php echo $row->nama_hak_akses; ?></li>
                                    <?php
                                        }
                                    ?>
                                </ol>
                                
                                <?php
                                    foreach($profil_karyawan->result() as $row)
                                    {
                                ?>
                                <p><strong>Data Tambahan</strong></p>
                                <table class="table">
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
                                    <tr>
                                        <td>Waktu Log In terakhir</td>
                                        <td>:</td>
                                        <td><?php echo date_format(new DateTime($row->login_terakhir), "d-M-Y H:i:s"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Akun dibuat oleh</td>
                                        <td>:</td>
                                        <td><a href="<?php echo base_url();?>profil/karyawan_lain/<?php echo $row->user_dibuat_oleh; ?>"><?php echo $row->user_dibuat_oleh; ?></a></td>
                                    </tr>
                                    <tr>
                                        <td>Akun dibuat pada</td>
                                        <td>:</td>
                                        <td><?php echo date_format(new DateTime($row->user_dibuat_pada), "d-M-Y H:i:s"); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Akun terakhir diperbarui oleh</td>
                                        <td>:</td>
                                        <td>
                                            <a href="<?php echo base_url();?>profil/karyawan_lain/<?php echo $row->user_diperbarui_oleh; ?>"><?php echo $row->user_diperbarui_oleh; ?></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Akun terakhir diperbarui pada</td>
                                        <td>:</td>
                                        <td><?php echo date_format(new DateTime($row->user_diperbarui_pada), "d-M-Y H:i:s"); ?></td>
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
    }