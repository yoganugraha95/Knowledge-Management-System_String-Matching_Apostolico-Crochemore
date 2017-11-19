<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Superintendent extends CI_Controller {

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
   	    $this->load->model(array('User_model', 'Divisi_model', 'Jabatan_model', 'Hak_akses_model', 'Grup_user_model', 'Tacit_knowledge_model', 'Explicit_knowledge_model')); 
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
        redirect(base_url('superintendent/profil'));
	}
    
    public function profil()
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
        
        $data['ktp']                    = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_superintendent']  = $this->User_model->data_by_ktp($ktp); 
        $data['hak_akses']              = $this->Grup_user_model->list_hak_akses($ktp); 
        $data['jumlah_tacit']           = $this->Tacit_knowledge_model->hitung_jumlah_tacit_by_ktp($ktp); 
        $data['jumlah_explicit']        = $this->Explicit_knowledge_model->hitung_jumlah_explicit_by_ktp($ktp);
        $data['content']                = 'superintendent/profil_karyawan'; 
        
        $this->load->view('superintendent/template', $data); 
    }
    
    public function ubah_profil()
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

        $data['ktp']                    = $ktp; 
        $data['profil_superintendent']  = $this->User_model->data_by_ktp($ktp); 
        $data['content']                = 'superintendent/profil_ubah'; 
        
        $this->load->view('superintendent/template', $data); 
    }
    
    public function perbarui_profil()
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
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $email              = $this->input->post('email');
        $nama               = $this->input->post('nama');
        $alamat             = $this->input->post('alamat'); 
        $no_hp              = $this->input->post('no_hp');
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan    = array(
                                        'email'             =>  $email,
                                        'nama'              =>  $nama,
                                        'alamat'            =>  $alamat,
                                        'no_hp'             =>  $no_hp,
                                        'diperbarui_pada'   =>  $diperbarui_pada,
                                        'diperbarui_oleh'   =>  $diperbarui_oleh
                                       );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->User_model->update_user($ktp, $array_data_karyawan); 
        
        echo "<script> alert('Data Profil telah diperbarui');</script>";
        redirect(base_url('superintendent/profil/'), 'refresh');
    }
    
    public function perbarui_foto_profil()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Inisiasi data dimulai */
        $ktp                = $this->session->userdata('ktp'); 
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Inisiadi data berakhir */
   
        /** Konfigurasi unggah foto profil dimulai */
        $config['upload_path']          = './upload/image/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 500;
        $config['max_width']            = 1024;
        $config['max_height']           = 1024;
        $config['encrypt_name']    		= TRUE;
        $config['file_ext_tolower']     = TRUE;
        /** Konfigurasi unggah foto profil berakhir */

        $this->load->library('upload', $config); 

        if(!$this->upload->do_upload('userfile')) 
        {
            echo "<script> alert('Foto gagal diunggah');</script>";
            redirect(base_url('profil/ubah_profil/'), 'refresh');     
        }
        else 
        {    
            /** Hapus file foto profil sebelumnya (jika ada) dimulai */
            $foto_sebelumnya = $this->User_model->data_by_ktp($ktp)->row()->foto;
            if($foto_sebelumnya != NULL)
            {
                $path   = './upload/image/'.$foto_sebelumnya;
                unlink($path);
            }
            /** Hapus file foto profil sebelumnya (jika ada) berakhir */
            
            /** Tampung Hasil Input-an di Array dimulai */
            $upload_data    = $this->upload->data(); 
            $foto           = $upload_data['file_name'];
            $array_data_karyawan    = array(
                                            'ktp'               =>  $ktp,
                                            'foto'              =>  $foto,
                                            'diperbarui_pada'   =>  $diperbarui_pada,
                                            'diperbarui_oleh'   =>  $diperbarui_oleh
                                           );
            /** Tampung Hasil Input-an di Array berakhir */
            
            $this->User_model->update_user($ktp, $array_data_karyawan); 
            echo "<script> alert('Foto Profil berhasil diperbarui');</script>";
            redirect(base_url('superintendent/profil/'), 'refresh');
        }
    }
    
    public function ubah_password()
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

        $data['ktp']        = $ktp; 
        $data['content']    = 'superintendent/profil_password'; 
        
        $this->load->view('superintendent/template', $data); 
    }
    
    public function perbarui_password()
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
        $diperbarui_pada    = date('Y-m-d H:i:s'); 
        $diperbarui_oleh    = $this->session->userdata('ktp'); 
        
        $password       = trim(strip_tags($this->input->post('password'))); 
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan = array(
                                    'password'  => md5($password),
                                    'diperbarui_pada'   => $diperbarui_pada,
                                    'diperbarui_oleh'   => $diperbarui_oleh
                                    );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->User_model->update_user($ktp, $array_data_karyawan); 
        
        echo "<script> alert('Password berhasil diperbarui');</script>";
        redirect(base_url('superintendent/ubah_password/'), 'refresh');
    }
    
    public function karyawan()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_superintendent');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('superintendent_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('superintendent/profil/'), 'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows();  
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('superintendent/profil/'), 'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        $ktp_session    = $this->session->userdata('ktp'); 
        
        /** Jika halaman user berisi data anda, buka halaman profil anda dimulai */
        if($ktp == $ktp_session)
        {
            redirect(base_url('superintendent/profil/'), 'refresh');
        }
        /** Jika halaman user berisi data anda, buka halaman profil anda berakhir */
        
        $data['ktp']                    = $ktp; 
        $data['profil_superintendent']  = $this->User_model->data_by_ktp($ktp); 
        $data['content']                = 'superintendent/profil_karyawan_lain'; 
        
        $this->load->view('superintendent/template', $data);  
    }
}