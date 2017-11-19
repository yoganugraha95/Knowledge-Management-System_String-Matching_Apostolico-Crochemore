<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

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
   	    $this->load->model(array('User_model', 'Divisi_model', 'Jabatan_model', 'Hak_akses_model', 'Grup_user_model', 'Tacit_knowledge_model', 'Explicit_knowledge_model' , 'Report_model')); //Load Model (File-file yang ada di Folder Model)
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
        redirect(base_url('report/pegawai'));
	}
    
    public function pegawai()
    {
  		/** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp = $this->session->userdata('ktp'); 
        
        $data['content']    = 'superintendent/report_karyawan'; 
        
        $this->load->view('superintendent/template', $data);  
    }
    
    public function tacit()
    {
  		/** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */

        $data['content']    = 'superintendent/report_tacit'; 
        
        $this->load->view('superintendent/template', $data);  
    }
    
    public function presentase()
    {
  		/** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */

        $data['content']    = 'superintendent/report_presentase'; 
        
        $this->load->view('superintendent/template', $data);   
    }
    
    public function explicit()
    {
  		/** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */

        $data['content']    = 'superintendent/report_explicit'; 
        
        $this->load->view('superintendent/template', $data);   
    }
    
    public function pegawai_search()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        if(empty($this->input->post('tanggal_pegawai_mulai')) && empty($this->input->post('tanggal_pegawai_berakhir')))
        {
            $tanggal_pegawai_mulai      = $this->session->userdata('tanggal_pegawai_mulai');
            $tanggal_pegawai_berakhir   = $this->session->userdata('tanggal_pegawai_berakhir');
        }
        else
        {
            $tanggal_pegawai_mulai      = $this->input->post('tanggal_pegawai_mulai');
            $tanggal_pegawai_berakhir   = $this->input->post('tanggal_pegawai_berakhir');
            
            $array_session_pegawai_search = array(
                'tanggal_pegawai_mulai'    => $tanggal_pegawai_mulai,
                'tanggal_pegawai_berakhir' => $tanggal_pegawai_berakhir
            );
      
            $this->session->set_userdata($array_session_pegawai_search);
        }
        
        $data['tanggal_pegawai_mulai']      = $tanggal_pegawai_mulai;
        $data['tanggal_pegawai_berakhir']   = $tanggal_pegawai_berakhir;
        $data['search_result']              = $this->Report_model->report_pegawai($tanggal_pegawai_mulai, $tanggal_pegawai_berakhir);
        $data['content']                    = 'superintendent/report_karyawan_search_result'; 
        
        $this->load->view('superintendent/template', $data);  
    }
    
    public function presentase_search()
    {
  		/** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */

        if(empty($this->input->post('tanggal_presentase_mulai')) && empty($this->input->post('tanggal_presentase_berakhir')))
        {
            $tanggal_presentase_mulai       = $this->session->userdata('tanggal_presentase_mulai');
            $tanggal_presentase_berakhir    = $this->session->userdata('tanggal_presentase_berakhir');
        }
        else
        {
            $tanggal_presentase_mulai      = $this->input->post('tanggal_presentase_mulai');
            $tanggal_presentase_berakhir   = $this->input->post('tanggal_presentase_berakhir');
            
            $array_session_presentase_search = array(
                'tanggal_presentase_mulai'      => $tanggal_presentase_mulai,
                'tanggal_presentase_berakhir'   => $tanggal_presentase_berakhir
            );
      
            $this->session->set_userdata($array_session_presentase_search);
        }

        $data['tanggal_presentase_mulai']       = $tanggal_presentase_mulai;
        $data['tanggal_presentase_berakhir']    = $tanggal_presentase_berakhir;
        $data['search_result']                  = $this->Report_model->report_presentase($tanggal_presentase_mulai, $tanggal_presentase_berakhir);
        $data['content']                        = 'superintendent/report_presentase_search_result'; 
        
        $this->load->view('superintendent/template', $data);  
    }
    
    public function tacit_search()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        if(empty($this->input->post('tahun_tacit')))
        {
            $tahun_tacit      = $this->session->userdata('tahun_tacit');
        }
        else
        {
            $tahun_tacit      = $this->input->post('tahun_tacit');
            
            $array_session_tacit_search = array(
                'tahun_tacit'      => $tahun_tacit
            );
      
            $this->session->set_userdata($array_session_tacit_search);
        }
        
        $data['tahun_tacit']    = $tahun_tacit;
        $data['search_result']  = $this->Report_model->report_tacit($tahun_tacit);
        $data['content']        = 'superintendent/report_tacit_search_result'; 
        
        $this->load->view('superintendent/template', $data);   
    }
    
    public function explicit_search()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        if(empty($this->input->post('tahun_explicit')))
        {
            $tahun_explicit      = $this->session->userdata('tahun_explicit');
        }
        else
        {
            $tahun_explicit     = $this->input->post('tahun_explicit');
            
            $array_session_explicit_search = array(
                'tahun_explicit'      => $tahun_explicit
            );
      
            $this->session->set_userdata($array_session_explicit_search);
        }

        
        $data['tahun_explicit']     = $tahun_explicit;
        $data['search_result']      = $this->Report_model->report_explicit($tahun_explicit);
        $data['content']            = 'superintendent/report_explicit_search_result'; 
        
        $this->load->view('superintendent/template', $data);  
    }
}