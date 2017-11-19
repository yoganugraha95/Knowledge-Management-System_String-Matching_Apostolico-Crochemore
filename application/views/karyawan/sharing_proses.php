    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Sharing</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>sharing/proses" class="list-group-item active">Cari Knowledge</a>
                    <?php
                        if($hak_akses_karyawan_ahli ==  'TRUE')
                        {
                    ?>
                    <a href="<?php echo base_url() ?>sharing/validasi_tacit_knowledge" class="list-group-item">Validasi Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>sharing/validasi_explicit_knowledge" class="list-group-item">Validasi Explicit Knowledge</a>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                
                
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Cari Knowledge
                    </div>
                    <div class="card-body">
                       <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo base_url(); ?>sharing/search_result" method="post">
                                    <div class="form-group">
                                        <label>Divisi</label>
                                        <select name="id_divisi" class="form-control" id="divisi">
                                            <?php 
                                                foreach($divisi->result() as $row)
                                                {
                                            ?>
                                            <option value="%">Semua Divisi</option>
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
                                            <option value="%">Semua Jabatan</option>
                                            <option value="<?php echo $row->id_jabatan; ?>"><?php echo $row->nama_jabatan; ?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kata Kunci</label>
                                        <input type="text" class="form-control" name="kata_kunci" placeholder="Kata Kunci" required=""/>
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
    <!-- /.container -->