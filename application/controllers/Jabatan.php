<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {

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
   	    $this->load->model(array('Jabatan_model', 'User_model')); 
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
		redirect(base_url('jabatan/daftar'));
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
        
        $data['jabatan']   = $this->Jabatan_model->list_jabatan(); 
	    $data['content']   = 'admin/jabatan_daftar'; 
       
        $this->load->view('admin/template', $data); 
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
          
	    $data['content']    = 'admin/jabatan_input'; 
       
        $this->load->view('admin/template', $data); 
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
        $nama_jabatan   = $this->input->post('nama_jabatan');
        $dibuat_pada    = date('Y-m-d H:i:s');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data     = array(
                                'nama_jabatan'  => $nama_jabatan,
                                'dibuat_pada'   => $dibuat_pada  
                              );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->Jabatan_model->input_jabatan($array_data); 
        echo "<script> alert('Data Jabatan telah ditambahkan');</script>";
        redirect(base_url('jabatan'),'refresh');
    }
    
    public function update()
    {
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $nama_jabatan   = $this->input->post('nama_jabatan');
        $id_jabatan     = $this->input->post('id_jabatan');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_admin');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data     = array('nama_jabatan' => $nama_jabatan);
        /** Tampung Hasil Input-an di Array berakhir */
            
        $this->Jabatan_model->update_jabatan($id_jabatan, $array_data);
            
        echo "<script> alert('Data Jabatan telah diperbarui');</script>";
        redirect(base_url('jabatan'),'refresh');
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
        
        $id_jabatan         = $this->uri->segment(3);
        $ktp                = $this->session->userdata('ktp');

        /** Keamanan - Cek ada atau tidaknya Nilai ID Jabatan dimulai */
        if($id_jabatan == NULL)
        {
            redirect(base_url('jabatan'));
        }
        /** Keamanan - Cek ada atau tidaknya Nilai ID Jabatan berakhir */

        /** Keamanan - Cek ada atau tidaknya Nilai ID Jabatan dimulai */
        $id_avaibility      = $this->Jabatan_model->cek_avaibility_id_jabatan($id_jabatan);
        if($id_avaibility == 'FALSE')
        {
            redirect(base_url('jabatan'));
        }
        /** Keamanan - Cek ada atau tidaknya Nilai ID Jabatan berakhir */

        /** Keamanan - Cek ID Jabatan berdasarkan No.KTP/$ktp yang sedang digunakan dimulai */
        $user_id_jabatan    = $this->User_model->data_by_ktp($ktp)->row()->id_jabatan;
        if($id_jabatan == $user_id_jabatan)
        {
            echo "<script> alert('Data Jabatan tidak dihapus karena sedang anda gunakan');</script>";
            redirect(base_url('jabatan'),'refresh');    
        }
        /** Keamanan - Cek ID Jabatan berdasarkan No.KTP/$ktp yang sedang digunakan  berakhir */
         
        $this->Jabatan_model->delete_jabatan($id_jabatan); 
            
        redirect(base_url('jabatan'),'refresh');
    }
}