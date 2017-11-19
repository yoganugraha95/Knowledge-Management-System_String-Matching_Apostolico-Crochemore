<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

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
   	    $this->load->model(array('User_model', 'Divisi_model', 'Jabatan_model', 'Hak_akses_model', 'Grup_user_model', 'Tacit_knowledge_model', 'Explicit_knowledge_model')); //Load Model (File-file yang ada di Folder Model)
        $this->load->helper('form');
        $this->load->library('form_validation');
    }
	public function index()
	{
		redirect(base_url('karyawan/daftar')); 
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
        
        $data['daftar_karyawan']    = $this->User_model->list_user(); //Ambil Data Daftar Karyawan (User_model.php)
	    $data['content']            = 'admin/karyawan_daftar'; //Ambil Halaman Daftar Karyawan (karyawan_daftar.php)
       
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
        
        $data['divisi']    = $this->Divisi_model->list_divisi(); //Ambil Data Daftar Divisi (Divisi_model.php)    
        $data['jabatan']   = $this->Jabatan_model->list_jabatan(); //Ambil Data Daftar Jabatan (Jabatan_model.php)
        $data['hak_akses'] = $this->Hak_akses_model->list_hak_akses(); //Ambil Daftar Data Hak Akses User (Hak_akses_model.php)
	    $data['content']   = 'admin/karyawan_input'; //Ambil Halaman Input Karyawan (karyawan_input.php)
       
        $this->load->view('admin/template', $data); //Load View (Munculkan tampilan web)
    }
    
    public function add()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp            = trim(strip_tags($this->input->post('ktp')));
        $nik            = trim(strip_tags($this->input->post('nik')));
        $email          = $this->input->post('email');
        $password       = trim(strip_tags($this->input->post('password')));
        $nama           = $this->input->post('nama');
        $id_divisi      = $this->input->post('id_divisi');
        $id_jabatan     = $this->input->post('id_jabatan');
        $alamat         = $this->input->post('alamat'); 
        $no_hp          = $this->input->post('no_hp');
        $status_aktif   = 'TRUE';
        $dibuat_pada    = date('Y-m-d H:i:s');
        $dibuat_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Keamanan - Cek Data No. KTP yang di-input sudah ada atau belum di database dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows();
        if($cek_data_ktp > 0)
        {
   	        echo "<script> alert('Data KTP telah digunakan');</script>";
            redirect(base_url('karyawan/input'),'refresh');
        }
        /** Keamanan - Cek Data No. KTP yang di-input sudah ada atau belum di database berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan    = array(
                                        'ktp'           =>  $ktp,
                                        'nik'           =>  $nik,
                                        'email'         =>  $email,
                                        'password'      =>  md5($password),
                                        'nama'          =>  $nama,
                                        'id_divisi'     =>  $id_divisi,
                                        'id_jabatan'    =>  $id_jabatan,
                                        'alamat'        =>  $alamat,
                                        'no_hp'         =>  $no_hp,
                                        'status_aktif'  =>  $status_aktif,
                                        'dibuat_pada'   =>  $dibuat_pada,
                                        'dibuat_oleh'   =>  $dibuat_oleh
                                       );
        /** Tampung Hasil Input-an di Array berakhir */
        
        /** Hitung Jumlah Hak Akses yang di-input dimulai */
        $id_hak_akses        = $this->input->post('id_hak_akses'); //Input ID Hak Akses dari Form
        $count_id_hak_akses  = count($id_hak_akses); //Hitung ID Hak Akses yang di-input
        /** Hitung Jumlah Hak Akses yang di-input berakhir */
        
        /** Keamanan - Cek Jumlah Hak Akses yang di-input dimulai */
        if($count_id_hak_akses < 1) 
        {
            echo "<script> alert('Hak akses pengguna belum ditambahkan, ulangi pengisian Data Karyawan');</script>";
            redirect(base_url('karyawan/input'),'refresh');
        }
        /** Keamanan - Cek Jumlah Hak Akses yang di-input berakhir */
        
        /** Transaction dimulai, ini digunakan untuk menghindari input-an yang tidak sempurna jika koneksi putus, mengingat dalam satu kali transaksi ada banyak yang di-input */
        $this->db->trans_start(); //Proses Transaction dimulai dari sini
            $this->User_model->input_user($array_data_karyawan); //Input Array Data Karyawan ke Tabel User (User_model.php)

            for($i = 0; $i < $count_id_hak_akses; $i++) //Perulangan berdasarkan jumlah ID Hak Akses
            {
                //Data yang di-input untuk ke Tabel Grup_User
                $ktp             = $ktp; 
                $id_hak_akses    = $this->input->post('id_hak_akses');
                $id_hak_akses    = $id_hak_akses[$i]; //$i = Index Array
                
                //Array Hak Akses Karyawan yang akan ditambahkan
                $array_data_grup_user   = array(
                                                'ktp'           => $ktp,
                                                'id_hak_akses'  => $id_hak_akses,
                                                'dibuat_pada'   => date('Y-m-d H:i:s')
                                                );
                
                $this->Grup_user_model->input_grup_user($array_data_grup_user); //Input Array Hak Akses Karyawan ke Tabel Grup_user (Grup_user_model.php)
            }
        $this->db->trans_complete(); //Proses Transaction berakhir disini
        
        // Pengkondisian jika koneksi putus atau tidak putus
        if($this->db->trans_status() === FALSE) //Jika koneksi putus
        {
            $this->db->trans_rollback(); //Karena koneksi putus, batalkan proses input
       	    echo "<script> alert('Koneksi putus, Data Karyawan gagal ditambahkan');</script>";
            redirect(base_url('karyawan/input'),'refresh'); 
        }
        else
        {
            $this->db->trans_commit(); //Jika koneksi tidak putus, lakukan proses Input
            echo "<script> alert('Data Karyawan telah ditambahkan');</script>";
            redirect(base_url('karyawan'),'refresh'); 
        }  
        /** Transaction berakhir */
    }
    
    public function profil()
    {        
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        $data['ktp']                = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_karyawan']    = $this->User_model->data_by_ktp($ktp); //Ambil Data Karyawan berdasarkan No.KTP/$ktp (User_model.php)
        $data['hak_akses']          = $this->Grup_user_model->list_hak_akses($ktp); //Ambil Seluruh Hak Akses yang dimiliki oleh Karyawan dengan No.KTP/$ktp (Grup_user_model.php)
        $data['jumlah_tacit']       = $this->Tacit_knowledge_model->hitung_jumlah_tacit_by_ktp($ktp); //Ambil Jumlah Tacit Knowledge berdasarkan No.KTP/$ktp (Tacit_knowledge_model.php)
        $data['jumlah_explicit']    = $this->Explicit_knowledge_model->hitung_jumlah_explicit_by_ktp($ktp); //Ambil Jumlah Explicit Knowledge berdasarkan No.KTP/$ktp (Explicit_knowledge_model.php)
        $data['content']            = 'admin/karyawan_profil'; //Ambil Halaman Profil Karyawan (karyawan_profil.php)
        
        $this->load->view('admin/template', $data);  //Load View (Munculkan tampilan web) 
    }
    
    public function ubah_data_pribadi()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        $data['divisi']                 = $this->Divisi_model->list_divisi(); //Ambil Data Daftar Divisi (Divisi_model.php)    
        $data['jabatan']                = $this->Jabatan_model->list_jabatan(); //Ambil Data Daftar Jabatan (Jabatan_model.php)
        $data['ktp']                    = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_karyawan']        = $this->User_model->data_by_ktp($ktp); //Ambil Data Karyawan berdasarkan No.KTP/$ktp (User_model.php)
        $data['content']                = 'admin/karyawan_ubah_data_pribadi'; //Ambil Halaman Ubah Data Karyawan (karyawan_ubah_data_pribadi.php)
        
        $this->load->view('admin/template', $data); //Load View (Munculkan tampilan web) 
    }
    
    public function perbarui_data_pribadi()
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
        $ktp                = trim(strip_tags($this->input->post('ktp')));
        $nik                = trim(strip_tags($this->input->post('nik')));
        $email              = $this->input->post('email');
        $nama               = $this->input->post('nama');
        $id_divisi          = $this->input->post('id_divisi');
        $id_jabatan         = $this->input->post('id_jabatan');
        $alamat             = $this->input->post('alamat'); 
        $no_hp              = $this->input->post('no_hp');
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan    = array(
                                        'nik'               =>  $nik,
                                        'email'             =>  $email,
                                        'nama'              =>  $nama,
                                        'id_divisi'         =>  $id_divisi,
                                        'id_jabatan'        =>  $id_jabatan,
                                        'alamat'            =>  $alamat,
                                        'no_hp'             =>  $no_hp,
                                        'diperbarui_pada'   =>  $diperbarui_pada,
                                        'diperbarui_oleh'   =>  $diperbarui_oleh
                                       );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->User_model->update_user($ktp, $array_data_karyawan); //Perbarui Data Pribadi Karyawan (User_model.php)
        
        echo "<script> alert('Data Pribadi telah diperbarui');</script>";
        redirect(base_url('karyawan/profil/'.$ktp), 'refresh');
    }
    
    public function perbarui_foto_profil()
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
        $ktp                = trim(strip_tags($this->input->post('ktp')));
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
   
        /** Konfigurasi unggah foto profil dimulai */
        $config['upload_path']          = './upload/image/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 500;
        $config['max_width']            = 1024;
        $config['max_height']           = 1024;
        $config['encrypt_name']    		= TRUE;
        $config['file_ext_tolower']     = TRUE;
        /** Konfigurasi unggah foto profil berakhir */

        $this->load->library('upload', $config); //Load konfigurasi unggah foto profil dimulai

        if(!$this->upload->do_upload('userfile')) //Jika foto profil gagal diunggah
        {
            echo "<script> alert('Foto gagal diunggah');</script>";
            redirect(base_url('karyawan/ubah_data_pribadi/'.$ktp), 'refresh');       
        }
        else //Jika foto profil berhasil diunggah
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
            
            $this->User_model->update_user($ktp, $array_data_karyawan); //Perbarui Foto Profil Karyawan (User_model.php)
            echo "<script> alert('Foto diunggah');</script>";
            redirect(base_url('karyawan/profil/'.$ktp), 'refresh');  
        }
    }
    
    public function ubah_password()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        $data['ktp']                = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_karyawan']    = $this->User_model->data_by_ktp($ktp); //Ambil Data Karyawan berdasarkan No.KTP/$ktp (User_model.php)
        $data['content']            = 'admin/karyawan_ubah_password'; //Ambil Halaman Ubah Password Karyawan (karyawan_ubah_password.php)
        
        $this->load->view('admin/template', $data); 
    }

    public function perbarui_password()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp                = $this->input->post('ktp');
        $password           = trim(strip_tags($this->input->post('password')));
        $diperbarui_pada    = date('Y-m-d H:i:s');
        $diperbarui_oleh    = $this->session->userdata('ktp');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan = array(
                                    'password'          => md5($password),
                                    'diperbarui_pada'   => $diperbarui_pada,
                                    'diperbarui_oleh'   => $diperbarui_oleh                                    
                                    );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->User_model->update_user($ktp, $array_data_karyawan); //Perbarui Data Karyawan (User_model.php)
        
        echo "<script> alert('Data Password telah diperbarui');</script>";
        redirect(base_url('karyawan/profil/'.$ktp), 'refresh');
    }
    
    public function ubah_hak_akses()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        $data['ktp']                     = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_karyawan']        = $this->User_model->data_by_ktp($ktp); //Ambil Data Karyawan berdasarkan No.KTP/$ktp (User_model.php)
        $data['content']                = 'admin/karyawan_ubah_password'; //Ambil Halaman Ubah Password Karyawan (karyawan_ubah_password.php)
        $data['hak_akses_aktif']        = $this->Grup_user_model->list_hak_akses($ktp); //Ambil Data Hak Akses yang dimiliki oleh Karyawan
        $data['hak_akses_non_aktif']    = $this->Hak_akses_model->get_hak_akses_non_aktif($ktp); //Ambil Data Hak Akses yang tidak dimiliki oleh Karyawan
        $data['content']                = 'admin/karyawan_ubah_hak_akses'; //Ambil Halaman Ubah Hak Akses Karyawan (karyawan_ubah_hak_akses.php)
        
        $this->load->view('admin/template', $data); 
    }
    
    public function hapus_hak_akses()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp                = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        $ktp_session        = $this->session->userdata('ktp'); //Nilai No.KTP/$ktp berasal dari Session
        $id_grup_user       = $this->uri->segment(4); //Nilai ID Grup User berasal dari segment 4 di URL
        $id_hak_akses       = $this->Grup_user_model->data_by_id_grup_user($id_grup_user)->row()->id_hak_akses; //Ambil Data ID Hak Akses berdasarkan ID User Grup (Grup_user_model.php)
        $hak_akses_aktif    = $this->Grup_user_model->list_hak_akses($ktp); //Ambil Data Hak Akses yang dimiliki oleh Karyawan
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        /** Keamanan - Agar Admin tidak dapat menghapus Hak Akses Admin yang sedang digunakannya dimulai */
        if(($ktp_session == $ktp) && ($id_hak_akses == 1))
        {
            echo "<script> alert('Anda sekarang menggunakan Hak Akses Admin, Hak Akses Admin tidak dapat dihapus');</script>";
            redirect(base_url('karyawan/ubah_hak_akses/'.$ktp), 'refresh');
        }
        /** Keamanan - Agar Admin tidak dapat menghapus Hak Akses Admin yang sedang digunakannya berakhir */
        
        /** Keamanan - Cek Jumlah Hak Akses Karyawan yang sedang digunakan dimulai */
        if($hak_akses_aktif->num_rows() == 1)
        {
            echo "<script> alert('Hak Akses tinggal satu, tidak dapat dihapus');</script>";
            redirect(base_url('karyawan/ubah_hak_akses/'.$ktp), 'refresh');
        }
        /** Keamanan - Cek Jumlah Hak Akses Karyawan yang sedang digunakan berakhir */
        
        $this->Grup_user_model->delete_hak_akses($id_grup_user); //Hapus Data Hak Akses Karyawan
        
        redirect(base_url('karyawan/ubah_hak_akses/'.$ktp), 'refresh');
    }
    
    public function tambah_hak_akses()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp            = $this->input->post('ktp');
        $id_hak_akses   = $this->input->post('id_hak_akses');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_grup_user = array(
                                      'ktp'             => $ktp,
                                      'id_hak_akses'    => $id_hak_akses,
                                      'dibuat_pada'     => date('Y-m-d H:i:s')
                                      );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->Grup_user_model->input_grup_user($array_data_grup_user); //Tambah Data Hak Akses Karyawan (Grup_user_model.php)
        redirect(base_url('karyawan/ubah_hak_akses/'.$ktp), 'refresh');
    }
    
    public function ubah_status_akun()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $ktp    = $this->uri->segment(3); //Nilai No.KTP/$ktp berasal dari segment 3 di URL
        
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp dimulai */
        if($ktp == NULL)
        {
            redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidak ada nilai variabel $ktp berakhir */
        
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */
        
        if($ktp == $this->session->userdata('ktp'))
        {
            echo "<script> alert('Anda sedang menggunakan akun ini, status akun tidak dapat diubah');</script>";
            redirect(base_url('karyawan/profil/'.$ktp), 'refresh');
        }
        
        $data['ktp']                = $ktp; //Ambil Data No.KTP/$ktp
        $data['profil_karyawan']    = $this->User_model->data_by_ktp($ktp); //Ambil Data Karyawan berdasarkan No.KTP/$ktp (User_model.php)
        $data['content']            = 'admin/karyawan_ubah_status_akun'; //Ambil Halaman Ubah Status Akun Karyawan (karyawan_ubah_status_akun.php)
        
        $this->load->view('admin/template', $data); //Load View (Munculkan tampilan web)
    }
    
    public function perbarui_status_akun()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login          = $this->session->userdata('login_admin');
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('admin_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel dimulai */
        $ktp                = $this->input->post('ktp');
        $status_aktif       = $this->input->post('status_aktif');
        $ktp_session        = $this->session->userdata('ktp');
        $diperbarui_pada    = date('Y-m-d H:i:s');
        /** Ambil seluruh data dari hasil input form, dimasukkan ke variabel berakhir */

        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp dimulai */
        $cek_data_ktp   = $this->User_model->data_by_ktp($ktp)->num_rows(); //Hitung jumlah baris Data User berdasarkan No.KTP/$ktp (User_model.php)
        if($cek_data_ktp == 0)
        {
   	        redirect(base_url('karyawan'),'refresh');
        }
        /** Keamanan - Cek ada atau tidaknya data User berdasarkan No.KTP/$ktp berakhir */

        /** Keamanan - Cek No. KTP sudah digunakan atau belum dimulai*/
        if($ktp == $ktp_session)
        {
            echo "<script> alert('Anda sedang menggunakan akun ini, status akun tidak dapat diubah');</script>";
            redirect(base_url('karyawan/profil/'.$ktp), 'refresh');
        }
        /** Keamanan - Cek No. KTP sudah digunakan atau belum berakhir*/
        
        /** Tampung Hasil Input-an di Array dimulai */
        $array_data_karyawan = array(
                                    'status_aktif'      => $status_aktif,
                                    'diperbarui_oleh'   => $ktp_session,
                                    'diperbarui_pada'   => $diperbarui_pada
                                    );
        /** Tampung Hasil Input-an di Array berakhir */
        
        $this->User_model->update_user($ktp, $array_data_karyawan); //Perbarui Data Karyawan (User_model.php)
        
        echo "<script> alert('Data Status Akun telah diperbarui');</script>";
        redirect(base_url('karyawan/profil/'.$ktp), 'refresh');
    }
}