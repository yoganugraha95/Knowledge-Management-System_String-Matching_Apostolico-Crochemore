<?php
class Komentar_tacit_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function komentar_by_id_tacit($id_tacit_knowledge)
    {
        $query  = $this->db->query("
                                    SELECT
                                    	a.id_komentar_tacit_knowledge	id_komentar_tacit_knowledge,
                                        a.id_tacit_knowledge			id_tacit_knowledge,
                                        a.ktp							ktp,
                                        b.nama							nama,
                                        b.foto                          foto,
                                        a.komentar						komentar,
                                        a.dibuat_pada					dibuat_pada
                                    FROM
                                    	komentar_tacit_knowledge a
                                    INNER JOIN
                                    	user b
                                    ON a.ktp = b.ktp
                                    WHERE id_tacit_knowledge = '$id_tacit_knowledge'
                                    ORDER BY a.id_komentar_tacit_knowledge DESC
                                    ");
        return $query;
    }
    
    function komentar_by_id_komentar_tacit_knowledge($id_komentar_tacit_knowledge)
    {
        $query  = $this->db->query("
                                    SELECT
                                    	a.id_komentar_tacit_knowledge	id_komentar_tacit_knowledge,
                                        a.id_tacit_knowledge			id_tacit_knowledge,
                                        a.ktp							ktp,
                                        b.nama							nama,
                                        b.foto                          foto,
                                        a.komentar						komentar,
                                        a.dibuat_pada					dibuat_pada
                                    FROM
                                    	komentar_tacit_knowledge a
                                    INNER JOIN
                                    	user b
                                    ON a.ktp = b.ktp
                                    WHERE id_komentar_tacit_knowledge = '$id_komentar_tacit_knowledge'
                                    ");
        return $query;
    }
    
    function delete_komentar_tacit_knowledge($id_komentar_tacit_knowledge)
    {
        $this->db->where('id_komentar_tacit_knowledge', $id_komentar_tacit_knowledge);
        $this->db->delete('komentar_tacit_knowledge');
    }
    
    function input_komentar_tacit_knowledge($array_komentar_tacit)
    {
        $this->db->insert('komentar_tacit_knowledge', $array_komentar_tacit);
    }
}