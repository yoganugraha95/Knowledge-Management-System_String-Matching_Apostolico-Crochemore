    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Jabatan</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>jabatan/daftar" class="list-group-item active">Daftar Jabatan</a>
                    <a href="<?php echo base_url() ?>jabatan/input" class="list-group-item">Tambah Jabatan</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Daftar Jabatan
                    </div>
                    <div class="card-body">
                        <?php
                            foreach($jabatan->result() as $row)
                            {
                        ?>
                        <p>
                            <?php echo $row->nama_jabatan; ?>
                            <a data-toggle="modal" data-target="#edit_jabatan_<?php echo $row->id_jabatan;?>"><i class="fa fa-pencil"></i></a>&nbsp; 
                            <a data-toggle="modal" data-target="#delete_jabatan_<?php echo $row->id_jabatan;?>"><i class="fa fa-trash"></i></a>&nbsp; 
                        </p>
                        </p>
                        <small class="text-muted">Dibuat pada <?php echo date_format(new DateTime($row->dibuat_pada), "d-M-Y H:i:s") ?></small>
                        <hr />
                        
                        <!-- Modal Edit Divisi-->
                        <div class="modal fade" id="edit_jabatan_<?php echo $row->id_jabatan;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post" action="<?php echo base_url();?>jabatan/update">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $row->nama_jabatan; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input type="text" name="nama_jabatan" value="<?php echo $row->nama_jabatan; ?>" class="form-control" placeholder="Nama jabatan" required="">
                                                <input type="hidden" name="id_jabatan" value="<?php echo $row->id_jabatan; ?>" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Perbarui</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Hapus jabatan-->
                        <div class="modal fade" id="delete_jabatan_<?php echo $row->id_jabatan;?>"" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Hapus <?php echo $row->nama_jabatan; ?>?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Jika anda menghapus data jabatan ini, maka seluruh pengguna dan knowledge yang berkaitan dengan jabatan ini akan ikut terhapus juga. Anda yakin?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                        <a class="btn btn-primary"  href="<?php echo base_url();?>jabatan/delete/<?php echo $row->id_jabatan; ?>"></i> Hapus</a>
                                    </div>
                                </div>
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