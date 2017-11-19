<?php
class Tacit_knowledge_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 
    
    function hitung_jumlah_tacit_by_ktp($ktp)
    {
        $query  = $this->db->query("
                                    SELECT
                                        COUNT(*) jumlah_tacit
                                    FROM 
                                        tacit_knowledge
                                    WHERE ktp = '$ktp'
                                    ");
        return $query->row()->jumlah_tacit;   
    }
    
    function input_tacit_knowledge($array_data_tacit)
    {
        $this->db->insert('tacit_knowledge', $array_data_tacit);
    }
    
    function list_all_not_validated_tacit_knowledge()
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_tacit_knowledge     id_tacit_knowledge,
                                        a.ktp                       ktp,
                                        d.nama                      nama,
                                        a.judul                     judul,
                                        b.nama_divisi               nama_divisi,
                                        c.nama_jabatan              nama_jabatan,
                                        a.dibuat_pada               dibuat_pada,
                                        a.dibuat_oleh               dibuat_oleh
                                    FROM 
                                            tacit_knowledge a
                                    INNER JOIN
                                            divisi b
                                    ON
                                        a.id_divisi = b.id_divisi
                                    INNER JOIN
                                        jabatan c
                                    ON
                                        a.id_jabatan = c.id_jabatan
                                    INNER JOIN
                                        user d
                                    ON a.ktp = d.ktp
                                    WHERE a.status_validasi = 'FALSE'
                                       ");
        return $query;
    }
        
    function list_tacit_knowledge_by_ktp($ktp)
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_tacit_knowledge    id_tacit_knowledge,
                                        a.ktp                   ktp,
                                        a.judul                 judul,
                                        a.id_divisi             id_divisi,
                                        b.nama_divisi           nama_divisi,
                                        a.id_jabatan            id_jabatan,
                                        c.nama_jabatan          nama_jabatan,
                                        a.masalah               masalah,
                                        a.solusi                solusi,
                                        a.dibuat_pada           dibuat_pada,
                                        a.dibuat_oleh           dibuat_oleh,
                                        a.diperbarui_pada       diperbarui_pada,
                                        a.diperbarui_oleh       diperbarui_oleh,
                                        a.status_validasi       status_validasi,
                                        a.divalidasi_oleh       divalidasi_oleh,
                                        a.divalidasi_pada       divalidasi_pada
                                    FROM 
                                        tacit_knowledge a
                                    INNER JOIN
                                        divisi b
                                    ON
                                        a.id_divisi = b.id_divisi
                                    INNER JOIN
                                        jabatan c
                                    ON
                                        a.id_jabatan = c.id_jabatan
                                    WHERE a.ktp = '$ktp'
                                   ");
        return $query;
    }
    
    function profil_tacit_knowledge($id_tacit_knowldge)
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_tacit_knowledge    id_tacit_knowledge,
                                        a.ktp                   ktp,
                                        d.nama                  nama,
                                        a.judul                 judul,
                                        a.id_divisi             id_divisi,
                                        b.nama_divisi           nama_divisi,
                                        a.id_jabatan            id_jabatan,
                                        c.nama_jabatan          nama_jabatan,
                                        a.masalah               masalah,
                                        a.solusi                solusi,
                                        a.dibuat_pada           dibuat_pada,
                                        a.dibuat_oleh           dibuat_oleh,
                                        a.diperbarui_pada       diperbarui_pada,
                                        a.diperbarui_oleh       diperbarui_oleh,
                                        a.status_validasi       status_validasi,
                                        a.divalidasi_oleh       divalidasi_oleh,
                                        a.divalidasi_pada       divalidasi_pada
                                    FROM 
                                        tacit_knowledge a
                                    INNER JOIN
                                        divisi b
                                    ON
                                        a.id_divisi = b.id_divisi
                                    INNER JOIN
                                        jabatan c
                                    ON
                                        a.id_jabatan = c.id_jabatan
                                    INNER JOIN
                                        user d
                                    ON a.ktp = d.ktp
                                    WHERE a.id_tacit_knowledge = '$id_tacit_knowldge'
                                   ");
        return $query;
    }
    
    function update_tacit_knowledge($array_data_tacit, $id_tacit_knowledge)
    {
        $this->db->where('id_tacit_knowledge', $id_tacit_knowledge);
        $this->db->update('tacit_knowledge', $array_data_tacit);
    }
    
    function delete_tacit_knowledge($id_tacit_knowledge)
    {
        $this->db->where('id_tacit_knowledge', $id_tacit_knowledge);
        $this->db->delete('tacit_knowledge');
    }
    
    function search_tacit_knowledge($id_divisi, $id_jabatan, $limit, $offset)
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_tacit_knowledge    id_tacit_knowledge,
                                        a.judul                 judul,
                                        b.ktp                   ktp,
                                        b.nama                  nama,
                                        a.masalah               masalah,
                                        a.solusi                solusi,
                                        a.dibuat_pada           dibuat_pada
                                    FROM
                                        tacit_knowledge a
                                    INNER JOIN
                                        user b
                                    ON
                                        a.ktp = b.ktp
                                    WHERE a.id_divisi like '$id_divisi'
                                    AND a.id_jabatan like '$id_jabatan'
                                    AND a.status_validasi = 'TRUE'
                                    LIMIT $offset, $limit
                                    ");
        return $query;
    }
    function count_search_tacit_knowledge($id_divisi, $id_jabatan)
    {
        $query  = $this->db->query("
                                    SELECT
                                        id_tacit_knowledge
                                    FROM
                                        tacit_knowledge
                                    WHERE id_divisi like '$id_divisi'
                                    AND id_jabatan like '$id_jabatan'
                                    AND status_validasi = 'TRUE'
                                    ");
        return $query->num_rows();
    }
    
    function tacit_knowledge_algo()
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_tacit_knowledge    id_tacit_knowledge,
                                        a.judul                 judul,
                                        b.ktp                   ktp,
                                        b.nama                  nama,
                                        a.masalah               masalah,
                                        a.solusi                solusi,
                                        a.dibuat_pada           dibuat_pada
                                    FROM
                                        tacit_knowledge a
                                    INNER JOIN
                                        user b
                                    ON
                                        a.ktp = b.ktp
                                    WHERE a.status_validasi = 'TRUE'
                                    ");
        return $query;
    }
}