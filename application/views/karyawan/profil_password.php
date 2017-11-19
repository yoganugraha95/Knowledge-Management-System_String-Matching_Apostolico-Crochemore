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
                    <a href="<?php echo base_url() ?>profil" class="list-group-item">Profil</a>
                    <a href="<?php echo base_url() ?>profil/ubah_profil" class="list-group-item">Ubah Profil</a>
                    <a href="<?php echo base_url() ?>profil/ubah_password" class="list-group-item active">Ubah Password</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Ubah Password
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <form action="<?php echo base_url();?>profil/perbarui_password" method="post" id="form-password">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Password" name="password" id="password" size="15" class="required"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" class="form-control" placeholder="Konfirmasi Password"  name="passconf" id="passconf" size="15" class="required"/>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Perbarui</button>
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