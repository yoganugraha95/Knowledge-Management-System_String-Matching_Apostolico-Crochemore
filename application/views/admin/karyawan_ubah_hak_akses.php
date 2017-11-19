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
                        Ubah Hak Akses Karyawan dengan No. KTP : <?php echo $ktp; ?>
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
                                <p><strong>Hak Akses</strong></p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Hak Akses</th>
                                            <th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        foreach($hak_akses_aktif->result() as $row)
                                        {
                                    ?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $row->nama_hak_akses; ?></td>
                                        <td><a data-toggle="modal" data-target="#delete_hak_akses_<?php echo $row->id_grup_user;?>"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    
                                    <!-- Modal Hapus Hak Akses-->
                                    <div class="modal fade" id="delete_hak_akses_<?php echo $row->id_grup_user;?>"" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Hapus Hak Akses <?php echo $row->nama_hak_akses; ?>?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <a class="btn btn-primary"  href="<?php echo base_url();?>karyawan/hapus_hak_akses/<?php echo $row->ktp ?>/<?php echo $row->id_grup_user; ?>"></i> Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $no++;
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <hr />
                                
                                <?php
                                    if($hak_akses_non_aktif->num_rows() > 0)
                                    {
                                ?>
                                <form action="<?php echo base_url();?>karyawan/tambah_hak_akses" method="post">
                                    <div class="form-group">
                                        <select name="id_hak_akses" class="form-control" id="id_hak_akses">
                                            <?php 
                                                foreach($hak_akses_non_aktif->result() as $row)
                                                {
                                            ?>
                                            <option value="<?php echo $row->id_hak_akses; ?>"><?php echo $row->nama_hak_akses; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="ktp" value="<?php echo $ktp; ?>" />
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </form>
                                <?php
                                    }
                                ?>
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