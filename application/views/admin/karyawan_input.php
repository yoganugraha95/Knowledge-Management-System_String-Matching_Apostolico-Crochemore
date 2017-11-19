    <!-- Styling validasi form tambah karyawan -->
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
                <h1 class="my-4">Karyawan</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>karyawan/daftar" class="list-group-item">Daftar Karyawan</a>
                    <a href="<?php echo base_url() ?>karyawan/input" class="list-group-item active">Tambah Karyawan</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Tambah Karyawan
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url();?>karyawan/add" method="post" id="form-regis">
                            <div class="form-group">
                                <label>Nomor Kartu Tanda Penduduk</label>
                                <input type="text" class="form-control" id="ktp" name="ktp" placeholder="Nomor Kartu Tanda Penduduk" required="" />
                            </div>
                            <div class="form-group">
                                <label>Nomor Induk Karyawan</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Nomor Induk Karyawan" required="" />
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required="" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required="" />
                            </div>
                            <div class="form-group">
                                <label>Nomor Handphone</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Handphone" required="" />
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" rows="3" id="alamat" name="alamat" placeholder="Alamat" required=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>Divisi</label>
                                <select name="id_divisi" class="form-control" id="divisi">
                                    <?php 
                                        foreach($divisi->result() as $row)
                                        {
                                    ?>
                                    <option value="<?php echo $row->id_divisi; ?>"><?php echo $row->nama_divisi; ?></option>
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
                                    <option value="<?php echo $row->id_jabatan; ?>"><?php echo $row->nama_jabatan; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Hak Akses</label>
                                <br />
                                <?php
                                    foreach($hak_akses->result() as $row)
                                    {
                                ?>
                                    <input class="form-group" type="checkbox" name="id_hak_akses[]" value="<?php echo $row->id_hak_akses; ?>" /> <?php echo $row->nama_hak_akses; ?>&nbsp;
                                <?php
                                    }    
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" id="password" size="15" class="required"/>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input type="password" class="form-control" placeholder="Konfirmasi Password"  name="passconf" id="passconf" size="15" class="required"/>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->

        </div>

    </div>
    <!-- /.container -->