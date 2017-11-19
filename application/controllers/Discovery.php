<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Discovery extends CI_Controller {

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
   	    $this->load->model(array('Divisi_model','Jabatan_model','User_model','Grup_user_model','Explicit_knowledge_model','Komentar_explicit_model'));
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
		redirect(base_url('discovery/tambah'));
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
	    $data['content']   = 'karyawan/discovery_tambah'; 
       
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
        $dibuat_pada        = date('Y-m-d H:i:s');
        $dibuat_oleh        = $this->session->userdata('ktp');
        $status_validasi    = 'FALSE';
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Konfigurasi unggah foto profil dimulai */
        $config['upload_path']          = './upload/pdf/';
        $config['allowed_types']        = 'pdf';
        $config['encrypt_name']    		= TRUE;
        $config['file_ext_tolower']     = TRUE;
        /** Konfigurasi unggah foto profil berakhir */

        $this->load->library('upload', $config); 

        if(!$this->upload->do_upload('userfile')) 
        {
            echo "<script> alert('Dokumen Explicit Knowledge gagal diunggah');</script>";
            redirect(base_url('discovery/tambah_data/'), 'refresh');       
        }
        else //Jika Dokumen PDF berhasil diunggah
        {    
            /** Tampung Hasil Input-an di Array dimulai */
            $upload_data            = $this->upload->data(); 
            $file_dokumen           = $upload_data['file_name'];
            $array_data_explicit    = array(
                                        'ktp'               =>  $ktp,
                                        'judul'             =>  $judul,
                                        'id_divisi'         =>  $id_divisi,
                                        'id_jabatan'        =>  $id_jabatan,
                                        'file_dokumen'      =>  $file_dokumen,
                                        'dibuat_pada'       =>  $dibuat_pada,
                                        'dibuat_oleh'       =>  $dibuat_oleh,
                                        'status_validasi'   =>  $status_validasi,
                                           );
            /** Tampung Hasil Input-an di Array berakhir */
            
        $this->Explicit_knowledge_model->input_explicit_knowledge($array_data_explicit); 
        
        echo "<script> alert('Data Explicit Knowledge telah ditambahkan');</script>";
        redirect(base_url('discovery/daftar'),'refresh');  
        }
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
        
        $data['daftar_explicit_knowledge']  = $this->Explicit_knowledge_model->list_explicit_knowledge_by_ktp($ktp);
   	    $data['content']                    = 'karyawan/explicit_daftar'; 
       
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
        
        $id_explicit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge dimulai */
        if($id_explicit_knowledge == NULL)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge dimulai */
        $cek_explicit      = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->num_rows();
        if($cek_explicit == 0)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge berakhir */
        
        /** Keamanan - Cek Explicit Knowledge telah divalidasi atau belum dimulai */
        $cek_validasi_explicit_knowledge   = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->status_validasi;
        $ktp_pembuat_explicit_knowledge    = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->ktp;
        if(($cek_validasi_explicit_knowledge == 'FALSE') && ($ktp != $ktp_pembuat_explicit_knowledge))
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }       
        /** Keamanan - Cek Explicit Knowledge telah divalidasi atau belum berakhir */
        
        /** Keamanan - Cek hak untuk menyunting Tacit Knowledge dimulai */
        $hak_akses_karyawan_ahli                      = $this->session->userdata('login_karyawan_ahli');
        $hak_sunting_dan_hapus_explicit_knowledge     = NULL;
        $hak_validasi_explicit_knowledge              = NULL;
        $status_validasi_explicit_knowledge           = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->status_validasi;
        if($hak_akses_karyawan_ahli == 'TRUE')
        {
            $hak_sunting_dan_hapus_explicit_knowledge = 'TRUE';
            if($status_validasi_explicit_knowledge == 'FALSE')
            {
                $hak_validasi_explicit_knowledge = 'TRUE';                  
            }
        }
        
        if($ktp_pembuat_explicit_knowledge == $ktp)
        {
            $hak_sunting_dan_hapus_explicit_knowledge  = 'TRUE';
        }
        /** Keamanan - Cek hak untuk menyunting Tacit Knowledge berakhir */
        
        $data['ktp_session']                                    = $ktp;
        $data['ktp_pembuat_explicit_knowledge']                 = $ktp_pembuat_explicit_knowledge;
        $data['id_explicit_knowledge']                          = $id_explicit_knowledge;
        $data['judul_explicit_knowledge']                       = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->judul;
        $data['waktu_publikasi_explicit_knowledge']             = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->dibuat_pada;
        $data['profil_explicit_knowledge']                      = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge);
   	    $data['komentar_explicit_knowledge']                    = $this->Komentar_explicit_model-> komentar_by_id_explicit($id_explicit_knowledge);
        $data['hak_sunting_dan_hapus_explicit_knowledge']       = $hak_sunting_dan_hapus_explicit_knowledge;
        $data['hak_validasi_explicit_knowledge']                = $hak_validasi_explicit_knowledge;
        $data['content']                                        = 'karyawan/explicit_profil';
       
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
        
        $id_explicit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge dimulai */
        if($id_explicit_knowledge == NULL)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge dimulai */
        $cek_explicit      = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->num_rows(); 
        if($cek_explicit == 0)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge berakhir */
        
        $diperbarui_pada        = date('Y-m-d H:i:s');
        $diperbarui_oleh        = $this->session->userdata('ktp');
        $status_validasi        = 'TRUE';
        $divalidasi_pada        = date('Y-m-d H:i:s');
        $divalidasi_oleh        = $this->session->userdata('ktp');
        
        $array_data_explicit    = array(
                                        'diperbarui_pada'   => $diperbarui_pada,
                                        'diperbarui_oleh'   => $diperbarui_oleh,
                                        'status_validasi'   => $status_validasi,
                                        'divalidasi_pada'   => $divalidasi_pada,
                                        'divalidasi_oleh'   => $divalidasi_oleh
                                        );
        
        $this->Explicit_knowledge_model->update_explicit_knowledge($array_data_explicit, $id_explicit_knowledge);
        
        echo "<script> alert('Data Explicit Knowledge telah divalidasi');</script>";
        redirect(base_url('discovery/profil/'.$id_explicit_knowledge),'refresh');
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
        
        $id_explicit_knowledge = $this->uri->segment(3); 
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge dimulai */
        if($id_explicit_knowledge == NULL)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Explicit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge dimulai */
        $cek_explicit      = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->num_rows();
        if($cek_explicit == 0)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada Data Explicit Knowledge berdasarkan ID Explicit Knowledge berakhir */
        
        $data['id_explicit_knowledge']      = $id_explicit_knowledge;
        $data['judul_explicit_knowledge']   = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->judul;
        $data['profil_explicit_knowledge']  = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge);
   	    $data['divisi']                     = $this->Divisi_model->list_divisi(); 
        $data['jabatan']                    = $this->Jabatan_model->list_jabatan(); 
        $data['content']                    = 'karyawan/explicit_ubah'; 
       
        $this->load->view('karyawan/template', $data);  
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
        $id_explicit_knowledge  = $this->input->post('id_explicit_knowledge');
        $judul                  = $this->input->post('judul');
        $id_divisi              = $this->input->post('id_divisi');
        $id_jabatan             = $this->input->post('id_jabatan');
        $diperbarui_pada        = date('Y-m-d H:i:s');
        $diperbarui_oleh        = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Hapus file dokumen sebelumnya dimulai */
        $dokumen_sebelumnya = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->file_dokumen;
        $path   = './upload/pdf/'.$dokumen_sebelumnya;
        unlink($path);
        /** Hapus file dokumen sebelumnya berakhir */
        
        /** Konfigurasi unggah foto profil dimulai */
        $config['upload_path']          = './upload/pdf/';
        $config['allowed_types']        = 'pdf';
        $config['encrypt_name']    		= TRUE;
        $config['file_ext_tolower']     = TRUE;
        /** Konfigurasi unggah foto profil berakhir */

        $this->load->library('upload', $config); 

        if(!$this->upload->do_upload('userfile')) 
        {
            echo "<script> alert('Dokumen Explicit Knowledge gagal diunggah');</script>";
            redirect(base_url('discovery/profil/'.$id_explicit_knowledge), 'refresh');       
        }
        else //Jika Dokumen PDF berhasil diunggah
        {    
            /** Tampung Hasil Input-an di Array dimulai */
            $upload_data            = $this->upload->data(); 
            $file_dokumen           = $upload_data['file_name'];
            $array_data_explicit    = array(
                                        'judul'             =>  $judul,
                                        'id_divisi'         =>  $id_divisi,
                                        'id_jabatan'        =>  $id_jabatan,
                                        'file_dokumen'      =>  $file_dokumen,
                                        'diperbarui_pada'   =>  $diperbarui_pada,
                                        'diperbarui_oleh'   =>  $diperbarui_oleh
                                           );
            /** Tampung Hasil Input-an di Array berakhir */
            
        $this->Explicit_knowledge_model->update_explicit_knowledge($array_data_explicit, $id_explicit_knowledge);
        
        echo "<script> alert('Data Explicit Knowledge telah divalidasi');</script>";
        redirect(base_url('discovery/profil/'.$id_explicit_knowledge),'refresh');  
        }
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
        
        $id_explicit_knowledge = $this->uri->segment(3); 
        
        /** Hapus file dokumen sebelumnya dimulai */
        $dokumen_sebelumnya = $this->Explicit_knowledge_model->profil_explicit_knowledge($id_explicit_knowledge)->row()->file_dokumen;
        $path   = './upload/pdf/'.$dokumen_sebelumnya;
        unlink($path);
        /** Hapus file dokumen sebelumnya berakhir */
            
        $this->Explicit_knowledge_model->delete_explicit_knowledge($id_explicit_knowledge);
        
        echo "<script> alert('Data Explicit Knowledge telah dihapus');</script>";
        redirect(base_url('discovery/daftar/'),'refresh');
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
        
        $id_komentar_explicit_knowledge  = $this->uri->segment(3);
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Komentar Explicit Knowledge dimulai */
        if($id_komentar_explicit_knowledge == NULL)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel ID Komentar Explicit Knowledge berakhir */
        
        /** Keamanan - Cek ada atau tidak adanya komentar dimulai */
        $cek_komentar   = $this->Komentar_explicit_model->komentar_by_id_komentar_explicit_knowledge($id_komentar_explicit_knowledge)->num_rows();
        if($cek_komentar == 0)
        {
            redirect(base_url('discovery/daftar'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak adanya komentar berakhir */
        
        $id_explicit_knowledge         = $this->Komentar_explicit_model->komentar_by_id_komentar_explicit_knowledge($id_komentar_explicit_knowledge)->row()->id_explicit_knowledge;
        $id_explicit_knowledge_temp    = $id_explicit_knowledge;
        
        $this->Komentar_explicit_model->delete_komentar_explicit_knowledge($id_komentar_explicit_knowledge);
        
        echo "<script> alert('Komentar telah dihapus');</script>";
        redirect(base_url('discovery/profil/'.$id_explicit_knowledge_temp),'refresh');
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
        $ktp                    = $this->session->userdata('ktp');
        $id_explicit_knowledge  = $this->input->post('id_explicit_knowledge');
        $komentar               = $this->input->post('komentar');
        $dibuat_pada            = date('Y-m-d H:i:s');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        $array_komentar_explicit   = array(
                                        'ktp'                       => $ktp,
                                        'id_explicit_knowledge'     => $id_explicit_knowledge,
                                        'komentar'                  => $komentar,
                                        'dibuat_pada'               => $dibuat_pada);
        
        $this->Komentar_explicit_model->input_komentar_explicit_knowledge($array_komentar_explicit);
        
        echo "<script> alert('Komentar telah ditambahkan');</script>";
        redirect(base_url('discovery/profil/'.$id_explicit_knowledge),'refresh');
    }
}