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
                        Ubah Data Pribadi Karyawan dengan No. KTP : <?php echo $ktp; ?>
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
                                <br />
                                <form method="post" action="<?php echo base_url(); ?>karyawan/perbarui_foto_profil" enctype="multipart/form-data" />
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" name="userfile" accept="image/x-png, image/jpeg" aria-describedby="uploadHelpBlock" required="" />
                                        <small id="passwordHelpBlock" class="form-text text-muted">
                                            Ukuran foto maksimal 500kb dengan panjang maksimal 1024px dan lebar maksimal 1024px.
                                        </small>
                                    </div>
                                    <input type="hidden" name="ktp" value="<?php echo $ktp; ?>" />
                                    <button type="submit" class="btn btn-primary">Perbarui Foto Profil</button>
                                </form>
                                <hr />
                            </div>
                            <div class="col-lg-8">
                                <form action="<?php echo base_url();?>karyawan/perbarui_data_pribadi" method="post" id="form-regis">
                                    <?php
                                        foreach($profil_karyawan->result() as $row)
                                        {
                                    ?>
                                    <div class="form-group">
                                        <label>Nomor Kartu Tanda Penduduk</label>
                                        <p><a href="<?php echo base_url() ?>karyawan/profil/<?php echo $row->ktp; ?>"><?php echo $row->ktp; ?></a></p>
                                        <input type="hidden" value="<?php echo $row->ktp; ?>" name="ktp" />
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Induk Karyawan</label>
                                        <input type="text" class="form-control" value="<?php echo $row->nik; ?>" id="nik" name="nik" placeholder="Nomor Induk Karyawan" required="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" value="<?php echo $row->nama; ?>" id="nama" name="nama" placeholder="Nama Lengkap" required="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" value="<?php echo $row->email; ?>" name="email" placeholder="Email" required="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Nomor Handphone</label>
                                        <input type="text" class="form-control" value="<?php echo $row->no_hp; ?>" id="no_hp" name="no_hp" placeholder="Nomor Handphone" required="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea class="form-control" rows="3" id="alamat" name="alamat" placeholder="Alamat" required=""><?php echo $row->alamat; ?></textarea>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label>Divisi</label>
                                        <select name="id_divisi" class="form-control" id="divisi">
                                            <?php 
                                                foreach($divisi->result() as $row)
                                                {
                                            ?>
                                                <option <?php if($profil_karyawan->row()->id_divisi  == $row->id_divisi){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_divisi; ?>">
                                                    <?php echo $row->nama_divisi; ?>
                                                </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Jabatan</label>
                                        <select name="id_jabatan" class="form-control" id="jabatan">
                                            <?php 
                                                foreach($jabatan->result() as $row)
                                                {
                                                ?>
                                                <option <?php if($profil_karyawan->row()->id_jabatan  == $row->id_jabatan){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_jabatan; ?>">
                                                    <?php echo $row->nama_jabatan; ?>
                                                </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Perbarui Data Pribadi</button>
                                </form>
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