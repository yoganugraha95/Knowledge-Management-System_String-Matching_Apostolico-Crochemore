    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Explicit Knowledge</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>discovery/tambah" class="list-group-item">Tambah Explicit Knowledge</a>
                    <a href="<?php echo base_url() ?>discovery/daftar" class="list-group-item active">Daftar Explicit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Daftar Explicit Knowledge
                    </div>
                    <div class="card-body">
                    <?php
                        if($daftar_explicit_knowledge->num_rows() == 0)
                        {
                    ?>
                        <p>Data Explicit Knowledge belum ditambahkan.</p>
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
                                <th>Waktu</th>
                                <th>Status Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                            $no = 1;
                            foreach($daftar_explicit_knowledge->result() as $row)
                            {
                    ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><a href="<?php echo base_url();?>discovery/profil/<?php echo $row->id_explicit_knowledge; ?>" title="<?php echo $row->judul;?>"><?php echo $row->judul; ?></a></td>
                                <td><?php echo date_format(new DateTime($row->dibuat_pada), "d-M-Y H:i:s"); ?></td></td>
                                <td>
                                    <?php
                                        if($row->status_validasi == 'TRUE')
                                        {
                                            echo 'Telah divalidasi';
                                        }
                                        else
                                        {
                                            echo 'Belum divalidasi';
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