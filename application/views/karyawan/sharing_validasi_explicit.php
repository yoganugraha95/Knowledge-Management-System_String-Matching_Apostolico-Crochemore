    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Sharing</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>sharing/proses" class="list-group-item">Cari Knowledge</a>
                    <?php
                        if($hak_akses_karyawan_ahli ==  'TRUE')
                        {
                    ?>
                    <a href="<?php echo base_url() ?>sharing/validasi_tacit_knowledge" class="list-group-item">Validasi Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>sharing/validasi_explicit_knowledge" class="list-group-item active">Validasi Explicit Knowledge</a>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                
                
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Search Knowledge
                    </div>
                    <div class="card-body">
                    <?php
                        if($list_all_explicit_knowledge->num_rows() == 0)
                        {
                    ?>
                    <p>Tidak ada Tacit Knowledge yang perlui divalidasi.</p>
                    <?php
                        }
                        else
                        {
                    ?>
                    <table id="table_id" class="table display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Nama Pemilik</th>
                                <th>Divisi</th>
                                <th>Jabatan</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                            $no = 1;
                            foreach($list_all_explicit_knowledge->result() as $row)
                            {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><a href="<?php echo base_url(); ?>discovery/profil/<?php echo $row->id_explicit_knowledge; ?>"><?php echo $row->judul; ?></a></td>
                                <td><a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row->ktp; ?>"><?php echo $row->nama; ?></a></td>
                                <td><?php echo $row->nama_divisi; ?></td>
                                <td><?php echo $row->nama_jabatan; ?></td>
                                <td><?php echo date_format(new DateTime($row->dibuat_pada), "d-M-Y H:i:s"); ?></td>
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