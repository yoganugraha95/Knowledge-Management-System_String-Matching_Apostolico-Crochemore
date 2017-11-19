    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Tacit Knowledge</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>capture/tambah" class="list-group-item">Tambah Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>capture/daftar" class="list-group-item active">Daftar Tacit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        <h6><strong><?php echo $judul_tacit_knowledge; ?></strong></h6>
                        <small class="text-muted">Dibuat pada <?php echo date_format(new DateTime($waktu_publikasi_tacit_knowledge), "d-M-Y H:i:s"); ?></small>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mx-auto mb-3">
                            <?php
                                if(($hak_sunting_dan_hapus_tacit_knowledge == 'TRUE') && ($hak_validasi_tacit_knowledge != 'TRUE'))
                                {
                            ?>
                                <a class="btn btn-primary" href="<?php echo base_url(); ?>capture/ubah/<?php echo $id_tacit_knowledge; ?>" role="button">Ubah</a>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#hapus_tacit_knowledge_<?php echo $id_tacit_knowledge;?>" role="button">Hapus</a>
                            <?php
                                }    
                                if($hak_validasi_tacit_knowledge == 'TRUE')
                                {
                            ?>  
                                <a class="btn btn-primary" href="<?php echo base_url(); ?>capture/ubah/<?php echo $id_tacit_knowledge; ?>" role="button">Ubah</a>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#hapus_tacit_knowledge_<?php echo $id_tacit_knowledge;?>" role="button">Hapus</a>
                                <a class="btn btn-primary" href="<?php echo base_url(); ?>capture/validasi/<?php echo $id_tacit_knowledge; ?>" role="button">Validasi</a>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                        <?php
                            foreach($profil_tacit_knowledge->result() as $row)
                            {
                        ?>
                        <div class="row mb-2">
                                <div class="col-lg-12">
                                <article>
                                    <h6><strong>Masalah</strong></h6>
                                    <?php echo $row->masalah; ?>
                                    
                                    <h6><strong>Solusi</strong></h6>
                                    <?php echo $row->solusi; ?>
                                </article>    
                            </div>                    
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                  Lihat Data Lain Knowledge ini
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $row->judul; ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <table class="table">
                                            <tr>
                                                <td>Jenis Knowledge</td>
                                                <td>:</td>
                                                <td>Tacit Knowledge</td>
                                            </tr>
                                            <tr>
                                                <td>Nama Pemilik</td>
                                                <td>:</td>
                                                <td><a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row->ktp; ?>"><?php echo $row->nama; ?></a></td>
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
                                                <td>Dibuat Pada</td>
                                                <td>:</td>
                                                <td><?php echo date_format(new DateTime($row->dibuat_pada), "d-M-Y H:i:s"); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Diperbarui Pada</td>
                                                <td>:</td>
                                                <td>
                                                    <?php 
                                                        if($row->diperbarui_pada != '0000-00-00 00:00:00')
                                                        {
                                                            echo date_format(new DateTime($row->diperbarui_pada), "d-M-Y H:i:s"); 
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Diperbarui Oleh</td>
                                                <td>:</td>
                                                <td><a href=""><?php echo $row->diperbarui_oleh ?></a></td>
                                            </tr>
                                            <tr>
                                                <td>Status Validasi</td>
                                                <td>:</td>
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
                                            <tr>
                                                <td>Divalidasi Pada</td>
                                                <td>:</td>
                                                <td><?php 
                                                        if($row->divalidasi_pada != '0000-00-00 00:00:00')
                                                        {
                                                            echo date_format(new DateTime($row->divalidasi_pada), "d-M-Y H:i:s"); 
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Divalidasi Oleh</td>
                                                <td>:</td>
                                                <td><a href=""><?php echo $row->divalidasi_oleh; ?></a></td>
                                            </tr>
                                        </table>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                        <hr />
                        <div class="row my-4">
                            <div class="col-lg-9">
                                <form action="<?php echo base_url(); ?>capture/tambah_komentar" method="post">
                                    <div class="form-group">
                                        <label><strong>Komentar</strong></label>
                                        <textarea class="form-control" rows="3" name="komentar" placeholder="Beri komentar" required=""></textarea>
                                    </div>
                                    <input type="hidden" name="id_tacit_knowledge" value="<?php echo $id_tacit_knowledge; ?>" />
                                    <button type="submit" id="comment_button" class="btn btn-primary">Tambah</button>
                                </form>
                            </div>
                        </div>
                        <div class="row pre-scrollable">
                            <div class="comments col-md-9" id="comments">
                                <?php
                                    foreach($komentar_tacit_knowledge->result() as $row)
                                    {
                                ?>
                                <!-- Kotak Komentar -->
                                <div class="comment mb-2 row">
                                    <div class="comment-avatar col-md-1 col-sm-2 text-center pr-1">
                                        <a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row->ktp; ?>">
                                        <?php
                                            if($row->foto == NULL)
                                            {
                                        ?>
                                            <img src="<?php echo base_url(); ?>asset/image/nophoto.png" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $row->ktp; ?>" />
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                            <img src="<?php echo base_url(); ?>upload/image/<?php echo $row->foto; ?>" class="img-fluid rounded mx-auto d-block" alt="Foto Karyawan dengan No. KTP : <?php echo $row->ktp; ?>" />
                                        <?php 
                                            }
                                        ?>
                                        </a>
                                    </div>
                                    <div class="comment-content col-md-11 col-sm-10">
                                        <h6 class="small comment-meta">
                                            <a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row->ktp; ?>"><?php echo $row->nama; ?></a>&nbsp;<?php echo date_format(new DateTime($row->dibuat_pada), "d-M-Y H:i:s"); ?>&nbsp;&nbsp;
                                        <?php
                                        if(($ktp_session == $row->ktp) || ($ktp_pembuat_tacit_knowledge == $ktp_session))
                                        {
                                        ?>
                                            <a data-toggle="modal" data-target="#hapus_komen_<?php echo $row->id_komentar_tacit_knowledge; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        <?php
                                        }
                                        ?>
                                        </h6>
                                        <div class="comment-body">
                                            <p><?php echo $row->komentar; ?>
                                                <br />
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Kotak Komentar -->
                                
                                    <?php
                                        if(($ktp_session == $row->ktp) || ($ktp_pembuat_tacit_knowledge == $ktp_session))
                                        {
                                    ?>                                
                                <!-- Modal Hapus Komentar -->
                                <div class="modal fade" id="hapus_komen_<?php echo $row->id_komentar_tacit_knowledge; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Hapus komentar ini?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <a class="btn btn-primary" href="<?php echo base_url(); ?>capture/hapus_komentar/<?php echo $row->id_komentar_tacit_knowledge; ?>"></i> Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <?php
                                        }
                                        ?>                                
                                <!-- /Modal Hapus Komentar -->
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
    
        <!-- Modal Hapus Tacit Knowledge-->
        <div class="modal fade" id="hapus_tacit_knowledge_<?php echo $id_tacit_knowledge;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Hapus <?php echo $judul_tacit_knowledge; ?>?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin ingin menghapus Tacit Knowledge ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary"  href="<?php echo base_url();?>capture/hapus/<?php echo $id_tacit_knowledge; ?>"></i> Hapus</a>
                    </div>
                </div>
            </div>
        </div>