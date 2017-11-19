<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capture extends CI_Controller {

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
   	    $this->load->model(array('Divisi_model','Jabatan_model','User_model','Grup_user_model','Tacit_knowledge_model','Komentar_tacit_model'));
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
		redirect(base_url('capture/tambah'));
	}
    public function tambah()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $data['divisi']    = $this->Divisi_model->list_divisi();  
        $data['jabatan']   = $this->Jabatan_model->list_jabatan(); 
	    $data['content']   = 'karyawan/capture_tambah'; 
       
        $this->load->view('karyawan/template', $data);
    }
    
    public function tambah_data()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp                = $this->session->userdata('ktp');
        $judul              = $this->input->post('judul');
        $id_divisi          = $this->input->post('id_divisi');
        $id_jabatan         = $this->input->post('id_jabatan');
        $masalah            = $this->input->post('masalah');
        $solusi             = $this->input->post('solusi');
        $dibuat_pada        = date('Y-m-d H:i:s');
        $dibuat_oleh        = $this->session->userdata('ktp');
        $status_validasi    = 'FALSE';
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_tacit    = array(
                                        'ktp'               =>  $ktp,
                                        'judul'             =>  $judul,
                                        'id_divisi'         =>  $id_divisi,
                                        'id_jabatan'        =>  $id_jabatan,
                                        'masalah'           =>  $masalah,
                                        'solusi'            =>  $solusi,
                                        'dibuat_pada'       =>  $dibuat_pada,
                                        'dibuat_oleh'       =>  $dibuat_oleh,
                                        'status_validasi'   =>  $status_validasi,
                                       );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->Tacit_knowledge_model->input_tacit_knowledge($array_data_tacit);
        
        echo "<script> alert('Data Tacit Knowledge telah ditambahkan');</script>";
        redirect(base_url('capture/daftar'),'refresh');
    }
    public function daftar()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp  = $this->session->userdata('ktp'); 
        
        $data['daftar_tacit_knowledge'] = $this->Tacit_knowledge_model->list_tacit_knowledge_by_ktp($ktp);
   	    $data['content']                = 'karyawan/tacit_daftar';
       
        $this->load->view('karyawan/template', $data); 
    }
    public function profil()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp  = $this->session->userdata('ktp'); 
        
        $id_tacit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge dimulai */
        if($id_tacit_knowledge == NULL)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge dimulai */
        $cek_tacit      = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->num_rows(); 
        if($cek_tacit == 0)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge berakhir */

        /** Keamanan - Cek Tacit Knowledge telah divalidasi atau belum dimulai */
        $cek_validasi_tacit_knowledge   = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->status_validasi;
        $ktp_pembuat_tacit_knowledge    = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->ktp;
        if(($cek_validasi_tacit_knowledge == 'FALSE') && ($ktp != $ktp_pembuat_tacit_knowledge))
        {
            redirect(base_url('capture/daftar'),'refresh');
        }       
        /** Keamanan - Cek Tacit Knowledge telah divalidasi atau belum berakhir */
        
        /** Keamanan - Cek hak untuk menyunting Tacit Knowledge dimulai */
        $hak_akses_karyawan_ahli                      = $this->session->userdata('login_karyawan_ahli');
        $hak_sunting_dan_hapus_tacit_knowledge        = NULL;
        $hak_validasi_tacit_knowledge                 = NULL;
        $status_validasi_tacit_knowledge              = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->status_validasi;
        if($hak_akses_karyawan_ahli == 'TRUE')
        {
            $hak_sunting_dan_hapus_tacit_knowledge    = 'TRUE';
            if($status_validasi_tacit_knowledge == 'FALSE')
            {
                $hak_validasi_tacit_knowledge = 'TRUE';                  
            }
        }
        
        if($ktp_pembuat_tacit_knowledge == $ktp)
        {
            $hak_sunting_dan_hapus_tacit_knowledge     = 'TRUE';
        }
        /** Keamanan - Cek hak untuk menyunting Tacit Knowledge berakhir */
        
        $data['ktp_session']                                = $ktp;
        $data['ktp_pembuat_tacit_knowledge']                = $ktp_pembuat_tacit_knowledge;
        $data['id_tacit_knowledge']                         = $id_tacit_knowledge;
        $data['judul_tacit_knowledge']                      = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->judul;
        $data['waktu_publikasi_tacit_knowledge']            = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->dibuat_pada;
        $data['profil_tacit_knowledge']                     = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge);
        $data['komentar_tacit_knowledge']                   = $this->Komentar_tacit_model->komentar_by_id_tacit($id_tacit_knowledge);
        $data['hak_sunting_dan_hapus_tacit_knowledge']      = $hak_sunting_dan_hapus_tacit_knowledge;
        $data['hak_validasi_tacit_knowledge']               = $hak_validasi_tacit_knowledge;
   	    $data['content']                                    = 'karyawan/tacit_profil'; 
       
        $this->load->view('karyawan/template', $data); 
    }
    
    public function validasi()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp  = $this->session->userdata('ktp'); 
        
        $id_tacit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge dimulai */
        if($id_tacit_knowledge == NULL)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge dimulai */
        $cek_tacit      = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->num_rows(); 
        if($cek_tacit == 0)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge berakhir */
        
        $diperbarui_pada        = date('Y-m-d H:i:s');
        $diperbarui_oleh        = $this->session->userdata('ktp');
        $status_validasi        = 'TRUE';
        $divalidasi_pada        = date('Y-m-d H:i:s');
        $divalidasi_oleh        = $this->session->userdata('ktp');
        
        $array_data_tacit       = array(
                                        'diperbarui_pada'   => $diperbarui_pada,
                                        'diperbarui_oleh'   => $diperbarui_oleh,
                                        'status_validasi'   => $status_validasi,
                                        'divalidasi_pada'   => $divalidasi_pada,
                                        'divalidasi_oleh'   => $divalidasi_oleh
                                        );
        
        $this->Tacit_knowledge_model->update_tacit_knowledge($array_data_tacit, $id_tacit_knowledge);
        
        echo "<script> alert('Data Tacit Knowledge telah divalidasi');</script>";
        redirect(base_url('capture/profil/'.$id_tacit_knowledge),'refresh');
    }
    
    public function ubah()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp  = $this->session->userdata('ktp'); 
        
        $id_tacit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge dimulai */
        if($id_tacit_knowledge == NULL)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Tacit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge dimulai */
        $cek_tacit      = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->num_rows(); 
        if($cek_tacit == 0)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Tacit Knowledge berdasarkan ID Tacit Knowledge berakhir */  
        
        $data['id_tacit_knowledge']                         = $id_tacit_knowledge;
        $data['judul_tacit_knowledge']                      = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge)->row()->judul;
        $data['profil_tacit_knowledge']                     = $this->Tacit_knowledge_model->profil_tacit_knowledge($id_tacit_knowledge);
        $data['divisi']                                     = $this->Divisi_model->list_divisi();  
        $data['jabatan']                                    = $this->Jabatan_model->list_jabatan(); 
        $data['content']                                    = 'karyawan/tacit_ubah'; 
        
        $this->load->view('karyawan/template', $data); //Load View (Munculkan tampilan web)
    }
    
    public function perbarui()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $id_tacit_knowledge = $this->input->post('id_tacit_knowledge');
        $ktp                = $this->session->userdata('ktp');
        $judul              = $this->input->post('judul');
        $id_divisi          = $this->input->post('id_divisi');
        $id_jabatan         = $this->input->post('id_jabatan');
        $masalah            = $this->input->post('masalah');
        $solusi             = $this->input->post('solusi');
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        $array_data_tacit       = array(
                                        'judul'             =>  $judul,
                                        'id_divisi'         =>  $id_divisi,
                                        'id_jabatan'        =>  $id_jabatan,
                                        'masalah'           =>  $masalah,
                                        'solusi'            =>  $solusi,
                                        'diperbarui_pada'   =>  $diperbarui_pada,
                                        'diperbarui_oleh'   =>  $diperbarui_oleh
                                        );
        
        $this->Tacit_knowledge_model->update_tacit_knowledge($array_data_tacit, $id_tacit_knowledge);
        
        echo "<script> alert('Data Tacit Knowledge telah diperbarui');</script>";
        redirect(base_url('capture/profil/'.$id_tacit_knowledge),'refresh');
    }
    
    public function hapus()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $id_tacit_knowledge = $this->uri->segment(3); 
        
        $this->Tacit_knowledge_model->delete_tacit_knowledge($id_tacit_knowledge);
        
        echo "<script> alert('Data Tacit Knowledge telah dihapus');</script>";
        redirect(base_url('capture/daftar/'),'refresh');
    }
    
    public function hapus_komentar()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_karyawan');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $id_komentar_tacit_knowledge  = $this->uri->segment(3);
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Komentar Tacit Knowledge dimulai */
        if($id_komentar_tacit_knowledge == NULL)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Komentar Tacit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak adanya komentar dimulai */
        $cek_komentar   = $this->Komentar_tacit_model->komentar_by_id_komentar_tacit_knowledge($id_komentar_tacit_knowledge)->num_rows();
        if($cek_komentar == 0)
        {
            redirect(base_url('capture/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak adanya komentar berakhir */
        
        $id_tacit_knowledge         = $this->Komentar_tacit_model->komentar_by_id_komentar_tacit_knowledge($id_komentar_tacit_knowledge)->row()->id_tacit_knowledge;
        $id_tacit_knowledge_temp    = $id_tacit_knowledge;
        
        $this->Komentar_tacit_model-> delete_komentar_tacit_knowledge($id_komentar_tacit_knowledge);
        
        echo "<script> alert('Komentar telah dihapus');</script>";
        redirect(base_url('capture/profil/'.$id_tacit_knowledge_temp),'refresh');
    }
    
    function tambah_komentar()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_karyawan');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp                = $this->session->userdata('ktp');
        $id_tacit_knowledge = $this->input->post('id_tacit_knowledge');
        $komentar           = $this->input->post('komentar');
        $dibuat_pada        = date('Y-m-d H:i:s');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        $array_komentar_tacit   = array(
                                        'ktp'                   => $ktp,
                                        'id_tacit_knowledge'    => $id_tacit_knowledge,
                                        'komentar'              => $komentar,
                                        'dibuat_pada'           => $dibuat_pada);
        
        $this->Komentar_tacit_model->input_komentar_tacit_knowledge($array_komentar_tacit);
        
        echo "<script> alert('Komentar telah ditambahkan');</script>";
        redirect(base_url('capture/profil/'.$id_tacit_knowledge),'refresh');
    }
}