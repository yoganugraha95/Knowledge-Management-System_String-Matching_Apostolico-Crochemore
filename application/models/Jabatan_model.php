<?php
class Jabatan_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 
    function input_jabatan($array_data)
    {
        $this->db->insert('jabatan', $array_data);
    }
    function update_jabatan($id_jabatan, $array_data)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->update('jabatan', $array_data);
    }
    function delete_jabatan($id_jabatan)
    {
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->delete('jabatan');
    }
    function list_jabatan()
    {
        $query = $this->db->query("
                                    SELECT
                                        *
                                    FROM
                                        jabatan
                                  ");
        return $query;
    }
    function cek_avaibility_id_jabatan($id_jabatan)
    {
        $query = $this->db->query("
                                    SELECT 
                                        *
                                    FROM 
                                        jabatan
                                    WHERE id_jabatan = '$id_jabatan'
                                  ");
        if($query->num_rows() > 0)
        {
            return 'TRUE';
        }
        else
        {
            return 'FALSE';
        }
    }
}