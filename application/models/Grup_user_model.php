<?php
class Grup_user_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function data_by_id_grup_user($id_grup_user)
    {
        $query  = $this->db->query("
                                    SELECT
                                        *
                                    FROM
                                        grup_user
                                    WHERE id_grup_user = '$id_grup_user'
                                   ");
        return $query;
    }
    //cek avaibility
    function cek_avaibility($ktp, $password, $id_hak_akses)
    {
        $query = $this->db->query("
                                    SELECT
                                        1 avaibility
                                    FROM
                                        grup_user c
                                    INNER JOIN 
                                        user a
                                    ON c.ktp = a.ktp
                                    WHERE c.ktp = '$ktp'
                                    AND a.password = '$password'
                                    AND c.id_hak_akses = '$id_hak_akses'
                                    AND a.status_aktif = 'TRUE'
                                    LIMIT 1
                                  ");
                                       
        if($query->num_rows() == 1)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }
    
    function input_grup_user($array_data_grup_user)
    {
        $this->db->insert('grup_user', $array_data_grup_user);
    }
    
    function list_hak_akses($ktp)
    {
        $query  = $this->db->query("
                                    SELECT
                                        *
                                    FROM
                                        grup_user a
                                    INNER JOIN
                                        hak_akses b
                                    ON 
                                        a.id_hak_akses = b.id_hak_akses
                                    WHERE
                                        ktp = '$ktp'
                                   ");
        return $query;
    }
    
    function delete_hak_akses($id_grup_user)
    {
        $this->db->where('id_grup_user', $id_grup_user);
        $this->db->delete('grup_user');
    }
}
