    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-lg-3">
                <img src="<?php echo base_url(); ?>asset/image/titian_sampurna.png" width="200" class="my-4 img-fluid mx-auto d-block" alt="Logo PT Titian Sampurna" />   
                <div class="list-group">
                    <a href="<?php echo base_url() ?>report/pegawai" class="list-group-item">Report Karyawan</a>
                    <a href="<?php echo base_url() ?>report/presentase" class="list-group-item">Report Knowledge Per Jabatan</a>
                    <a href="<?php echo base_url() ?>report/tacit" class="list-group-item">Report Tacit Knowledge</a>
                    <a href="<?php echo base_url() ?>report/explicit" class="list-group-item active">Report Explicit Knowledge</a>
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
                                <form method="post" action="<?php echo base_url(); ?>report/explicit_search">
                                    <div class="form-row">
                                        <div class="col">
                                            <input type="text" class="form-control" name="tahun_explicit" value="<?php echo $tahun_explicit; ?>" placeholder="Tahun (YYYY)" required="" />
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">Lihat</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row my-4">
                            <div class="col-lg-12">
                            <?php
                                if($search_result->num_rows() == 0)
                                {
                            ?>
                            <p>Karyawan belum memasukkan Explicit Knowledge pada tahun <?php echo $tahun_explicit ?>.</p>
                            <?php
                                }
                                else
                                {
                            ?>
 
                            <!-- Tabel sebagai rujukan chart -->
                            <table  id="table_id" class="highchart table display" data-graph-container-before="1" data-graph-type="column">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
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

                                        <td><?php echo $row->bulan; ?></td>
                                        <td><?php echo $row->jumlah_explicit; ?> buah</td>
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