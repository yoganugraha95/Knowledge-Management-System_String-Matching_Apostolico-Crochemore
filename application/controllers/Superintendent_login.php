<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superintendent_login extends CI_Controller {

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
        //Jika Login = TRUE, maka langsung masuk ke Halaman Divisi
        if($this->session->userdata('login_superintendent') == 'TRUE')
        {
            redirect('report'); 
        }
        else
        {
            //Jika tidak, redirect ke Halaman Login, hapus semua session
            redirect('superintendent_login/login');
        }          
    }
    
    public function login()
	{
	    //Jika Login = TRUE, maka langsung masuk ke Halaman Divisi
        if($this->session->userdata('login_superintendent') == 'TRUE')
        {
            redirect('report'); 
        }
        else
        {
        //Jika tidak, munculkan Halaman Login
      		$this->load->view('superintendent/login');
        }   
	}
    
    function login_action()
	{
	    /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
		$ktp              = trim(strip_tags($this->input->post('ktp')));
		$password         = trim(strip_tags($this->input->post('password')));
        $id_hak_akses     = '2'; //Ini Hak Akses Superintendent
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        //Periksa ketersediaan hak akses sebagai Superintendent
		$cek_avaibility   = $this->Grup_user_model->cek_avaibility($ktp, md5($password), $id_hak_akses);
        
        if($cek_avaibility == 'TRUE') //Jika ketersediaan hak akses sebagai Superintendent = TRUE
        {            
            //Set Session No. KTP, dan status Login
            $arraysesi    = array('ktp' => $ktp, 'login_superintendent' => 'TRUE'); //Tampung Data Login di Array
            $this->session->set_userdata($arraysesi); //Set Data Login di Session
            
            //Perbarui Waktu Login Terakhir
            $array_waktu_login   = array('login_terakhir' => date('Y-m-d H:i:s')); //Tampung Data Login Terakhir di Array
            $this->User_model->update_waktu_login_terakhir($ktp, $array_waktu_login); //Perbarui Data Login User terakhir (User_model.php)
            
            //Masuk ke Halaman Divisi
            redirect(base_url('report'),'refresh');
        }
        else if($cek_avaibility =='FALSE') //Jika ketersediaan hak akses sebagai Superintendent == FALSE, maka kembali ke Halaman Login
        {
            echo "<script> alert('No. KTP atau Password Anda Salah');</script>";
            redirect(base_url('superintendent_login'),'refresh');
        }
	}
            
    function logout_action()
	{
        //Log Out, hapus semua session
		$this->session->sess_destroy();
        echo "<script> alert('Anda telah Log Out');</script>";
		redirect(base_url('superintendent_login'),'refresh');
	}
}