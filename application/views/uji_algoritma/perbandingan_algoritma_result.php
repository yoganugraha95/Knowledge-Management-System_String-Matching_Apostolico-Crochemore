    <?php
        $total_kata_ditemukan_di_explicit = NULL;
        $total_kata_ditemukan_di_tacit    = NULL;         
    ?>        
    
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
                                        <input type="text" class="form-control" value="<?php echo $kata_kunci; ?>" name="kata_kunci_perbandingan" placeholder="Kata Kunci" required=""/>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                </form>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-lg-12">
                                <?php 
                                    if(($search_tacit == NULL) && ($search_explicit == NULL))
                                    {
                                ?>
                                <p>Hasil pencarian <strong><?php echo $kata_kunci ?></strong> tidak ditemukan.</p>
                                <?php
                                    }
                                    else
                                    {                                        
                                        foreach($search_explicit as $row_explicit)
                                        {   
                                            $dokumen    = $row_explicit->file_dokumen;
                                            $a          = new Decode();
                                            $a->setFilename('./upload/pdf/'.$dokumen);
                                            $a->decodePDF();
                                            $explicit   = $a->output();
                                            $explicit   = strtolower($explicit); 
                                            
                                            $kata_kunci     = preg_replace('/\s+/', ' ', trim($kata_kunci));
                                            $words          = explode(' ', $kata_kunci);
                                            $highlighted    = array();
                                            
                                            $total_kata_ditemukan_di_explicit = 0;
                                            foreach ($words as $word)
                                            {
                                                $highlighted[] = "<font color='#000'><strong>".$word."</strong></font>";
                                                $titik_awal     = strpos($explicit, $word);
                                            }
                                            
                                            $explicit = substr($explicit, $titik_awal);
                                            $explicit = strtr($explicit, array_combine($words, $highlighted));
                                            $explicit = utf8_encode($explicit);                                           
                                            $explicit = word_limiter($explicit, 50);                                            
                                            
                                ?>
                                <div class="row mb-1">
                                    <div class="col-lg-12">
                                        <strong><a href="<?php echo base_url();?>discovery/profil/<?php echo $row_explicit->id_explicit_knowledge; ?>"><?php echo $row_explicit->judul ?></a></strong><br />
                                        <small class="text-muted">Dibuat pada <?php echo date_format(new DateTime($row_explicit->dibuat_pada), "d-M-Y H:i:s"); ?> oleh <a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row_explicit->ktp; ?>"><?php echo $row_explicit->nama; ?></a></small>
                                        <p><?php echo $explicit; ?></p>
                                    </div>
                                </div>
                                <?php
                                        }
                                        
                                        foreach($search_tacit as $row_tacit)
                                        {
                                            $masalah            = $row_tacit->masalah;
                                            $solusi             = $row_tacit->solusi;
                                            
                                            $tacit_with_html    = $masalah.' '.$solusi;
                                            $tacit_             = new Html2Text($tacit_with_html);
                                            $tacit              = $tacit_->getText();
                                            
                                            $kata_kunci     = preg_replace('/\s+/', ' ', trim($kata_kunci));
                                            $words          = explode(' ', $kata_kunci);
                                            $highlighted    = array();
                                            
                                            $total_kata_ditemukan_di_tacit = 0;
                                            foreach ($words as $word)
                                            {
                                                $highlighted[] = "<font color='#000'><strong>".$word."</strong></font>";
                                            }
                                            
                                            foreach ($words as $word)
                                            {
                                                $titik_awal     = strpos($tacit, $word);
                                                $titik_akhir    = 50;
                                                if($titik_awal > 0)
                                                {
                                                    $titik_akhir = $titik_awal +250;
                                                    break;
                                                }
                                            }
                                            
                                            $tacit = substr($tacit, $titik_awal, $titik_akhir).' . . . .';
                                            $tacit = strtr($tacit, array_combine($words, $highlighted));
                                ?>
                                <div class="row mb-1">
                                    <div class="col-lg-12">
                                        <strong><a href="<?php echo base_url();?>capture/profil/<?php echo $row_tacit->id_tacit_knowledge; ?>"><?php echo $row_tacit->judul ?></a></strong><br />
                                        <small class="text-muted">Dibuat pada <?php echo date_format(new DateTime($row_tacit->dibuat_pada), "d-M-Y H:i:s"); ?> oleh <a href="<?php echo base_url(); ?>profil/karyawan_lain/<?php echo $row_tacit->ktp; ?>"><?php echo $row_tacit->nama; ?></a></small>
                                        <p><?php echo $tacit; ?></p> 
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                       </div>
                        <div class="row my-4">
                            <div class="col-lg-12">
                                <h6><strong>Hasil perbandingan waktu eksekusi Algoritma</strong></h6>
                                <table class="table">
                                    <tr>
                                        <td>Algoritma Apostolico Crochemore</td>
                                        <td>:</td>
                                        <td><?php echo $waktu_apostolico_crochemore; ?> detik</td>
                                    </tr>
                                    <tr>
                                        <td>Algoritma Brute Force</td>
                                        <td>:</td>
                                        <td><?php echo $waktu_brute_force; ?> detik</td>
                                    </tr>
                                </table>
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