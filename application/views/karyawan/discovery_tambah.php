    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Discovery</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>discovery/tambah" class="list-group-item active">Tambah Explicit Knowledge</a>
                    <a href="<?php echo base_url() ?>discovery/daftar" class="list-group-item">Daftar Explicit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                
                
               <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Tambah Explicit Knowledge
                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url(); ?>discovery/tambah_data" method="post" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="judul_explicit_knowledge">Judul</label>
                            <input type="text" class="form-control" id="judul_explicit_knowledge" name="judul" placeholder="Judul" required="" />
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
                                <input type="file" class="form-control-file" name="userfile" accept=".pdf" aria-describedby="uploadHelpBlock" required="" />
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Jenis Explicit Knowledge yang dapat diunggah hanya dalam bentuk PDF.
                                </small>
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