<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_login extends CI_Controller {

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
   	    $this->load->model(array('Grup_user_model', 'User_model'));
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
    public function index()
    {
        //Jika Login = TRUE, maka langsung masuk ke Halaman sharing
        if($this->session->userdata('login') == 'TRUE')
        {
            redirect('sharing'); 
        }
        else
        {
        //Jika tidak, redirect ke Halaman Login, hapus semua session
            redirect('karyawan_login/login');
        }          
    }
    
    public function login()
	{
	    //Jika Login = TRUE, maka langsung masuk ke Halaman sharing
        if($this->session->userdata('login_karyawan') == 'TRUE')
        {
            redirect('sharing'); 
        }
        else
        {
            //Jika tidak, munculkan Halaman Login
      		$this->load->view('karyawan/login');
        }   
	}
    
    function login_action()
	{
		$ktp                = trim(strip_tags($this->input->post('ktp')));
		$password           = trim(strip_tags($this->input->post('password')));
        $id_karyawan_biasa  = '3'; //Ini Hak Akses Karyawan Biasa
        $id_karyawan_ahli   = '4'; //Ini Hak Akses Karyawan Ahli
        
        $cek_staf_biasa    = $this->Grup_user_model->cek_avaibility($ktp, md5($password), $id_karyawan_biasa); //Cek benar atau tidak User adalah Karyawan Biasa
		$cek_staf_ahli     = $this->Grup_user_model->cek_avaibility($ktp, md5($password), $id_karyawan_ahli); //Cek benar atau tidak User adalah Karyawan Ahli
       
        if ($cek_staf_ahli == 'TRUE')
        {
            //Jika ketersediaan hak akses sebagai karyawan ahli = TRUE
            
            //Set Session No. KTP, dan status Login
            $arraysesi    = array('ktp' => $ktp, 'login_karyawan' => 'TRUE', 'login_karyawan_ahli' => 'TRUE'); //Ada tambahan Session Karyawan Ahli
            $this->session->set_userdata($arraysesi);
            
            //Perbarui Waktu Login Terakhir
            $array_waktu_login   = array('login_terakhir' => date('Y-m-d H:i:s'));
            $this->User_model->update_waktu_login_terakhir($ktp, $array_waktu_login);
            
            //Masuk ke Halaman sharing
            redirect(base_url('sharing'),'refresh');
        } 
        else if($cek_staf_biasa == 'TRUE')
        {
            //Jika ketersediaan hak akses sebagai karyawan = TRUE
            
            //Set Session No. KTP, dan status Login
            $arraysesi    = array('ktp' => $ktp, 'login_karyawan' => 'TRUE');
            $this->session->set_userdata($arraysesi);
            
            //Perbarui Waktu Login Terakhir
            $array_waktu_login   = array('login_terakhir' => date('Y-m-d H:i:s'));
            $this->User_model->update_waktu_login_terakhir($ktp, $array_waktu_login);
            
            //Masuk ke Halaman sharing
            redirect(base_url('sharing'),'refresh');
        }
        else
        {
            //Jika ketersediaan hak akses sebagai karyawan == FALSE, maka kembali ke Halaman Login
            echo "<script> alert('No. KTP atau Password Anda Salah');</script>";
            redirect(base_url('karyawan_login'),'refresh');
        }
	}
            
    function logout_action()
	{
        //Log Out, hapus semua session
		$this->session->sess_destroy();
        echo "<script> alert('Anda telah Log Out');</script>";
		redirect(base_url('karyawan_login'),'refresh');
	}
}