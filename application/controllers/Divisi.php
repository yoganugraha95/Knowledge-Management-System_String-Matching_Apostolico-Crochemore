<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Divisi extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
    public function __construct()
    {
        parent::__construct();
   	    $this->load->model(array('Divisi_model', 'User_model'));
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
		redirect(base_url('divisi/daftar'));
	}
    public function daftar()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $data['divisi']    = $this->Divisi_model->list_divisi(); //Ambil Data Daftar Divisi (Divisi_model.php)      
	    $data['content']   = 'admin/divisi_daftar'; //Ambil Halaman Daftar Divisi (divisi_daftar.php)
       
        $this->load->view('admin/template', $data); //Load View (Munculkan tampilan web)
    }
    
    public function input()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
   
	    $data['content']    = 'admin/divisi_input'; //Ambil Halaman Tambah Divisi(divisi_input.php)
       
        $this->load->view('admin/template', $data); //Load View (Munculkan tampilan web)  
    }
    
    public function add()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $nama_divisi    = $this->input->post('nama_divisi');
        $dibuat_pada    = date('Y-m-d H:i:s');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data     = array(
                                'nama_divisi'  => $nama_divisi,
                                'dibuat_pada'   => $dibuat_pada  
                              );
        /** Tampung Hasil Input-an di Array dimulai */
        
        $this->Divisi_model->input_divisi($array_data); //Tambah Data Divisi (divisi_model.php)
        echo "<script> alert('Data Divisi telah ditambahkan');</script>";
        redirect(base_url('divisi'),'refresh');
    }
    
    public function update()
    {   
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */

        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $nama_divisi    = $this->input->post('nama_divisi');
        $id_divisi      = $this->input->post('id_divisi');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */

        /** Tampung Hasil Input-an di Array dimulai */       
        $array_data     = array('nama_divisi' => $nama_divisi);
        /** Tampung Hasil Input-an di Array berakhir */
                    
        $this->Divisi_model->update_divisi($id_divisi, $array_data); //Perbarui Data Divisi (divisi_model.php)
            
        echo "<script> alert('Data Divisi telah diperbarui');</script>";
        redirect(base_url('divisi'),'refresh'); 
    }
    
    public function delete()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $id_divisi      = $this->uri->segment(3);
        $ktp            = $this->session->userdata('ktp');

        /** Keamanan - Cek ada atau tidaknya Nilai ID Divisi dimulai */
        if($id_divisi == NULL)
        {
            redirect(base_url('divisi'));
        }
        /** Keamanan - Cek ada atau tidaknya Nilai ID Divisi berakhir */

        /** Keamanan - Cek ada atau tidaknya Nilai ID Divisi dimulai */
        $id_avaibility  = $this->Divisi_model->cek_avaibility_id_divisi($id_divisi);
        if($id_avaibility == 'FALSE')
        {
            redirect(base_url('divisi'));
        }
        /** Keamanan - Cek ada atau tidaknya Nilai ID Divisi berakhir */

        /** Keamanan - Cek ID Divisi berdasarkan No.KTP/$ktp yang sedang digunakan dimulai */
        $user_id_divisi = $this->User_model->data_by_ktp($ktp)->row()->id_divisi;   
        if($id_divisi == $user_id_divisi)
        {
            echo "<script> alert('Data Divisi tidak dihapus karena sedang anda gunakan');</script>";
            redirect(base_url('divisi'),'refresh');    
        }
        /** Keamanan - Cek ID Divisi berdasarkan No.KTP/$ktp yang sedang digunakan berakhir */
            
        $this->Divisi_model->delete_divisi($id_divisi); //Hapus Data Divisi (Divisi_model.php)
            
        redirect(base_url('divisi'),'refresh');
    }
}