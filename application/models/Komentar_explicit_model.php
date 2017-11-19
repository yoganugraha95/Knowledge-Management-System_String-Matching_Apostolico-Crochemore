<?php
class Komentar_explicit_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function komentar_by_id_explicit($id_explicit_knowledge)
    {
        $query  = $this->db->query("
                                    SELECT
                                    	a.id_komentar_explicit_knowledge   id_komentar_explicit_knowledge,
                                        a.id_explicit_knowledge            id_explicit_knowledge,
                                        a.ktp							   ktp,
                                        b.nama							   nama,
                                        b.foto                             foto,
                                        a.komentar						   komentar,
                                        a.dibuat_pada					   dibuat_pada
                                    FROM
                                    	komentar_explicit_knowledge a
                                    INNER JOIN
                                    	user b
                                    ON a.ktp = b.ktp
                                    WHERE id_explicit_knowledge = '$id_explicit_knowledge'
                                    ORDER BY a.id_komentar_explicit_knowledge DESC
                                    ");
        return $query;
    }
    
    function komentar_by_id_komentar_explicit_knowledge($id_komentar_explicit_knowledge)
    {
        $query  = $this->db->query("
                                    SELECT
                                    	a.id_komentar_explicit_knowledge   id_komentar_explicit_knowledge,
                                        a.id_explicit_knowledge            id_explicit_knowledge,
                                        a.ktp							   ktp,
                                        b.nama							   nama,
                                        b.foto                             foto,
                                        a.komentar						   komentar,
                                        a.dibuat_pada					   dibuat_pada
                                    FROM
                                    	komentar_explicit_knowledge a
                                    INNER JOIN
                                    	user b
                                    ON a.ktp = b.ktp
                                    WHERE id_komentar_explicit_knowledge = '$id_komentar_explicit_knowledge'
                                    ");
        return $query;
    }
    
    function delete_komentar_explicit_knowledge($id_komentar_explicit_knowledge)
    {
        $this->db->where('id_komentar_explicit_knowledge', $id_komentar_explicit_knowledge);
        $this->db->delete('komentar_explicit_knowledge');
    }
    
    function input_komentar_explicit_knowledge($array_komentar_explicit)
    {
        $this->db->insert('komentar_explicit_knowledge', $array_komentar_explicit);
    }
}