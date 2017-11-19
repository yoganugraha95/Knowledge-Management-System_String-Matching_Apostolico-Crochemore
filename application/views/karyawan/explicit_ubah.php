    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h1 class="my-4">Explicit Knowledge</h1>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>discovery/tambah" class="list-group-item">Tambah Explicit Knowledge</a>
                    <a href="<?php echo base_url() ?>discovery/daftar" class="list-group-item active">Daftar Explicit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->
            
            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        <h6><strong><a href="<?php echo base_url(); ?>discovery/profil/<?php echo $id_explicit_knowledge; ?>"><?php echo $judul_explicit_knowledge; ?></a></strong></h6>
                    </div>
                    <div class="card-body">
                    <div class="card-body">
                        <form action="<?php echo base_url(); ?>discovery/perbarui" method="post" enctype="multipart/form-data">
                        <?php
                            foreach($profil_explicit_knowledge->result() as $row)
                            {
                        ?>
                            <div class="form-group">
                                <label for="judul_tacit_knowledge">Judul</label>
                                <input type="text" class="form-control" value="<?php echo $row->judul; ?>" id="judul_tacit_knowledge" name="judul" placeholder="Judul" required="" />
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
                                        <option <?php if($profil_explicit_knowledge->row()->id_divisi  == $row->id_divisi){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_divisi; ?>">
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
                                    <option <?php if($profil_explicit_knowledge->row()->id_jabatan  == $row->id_jabatan){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_jabatan; ?>">
                                        <?php echo $row->nama_jabatan; ?>
                                    </option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                          <?php
                            foreach($profil_explicit_knowledge->result() as $row)
                            {
                          ?>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="userfile" accept=".pdf" aria-describedby="uploadHelpBlock" required="" />
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Jenis Explicit Knowledge yang dapat diunggah hanya dalam bentuk PDF.
                                </small>
                            </div>
                            <input type="hidden" value="<?php echo $row->id_explicit_knowledge; ?>" name="id_explicit_knowledge" />
                          <?php
                            }
                          ?>
                          <button type="submit" class="btn btn-primary">Perbarui</button>
                        </form>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-lg-9 -->

        </div>

    </div>
    <!-- /.container -->
    