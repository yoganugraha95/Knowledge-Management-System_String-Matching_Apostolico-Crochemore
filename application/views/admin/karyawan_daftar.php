    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Karyawan</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>karyawan/daftar" class="list-group-item active">Daftar Karyawan</a>
                    <a href="<?php echo base_url() ?>karyawan/input" class="list-group-item">Tambah Karyawan</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Daftar Karyawan
                    </div>
                    <div class="card-body">
                    <?php
                        if($daftar_karyawan->num_rows() == 0)
                        {
                    ?>
                        <p>Data Karyawan belum ditambahkan.</p>
                    <?php
                        }
                        else
                        {
                    ?>
                    <table id="table_id" class="table display">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. KTP</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                            $no = 1;
                            foreach($daftar_karyawan->result() as $row)
                            {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><a href="<?php echo base_url();?>karyawan/profil/<?php echo $row->ktp; ?>" title="<?php echo $row->ktp;?>"><?php echo $row->ktp; ?></a></td>
                                <td><?php echo $row->nik; ?></td>
                                <td><?php echo $row->nama; ?></td>
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
                    <?php
                            $no++;
                            }
                    ?>
                        </tbody>
                    </table>
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