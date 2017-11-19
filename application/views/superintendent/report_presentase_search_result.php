    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <div class="list-group">
                    <a href="<?php echo base_url() ?>report/pegawai" class="list-group-item">Report Karyawan</a>
                    <a href="<?php echo base_url() ?>report/presentase" class="list-group-item active">Report Knowledge Per Jabatan</a>
                    <a href="<?php echo base_url() ?>report/tacit" class="list-group-item">Report Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>report/explicit" class="list-group-item">Report Explicit Knowledge</a>
                </div>
            </div>
            <!-- /.col-lg-3 -->

            <div class="col-lg-9">

                <div class="card card-outline-secondary my-4">
                    <div class="card-header">
                        Report Knowledge Per Jabatan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="post" action="<?php echo base_url(); ?>report/presentase_search">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control datepicker" name="tanggal_presentase_mulai" value="<?php echo $tanggal_presentase_mulai; ?>" placeholder="Tanggal Mulai" required="" />
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control datepicker" name="tanggal_presentase_berakhir" value="<?php echo $tanggal_presentase_berakhir; ?>" placeholder="Tanggal Berakhir" required=""/>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                            <?php
                                if($search_result->num_rows() == 0)
                                {
                            ?>
                            <p><br/>Karyawan belum memasukkan Tacit Knowledge dan Explicit Knowledge pada <?php echo date_format(new DateTime($tanggal_presentase_mulai), "d-M-Y"); ?> s.d. <?php echo date_format(new DateTime($tanggal_presentase_berakhir), "d-M-Y"); ?>.</p>
                            <?php
                                }
                                else
                                {
                            ?>
                            <p><br/>Berikut adalah Grafik Pie jumlah knowledge berdasarkan jabatan pada <?php echo date_format(new DateTime($tanggal_presentase_mulai), "d-M-Y"); ?> s.d. <?php echo date_format(new DateTime($tanggal_presentase_berakhir), "d-M-Y"); ?>.</p>
                            <!-- Tabel sebagai rujukan chart -->
                            <table  id="table_id" class="highchart table display" data-graph-container-before="1" data-graph-type="pie">
                                <thead>
                                    <tr>
                                        <th>Nama Jabatan</th>
                                        <th>Jumlah Knowledge</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                                    $no = 1;
                                    foreach($search_result->result() as $row)
                                    {
                            ?>
                                    <tr>

                                        <td><?php echo $row->nama_jabatan; ?></td>
                                        <td><?php echo $row->jumlah_knowledge; ?> buah</td>
                                    </tr>
                            <?php    
                                    $no++;        
                                    }
                            ?>
                                </tbody>
                            </table>
                            <!-- /Tabel sebagai rujukan chart -->
                            
                            <?php
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

<script>
$('.datepicker').Zebra_DatePicker();
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('table.highchart').highchartTable();
    });
</script>