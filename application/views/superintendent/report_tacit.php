    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <div class="list-group">
                    <a href="<?php echo base_url() ?>report/pegawai" class="list-group-item">Report Karyawan</a>
                    <a href="<?php echo base_url() ?>report/presentase" class="list-group-item">Report Knowledge Per Jabatan</a>
                    <a href="<?php echo base_url() ?>report/tacit" class="list-group-item active">Report Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>report/explicit" class="list-group-item">Report Explicit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Report Tacit Knowledge
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="post" action="<?php echo base_url(); ?>report/tacit_search">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="tahun_tacit" placeholder="Tahun (YYYY)" required=""/>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </div>
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