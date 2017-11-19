<?php
class User_model extends CI_Model 
{
	function __construct()
    {
         parent::__construct();
    } 
 
    function list_user()
    {
        $query  = $this->db->query("
                                    SELECT 
                                        *     
                                    FROM
                                        user                                         
                                   ");
        
        return $query;
    }
    
    function input_user($array_data_karyawan)
    {
        $this->db->insert('user', $array_data_karyawan);
    }
    
    function update_user($ktp, $array_data_karyawan)
    {
        $this->db->where('ktp', $ktp);
        $this->db->update('user', $array_data_karyawan);
    }
    
    function data_by_ktp($ktp)
    {
        $query = $this->db->query("
                                    SELECT
                                        a.ktp               ktp,
                                        a.nik               nik,
                                        a.email             email,
                                        a.password          password,
                                        a.nama              nama,
                                        a.id_divisi         id_divisi,
                                        b.nama_divisi       nama_divisi,
                                        a.id_jabatan        id_jabatan,
                                        c.nama_jabatan      nama_jabatan,
                                        a.alamat            alamat,
                                        a.no_hp             no_hp,
                                        a.foto              foto,
                                        a.login_terakhir    login_terakhir,
                                        a.status_aktif      status_aktif,
                                        a.dibuat_pada       user_dibuat_pada,
                                        a.diperbarui_pada   user_diperbarui_pada,
                                        a.dibuat_oleh       user_dibuat_oleh,
                                        a.diperbarui_oleh   user_diperbarui_oleh
                                    FROM
                                        user a
                                    INNER JOIN
                                        divisi b
                                    ON
                                        a.id_divisi = b.id_divisi
                                    INNER JOIN
                                        jabatan c
                                    ON
                                        a.id_jabatan = c.id_jabatan
                                    WHERE ktp = '$ktp'
                                  ");
        return $query;
    }
    
    function update_waktu_login_terakhir($ktp, $array_waktu_login)
    {
        $this->db->where('ktp', $ktp);
        $this->db->update('user', $array_waktu_login);
    }
}