<?php
class Explicit_knowledge_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function hitung_jumlah_explicit_by_ktp($ktp)
    {
        $query  = $this->db->query("
                                    SELECT
                                        COUNT(*) jumlah_explicit
                                    FROM 
                                        explicit_knowledge
                                    WHERE ktp = '$ktp'
                                    ");
        return $query->row()->jumlah_explicit;   
    }
    
    function input_explicit_knowledge($array_data_explicit)
    {
        $this->db->insert('explicit_knowledge', $array_data_explicit);
    }
    
    function list_all_not_validated_explicit_knowledge()
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_explicit_knowledge     id_explicit_knowledge,
                                        a.ktp                       ktp,
                                        d.nama                      nama,
                                        a.judul                     judul,
                                        b.nama_divisi               nama_divisi,
                                        c.nama_jabatan              nama_jabatan,
                                        a.dibuat_pada               dibuat_pada,
                                        a.dibuat_oleh               dibuat_oleh
                                    FROM 
                                            explicit_knowledge a
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
    
    function list_explicit_knowledge_by_ktp($ktp)
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_explicit_knowledge     id_explicit_knowledge,
                                        a.ktp                       ktp,
                                        a.judul                     judul,
                                        a.id_divisi                 id_divisi,
                                        b.nama_divisi               nama_divisi,
                                        a.id_jabatan                id_jabatan,
                                        c.nama_jabatan              nama_jabatan,
                                        a.file_dokumen              file_dokumen,
                                        a.dibuat_pada               dibuat_pada,
                                        a.dibuat_oleh               dibuat_oleh,
                                        a.diperbarui_pada           diperbarui_pada,
                                        a.diperbarui_oleh           diperbarui_oleh,
                                        a.status_validasi           status_validasi,
                                        a.divalidasi_oleh           divalidasi_oleh,
                                        a.divalidasi_pada           divalidasi_pada
                                    FROM 
                                        explicit_knowledge a
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
    
    function profil_explicit_knowledge($id_explicit_knowldge)
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_explicit_knowledge     id_explicit_knowledge,
                                        a.ktp                       ktp,
                                        d.nama                      nama,
                                        a.judul                     judul,
                                        a.id_divisi                 id_divisi,
                                        b.nama_divisi               nama_divisi,
                                        a.id_jabatan                id_jabatan,
                                        c.nama_jabatan              nama_jabatan,
                                        a.file_dokumen              file_dokumen,
                                        a.dibuat_pada               dibuat_pada,
                                        a.dibuat_oleh               dibuat_oleh,
                                        a.diperbarui_pada           diperbarui_pada,
                                        a.diperbarui_oleh           diperbarui_oleh,
                                        a.status_validasi           status_validasi,
                                        a.divalidasi_oleh           divalidasi_oleh,
                                        a.divalidasi_pada           divalidasi_pada
                                    FROM 
                                        explicit_knowledge a
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
                                    WHERE a.id_explicit_knowledge = '$id_explicit_knowldge'
                                   ");
        return $query;
    }
    
    function update_explicit_knowledge($array_data_explicit, $id_explicit_knowledge)
    {
        $this->db->where('id_explicit_knowledge', $id_explicit_knowledge);
        $this->db->update('explicit_knowledge', $array_data_explicit);
    }
    
    function delete_explicit_knowledge($id_explicit_knowledge)
    {
        $this->db->where('id_explicit_knowledge', $id_explicit_knowledge);
        $this->db->delete('explicit_knowledge');
    }
    
    function search_explicit_knowledge($id_divisi, $id_jabatan, $limit, $offset)
    {
        $query  = $this->db->query("
							         SELECT
                                        a.id_explicit_knowledge id_explicit_knowledge,
                                        a.judul                 judul,
                                        b.ktp                   ktp,
                                        b.nama                  nama,
                                        a.file_dokumen          file_dokumen,
                                        a.dibuat_pada           dibuat_pada
                                    FROM
                                        explicit_knowledge a
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
    
    function count_search_explicit_knowledge($id_divisi, $id_jabatan)
    {
        $query  = $this->db->query("
                                    SELECT
                                        id_explicit_knowledge
                                    FROM
                                        explicit_knowledge
                                    WHERE id_divisi like '$id_divisi'
                                    AND id_jabatan like '$id_jabatan'
                                    AND status_validasi = 'TRUE'
                                    ");
        return $query->num_rows();
    }
    
    function explicit_knowledge_algo()
    {
        $query  = $this->db->query("
                                    SELECT
                                        a.id_explicit_knowledge id_explicit_knowledge,
                                        a.judul                 judul,
                                        b.ktp                   ktp,
                                        b.nama                  nama,
                                        a.file_dokumen          file_dokumen,
                                        a.dibuat_pada           dibuat_pada
                                    FROM
                                        explicit_knowledge a
                                    INNER JOIN
                                        user b
                                    ON
                                        a.ktp = b.ktp
                                    WHERE a.status_validasi = 'TRUE'
                                    ");
        return $query;
    }
}