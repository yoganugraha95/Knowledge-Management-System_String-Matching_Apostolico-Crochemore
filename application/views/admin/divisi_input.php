    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Divisi</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>divisi/daftar" class="list-group-item">Daftar Divisi</a>
                    <a href="<?php echo base_url() ?>divisi/input" class="list-group-item active">Tambah Divisi</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Tambah Divisi
                    </div>
                    <div class="card-body">
                    <form method="post" action="<?php echo base_url();?>divisi/add">
                        <div class="form-group">
                            <input type="text" name="nama_divisi" value="" class="form-control" placeholder="Nama Divisi" required="">
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