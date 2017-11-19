    <!-- Page Content -->
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Jabatan</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>jabatan/daftar" class="list-group-item">Daftar Jabatan</a>
                    <a href="<?php echo base_url() ?>jabatan/input" class="list-group-item active">Tambah Jabatan</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Tambah Jabatan
                    </div>
                    <div class="card-body">
                    <form method="post" action="<?php echo base_url();?>jabatan/add">
                        <div class="form-group">
                            <input type="text" name="nama_jabatan" value="" class="form-control" placeholder="Nama Jabatan" required="">
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