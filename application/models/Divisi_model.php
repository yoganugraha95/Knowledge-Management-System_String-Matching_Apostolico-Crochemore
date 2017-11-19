<?php
class Divisi_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 

    function input_divisi($array_data)
    {
        $this->db->insert('divisi', $array_data);
    }
    function update_divisi($id_divisi, $array_data)
    {
        $this->db->where('id_divisi', $id_divisi);
        $this->db->update('divisi', $array_data);
    }
    function delete_divisi($id_divisi)
    {
        $this->db->where('id_divisi', $id_divisi);
        $this->db->delete('divisi');
    }
    function list_divisi()
    {
        $query = $this->db->query("
                                    SELECT
                                        *
                                    FROM
                                        divisi
                                  ");
        return $query;
    }
    function cek_avaibility_id_divisi($id_divisi)
    {
        $query = $this->db->query("
                                    SELECT 
                                        *
                                    FROM 
                                        divisi
                                    WHERE id_divisi = '$id_divisi'
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