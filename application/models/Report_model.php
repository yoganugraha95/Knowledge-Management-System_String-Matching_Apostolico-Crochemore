<?php
class Report_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function report_pegawai($tanggal_pegawai_mulai, $tanggal_pegawai_berakhir)
    {
        $query  = $this->db->query("
                                    SELECT
                                    	a.nama																								nama,
                                        a.ktp																								ktp,
                                        b.nama_divisi																						nama_divisi,
                                        c.nama_jabatan																						nama_jabatan,
                                        (SELECT COUNT(id_tacit_knowledge) FROM tacit_knowledge 
                                         WHERE ktp = a.ktp  
                                         AND DATE(dibuat_pada) BETWEEN '$tanggal_pegawai_mulai' AND '$tanggal_pegawai_berakhir'
                                         AND status_validasi = 'TRUE')			    														jumlah_tacit_knowledge,
                                        (SELECT COUNT(id_explicit_knowledge) FROM explicit_knowledge 
                                         WHERE ktp = a.ktp 
                                         AND DATE(dibuat_pada) BETWEEN '$tanggal_pegawai_mulai' AND '$tanggal_pegawai_berakhir'
                                         AND status_validasi = 'TRUE')																		jumlah_explicit_knowledge								
                                    FROM
                                    	user a 
                                    INNER JOIN
                                    	divisi b
                                    ON a.id_divisi = b.id_divisi
                                    INNER JOIN
                                    	jabatan c
                                    ON a.id_jabatan = c.id_jabatan  
                                    ORDER BY a.nama                               
                                    ");
        return $query;
    }
    
    function report_presentase($tanggal_presentase_mulai, $tanggal_presentase_berakhir)
    {
        $query  = $this->db->query("
                                    SELECT
                                        nama_jabatan			nama_jabatan,
                                        COUNT(id_knowledge)     jumlah_knowledge
                                    FROM
                                    (
                                        SELECT
                                            a.id_tacit_knowledge	id_knowledge,
                                            b.nama_jabatan			nama_jabatan,
                                            a.dibuat_pada			dibuat_pada,
                                            a.status_validasi		status_validasi
                                        FROM
                                            tacit_knowledge a
                                        INNER JOIN
                                            jabatan b
                                        ON a.id_jabatan = b.id_jabatan
                                        UNION
                                        SELECT
                                            c.id_explicit_knowledge	id_knowledge,
                                            d.nama_jabatan			nama_jabatan,
                                            c.dibuat_pada			dibuat_pada,
                                            c.status_validasi		status_validasi
                                        FROM
                                            explicit_knowledge c
                                        INNER JOIN
                                            jabatan d
                                        ON c.id_jabatan = d.id_jabatan
                                    ) knowledge_per_jabatan
                                    WHERE status_validasi = 'TRUE'
                                    AND DATE(dibuat_pada) BETWEEN '$tanggal_presentase_mulai' AND '$tanggal_presentase_berakhir'
                                    GROUP BY nama_jabatan
                                    ");
        return $query;
    }
    
    function report_tacit($tahun_tacit)
    {   
        $query  = $this->db->query("
                                    SELECT 
                                        DATE_FORMAT(dibuat_pada, '%m-%Y')   bulan, 
                                        COUNT(judul)                        jumlah_tacit
                                        FROM tacit_knowledge 
                                    WHERE dibuat_pada like '%$tahun_tacit%'
                                    GROUP BY DATE_FORMAT(dibuat_pada, '%m-%Y')
                                    ");
        return $query;
    }
    
    function report_explicit($tahun_explicit)
    {   
        $query  = $this->db->query("
                                    SELECT 
                                        DATE_FORMAT(dibuat_pada, '%m-%Y')   bulan, 
                                        COUNT(judul)                        jumlah_explicit
                                        FROM explicit_knowledge 
                                    WHERE dibuat_pada like '%$tahun_explicit%'
                                    GROUP BY DATE_FORMAT(dibuat_pada, '%m-%Y')
                                    ");
        return $query;
    }
}