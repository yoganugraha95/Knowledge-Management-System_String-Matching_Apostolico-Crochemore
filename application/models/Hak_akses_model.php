<?php
class Hak_akses_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 
    
    function list_hak_akses()
    {
        $query  = $this->db->query("
                                    SELECT 
                                        *
                                    FROM
                                        hak_akses
                                   ");
        return $query;
    }
    
    function get_hak_akses_non_aktif($ktp)
    {
        $query  = $this->db->query("
                                   SELECT
                                    	*
                                   FROM
                                        hak_akses
                                   WHERE id_hak_akses NOT IN (
                                                              SELECT 
                                                                    id_hak_akses 
                                                              FROM grup_user 
                                                              WHERE ktp = '$ktp'
                                                              )
                                   ");
        return $query;
    }
}