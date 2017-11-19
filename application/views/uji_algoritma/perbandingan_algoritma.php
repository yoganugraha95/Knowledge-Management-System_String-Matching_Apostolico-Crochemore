    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h5 class="my-4">Perbandingan Algoritma</h5>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>uji/algoritma_apostolico_crochemore" class="list-group-item">Apostolico Crochemore</a>
                    <a href="<?php echo base_url() ?>uji/perbandingan_algoritma" class="list-group-item active">Perbandingan Algoritma</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                
                
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Perbandingan Waktu Algoritma
                    </div>
                    <div class="card-body">
                       <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo base_url(); ?>uji/perbandingan_algoritma_result" method="post">
                                    <div class="form-group">
                                        <label>Kata Kunci</label>
                                        <input type="text" class="form-control" name="kata_kunci_perbandingan" placeholder="Kata Kunci" required=""/>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
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
    <!-- /.container -->/