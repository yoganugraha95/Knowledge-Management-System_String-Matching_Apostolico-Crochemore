    <?php
        $total_kata_ditemukan_di_explicit = NULL;
        $total_kata_ditemukan_di_tacit    = NULL;         
    ?>        
    
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <h5 class="my-4">Uji Algoritma</h5>
                <div class="list-group">
                    <a href="<?php echo base_url() ?>uji/algoritma_apostolico_crochemore" class="list-group-item active">Apostolico Crochemore</a>
                    <a href="<?php echo base_url() ?>uji/perbandingan_algoritma" class="list-group-item">Perbandingan Algoritma</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">
                
                
                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Uji Recall dan Presicion
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo base_url(); ?>uji/algoritma_apostolico_crochemore_result" method="post">
                                    <div class="form-group">
                                        <label>Divisi</label>
                                        <select name="id_divisi" class="form-control" id="divisi">
                                            <?php 
                                                foreach($divisi->result() as $row)
                                                {
                                            ?>
                                            <option value="%">Semua Divisi</option>
                                            <option <?php if($id_divisi  == $row->id_divisi){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_divisi; ?>">
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
                                            <option value="%">Semua Jabatan</option>
                                            <option <?php if($id_jabatan  == $row->id_jabatan){ ?> selected="selected" <?php } ?> value="<?php echo $row->id_jabatan; ?>">
                                                <?php echo $row->nama_jabatan; ?>
                                            </option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kata Kunci</label>
                                        <input type="text" class="form-control" value="<?php echo $kata_kunci; ?>" name="kata_kunci" placeholder="Kata Kunci" required=""/>
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
                                                
                                                $jumlah_kata_ditemukan_di_explicit = count(apostolico_crochemore($explicit, $word));
                                                $total_kata_ditemukan_di_explicit += $jumlah_kata_ditemukan_di_explicit;
                                                
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
                                        <p>Jumlah kata yang ditemukan : <strong><?php echo $total_kata_ditemukan_di_explicit; ?> buah.</strong></p>
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
                                                
                                                $jumlah_kata_ditemukan_di_tacit = count(apostolico_crochemore($tacit, $word));
                                                $total_kata_ditemukan_di_tacit += $jumlah_kata_ditemukan_di_tacit;
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
                                        <p>Jumlah kata yang ditemukan : <strong><?php echo $total_kata_ditemukan_di_tacit; ?> buah</strong>.</p>
                                    </div>
                                </div>
                                <?php
                                        }
                                    }
                                ?>
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
    
    <!-- Fungsi Algoritma Apostolico Crochemore untuk menghitung jumlah kata yang ditemukan -->
    <?php
   //Algoritma Apostolico Crochemore, dimulai
   	function preprocessing($x, $m, &$kmpNext)
    {
    	$len   = 0;
    	$i     = 1;
    
    	$kmpNext[0] = 0;
    
    	while ($i < $m)
    	{
    		if ($x[$i] == $x[$len])
    		{
    			$len++;
    			$kmpNext[$i] = $len;
    			$i++;
    		}
    		else
    		{
    			if ($len != 0)
    			{
    				$len = $kmpNext[$len - 1];
    			}
    			else
    			{
    				$kmpNext[$i] = 0;
    				$i++;
    			}
    		}
    	}
    }

	function apostolico_crochemore($y, $x) 
    {
   	    $return_array  = array();
    	$m             = strlen($x);
    	$n             = strlen($y);
    	$i             = 0;
    	$j             = 0;
        
		$kmpNext = array();
		
		/* Preprocessing */
		$kmpNext = preprocessing($x, $m, $kmpNext);
		for($ell = 1; $x[$ell - 1] == $x[$ell]; $ell++);
		if($ell == $m)
			$ell = 0;
		
		/* Searching */
		$i = $ell;
		$j = $k = 0;
		while ($j <= $n - $m) 
        {
			while ($i < $m && $x[$i] == $y[$i + $j])
				++$i; 
			if ($i >= $m) 
            {
				while ($k < $ell && $x[$k] == $y[$j + $k])
					++$k;
				if ($k >= $ell)
					array_push($return_array, $j);
			}

			$j += ($i - $kmpNext[$i]);
			if ($i == $ell)
				$k = max(0, $k - 1);
			else
				if ($kmpNext[$i] <= $ell) 
                {
					$k = max(0, $kmpNext[$i]);
					$i = $ell;
				}
				else 
                {
					$k = $ell;
					$i = $kmpNext[$i];
				}
		}
        return $return_array;
	}
    //Algoritma Apostolico Crochemore, berakhir
    ?>