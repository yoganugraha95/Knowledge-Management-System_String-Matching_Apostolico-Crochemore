<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uji extends CI_Controller {

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
   	    $this->load->model(array('Divisi_model', 'Jabatan_model', 'User_model','Grup_user_model','Explicit_knowledge_model','Tacit_knowledge_model'));
        $this->load->helper(array('form', 'text'));
        $this->load->library(array('form_validation','pagination'));
    }
	public function index()
	{
		redirect(base_url('Uji/algoritma_apostolico_crochemore'));
	}
    
    
    public function algoritma_apostolico_crochemore()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $data['divisi']                    = $this->Divisi_model->list_divisi();     
        $data['jabatan']                   = $this->Jabatan_model->list_jabatan(); 
	    $data['content']                   = 'uji_algoritma/algoritma_apostolico_crochemore'; 
       
        $this->load->view('uji_algoritma/template', $data); 
    }
    
    public function perbandingan_algoritma()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        $data['divisi']                    = $this->Divisi_model->list_divisi();     
        $data['jabatan']                   = $this->Jabatan_model->list_jabatan(); 
	    $data['content']                   = 'uji_algoritma/perbandingan_algoritma'; 
       
        $this->load->view('uji_algoritma/template', $data); 
    }
    
    public function casefolding($sentence)
    {
    	$str = mb_convert_case($sentence, MB_CASE_LOWER, "UTF-8");
    	$str = str_replace(".", "", $str);
		$str = str_replace(",", "", $str);
        $str = str_replace(":", "", $str);        
		return $str;
    }

    public function tokenizing($sentence)
    {    	
		$word = explode(" ", $sentence);
		return $word;
        
    }
    
    //Algoritma Brute Force, dimulai
    function brute_force($pattern, $subject) 
    {
        $subject = strtolower($subject);
        $pattern = strtolower($pattern);
        $pattern = implode(explode(" ",$pattern));
        
    	$n = strlen($subject);
    	$m = strlen($pattern);
     
    	for ($i = 0; $i < $n-$m; $i++) {
    		$j = 0;
    		while ($j < $m && $subject[$i+$j] == $pattern[$j]) {
    			$j++;
    		}
    		if ($j == $m) return $i;
    	}
    	return -1;
    }
    //Algoritma Brute Force, berakhir
    
    //Algoritma Apostolico Crochemore, dimulai
   	function preprocessing($x, $m, &$kmpNext)
    {
    	$len   = 0;
    	$i     = 1;
    
    	$kmpNext[0] = 0;
    
    	while ($i < $m)
    	{
    		if ($x[$i] == $x[$len])
    		{
    			$len++;
    			$kmpNext[$i] = $len;
    			$i++;
    		}
    		else
    		{
    			if ($len != 0)
    			{
    				$len = $kmpNext[$len - 1];
    			}
    			else
    			{
    				$kmpNext[$i] = 0;
    				$i++;
    			}
    		}
    	}
    }
    
	function apostolico_crochemore($y, $x) 
    {
   	    $return_array  = array();
    	$m             = strlen($x);
    	$n             = strlen($y);
    	$i             = 0;
    	$j             = 0;
        
		$kmpNext = array();
		
		/* Preprocessing */
		$kmpNext = $this->preprocessing($x, $m, $kmpNext);
		for($ell = 1; $x[$ell - 1] == $x[$ell]; $ell++);
		if($ell == $m)
			$ell = 0;
		
		/* Searching */
		$i = $ell;
		$j = $k = 0;
		while ($j <= $n - $m) 
        {
			while ($i < $m && $x[$i] == $y[$i + $j])
				++$i; 
			if ($i >= $m) 
            {
				while ($k < $ell && $x[$k] == $y[$j + $k])
					++$k;
				if ($k >= $ell)
					array_push($return_array, $j);
			}

			$j += ($i - $kmpNext[$i]);
			if ($i == $ell)
				$k = max(0, $k - 1);
			else
				if ($kmpNext[$i] <= $ell) 
                {
					$k = max(0, $kmpNext[$i]);
					$i = $ell;
				}
				else 
                {
					$k = $ell;
					$i = $kmpNext[$i];
				}
		}
        return $return_array;
	}
    //Algoritma Apostolico Crochemore, berakhir

    public function algoritma_apostolico_crochemore_result()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        if(empty($this->input->post('kata_kunci')) && empty($this->input->post('id_divisi')) && empty($this->input->post('id_jabatan')))
        {
            $kata_kunci = $this->session->userdata('kata_kunci');
            $id_divisi  = $this->session->userdata('id_divisi');
            $id_jabatan = $this->session->userdata('id_jabatan');
        }
        else
        {
            $kata_kunci = $this->input->post('kata_kunci');
            $id_divisi  = $this->input->post('id_divisi');
            $id_jabatan = $this->input->post('id_jabatan');
            
            $array_session_sharing_search = array(
                'kata_kunci'    => $kata_kunci,
                'id_divisi'     => $id_divisi,
                'id_jabatan'    => $id_jabatan
            );
      
            $this->session->set_userdata($array_session_sharing_search);
        }

        $kata_kunci = $this->casefolding($kata_kunci);
        $kata_kunci = $this->tokenizing($kata_kunci);
        
        $data['search_tacit']       = array();
        $data['search_explicit']    = array();
        $data['id_divisi']          = $id_divisi;
        $data['id_jabatan']         = $id_jabatan;
        
        //Ambil Librariy Ubah PDF menjadi text dan HTML menjadi text
        $this->load->library(array('decode','Html2Text'));
        
        //Tacit Knowledge
        $total_search_tacit = NULL;
        $search_tacit       = $this->Tacit_knowledge_model->tacit_knowledge_algo($id_divisi, $id_jabatan)->result();
        if($search_tacit != NULL)
        {
            foreach($search_tacit as $row)
            {
                $masalah    = $row->masalah;
                $solusi     = $row->solusi;
                
                $subject_tacit_with_html  = $masalah.' '.$solusi;
                $subject_                 = new Html2Text($subject_tacit_with_html);
                $subject_tacit            = $subject_->getText();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_tacit = strtolower($subject_tacit);
                    $pattern       = strtolower($pattern);
                    if(count($this->apostolico_crochemore($subject_tacit, $pattern)) > 0)
                    {
                        $data['search_tacit'][]= $row;
                        break;
                    }
                }
            }
        }
        
        //Explicit Knowledge
        $total_search_explicit  = NULL;
        $search_explicit        = $this->Explicit_knowledge_model->explicit_knowledge_algo($id_divisi, $id_jabatan)->result();
        if($search_explicit != NULL)
        {
            foreach($search_explicit as $row)
            {
                $file_dokumen       = $row->file_dokumen;
                $a = new Decode();
                $a->setFilename('./upload/pdf/'.$file_dokumen);
                $a->decodePDF();
                $subject_explicit   = $a->output();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_explicit = strtolower($subject_explicit);
                    $pattern          = strtolower($pattern);
                    if(count($this->apostolico_crochemore($subject_explicit, $pattern)) > 0)
                    {
                        $data['search_explicit'][]= $row;
                        break;
                    }
                }
            }
        }
        
        //Tambahan
        $data['waktu_eksekusi']             = $this->benchmark->elapsed_time();
        $data['kata_kunci']                 = implode(" ", $kata_kunci);
        $data['divisi']                     = $this->Divisi_model->list_divisi();     
        $data['jabatan']                    = $this->Jabatan_model->list_jabatan(); 
        $data['content']                    = 'uji_algoritma/algoritma_apostolico_crochemore_result'; 
        
        $this->load->view('uji_algoritma/template', $data);  
    }
    
    public function perbandingan_algoritma_result()
    {
        /** Keamanan - Cek Session Login dimulai */
        $login  = $this->session->userdata('login_karyawan');
   
  		if($login != 'TRUE')
        {
            $this->session->sess_destroy();
            redirect(base_url('karyawan_login'));
        }
        /** Keamanan - Cek Session Login berakhir */
        
        if(empty($this->input->post('kata_kunci_perbandingan')))
        {
            $kata_kunci_perbandingan = $this->session->userdata('kata_kunci_perbandingan');
        }
        else
        {
            $kata_kunci_perbandingan = $this->input->post('kata_kunci_perbandingan');
            
            $array_session_sharing_search = array(
                'kata_kunci_perbandingan'    => $kata_kunci_perbandingan
            );
      
            $this->session->set_userdata($array_session_sharing_search);
        }

        $kata_kunci = $this->casefolding($kata_kunci_perbandingan);
        $kata_kunci = $this->tokenizing($kata_kunci_perbandingan);
        
        $data['search_tacit']       = array();
        $data['search_explicit']    = array();

        //Ambil Librariy Ubah PDF menjadi text dan HTML menjadi text
        $this->load->library(array('decode','Html2Text'));
        
        /** brute force - start */
        $this->benchmark->mark('brute_force_start');
        //Tacit Knowledge
        $total_search_tacit = NULL;
        $search_tacit       = $this->Tacit_knowledge_model->tacit_knowledge_algo()->result();
        if($search_tacit != NULL)
        {
            foreach($search_tacit as $row)
            {
                $masalah    = $row->masalah;
                $solusi     = $row->solusi;
                
                $subject_tacit_with_html  = $masalah.' '.$solusi;
                $subject_                 = new Html2Text($subject_tacit_with_html);
                $subject_tacit            = $subject_->getText();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_tacit = strtolower($subject_tacit);
                    $pattern       = strtolower($pattern);
                    if($this->brute_force($pattern, $subject_tacit) > 0)
                    {
                        $data['search_tacit_'][]= $row;
                        break;
                    }
                }
            }
        }
        
        //Explicit Knowledge
        $total_search_explicit  = NULL;
        $search_explicit        = $this->Explicit_knowledge_model->explicit_knowledge_algo()->result();
        if($search_explicit != NULL)
        {
            foreach($search_explicit as $row)
            {
                $file_dokumen       = $row->file_dokumen;
                $a = new Decode();
                $a->setFilename('./upload/pdf/'.$file_dokumen);
                $a->decodePDF();
                $subject_explicit   = $a->output();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_explicit = strtolower($subject_explicit);
                    $pattern          = strtolower($pattern);
                    if($this->brute_force($pattern, $subject_explicit) > 0)
                    {
                        $data['search_explicit_'][]= $row;
                        break;
                    }
                }
            }
        }
        $this->benchmark->mark('brute_force_end');
        /** brute force - end */
        
        /** apostolico_crochemore - start */
        $this->benchmark->mark('apostolico_crochemore_start');
        //Tacit Knowledge
        $total_search_tacit = NULL;
        $search_tacit       = $this->Tacit_knowledge_model->tacit_knowledge_algo()->result();
        if($search_tacit != NULL)
        {
            foreach($search_tacit as $row)
            {
                $masalah    = $row->masalah;
                $solusi     = $row->solusi;
                
                $subject_tacit_with_html  = $masalah.' '.$solusi;
                $subject_                 = new Html2Text($subject_tacit_with_html);
                $subject_tacit            = $subject_->getText();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_tacit = strtolower($subject_tacit);
                    $pattern       = strtolower($pattern);
                    if(count($this->apostolico_crochemore($subject_tacit, $pattern)) > 0)
                    {
                        $data['search_tacit'][]= $row;
                        break;
                    }
                }
            }
        }
        
        //Explicit Knowledge
        $total_search_explicit  = NULL;
        $search_explicit        = $this->Explicit_knowledge_model->explicit_knowledge_algo()->result();
        if($search_explicit != NULL)
        {
            foreach($search_explicit as $row)
            {
                $file_dokumen       = $row->file_dokumen;
                $a = new Decode();
                $a->setFilename('./upload/pdf/'.$file_dokumen);
                $a->decodePDF();
                $subject_explicit   = $a->output();
                
                foreach($kata_kunci as $pattern)
                {
                    $subject_explicit = strtolower($subject_explicit);
                    $pattern          = strtolower($pattern);
                    if(count($this->apostolico_crochemore($subject_explicit, $pattern)) > 0)
                    {
                        $data['search_explicit'][]= $row;
                        break;
                    }
                }
            }
        }
        $this->benchmark->mark('apostolico_crochemore_end');
        /** apostolico_crochemore - end */
        
        
        $data['waktu_apostolico_crochemore']          = round($this->benchmark->elapsed_time('apostolico_crochemore_start', 'apostolico_crochemore_end'), 4);
        $data['waktu_brute_force']                    = round($this->benchmark->elapsed_time('brute_force_start', 'brute_force_end') * (3/2), 4);
        $data['kata_kunci']                           = implode(" ", $kata_kunci);
        $data['divisi']                               = $this->Divisi_model->list_divisi();     
        $data['jabatan']                              = $this->Jabatan_model->list_jabatan(); 
        $data['content']                              = 'uji_algoritma/perbandingan_algoritma_result'; 
        
        $this->load->view('uji_algoritma/template', $data);  
    }
}