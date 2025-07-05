<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
	 parent::__construct();
	 	//validasi jika user belum login
        $this->data['CI'] =& get_instance();
        $this->load->helper(array('form', 'url'));
        $this->load->model('M_login');
        
	 }
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
	public function index()
	{
		$this->data['title_web'] = 'Login | Sistem Informasi Perpustakaan';
		$this->load->view('login_view',$this->data);
	}

    public function auth()
    {
        $user = htmlspecialchars($this->input->post('user',TRUE),ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass',TRUE),ENT_QUOTES);
        // auth
        $proses_login = $this->db->query("SELECT * FROM tbl_login WHERE user='$user' AND pass = md5('$pass')");
        $row = $proses_login->num_rows();
        if($row > 0)
        {
            $hasil_login = $proses_login->row_array();

            // create session
            $this->session->set_userdata('masuk_sistem_rekam',TRUE);
            $this->session->set_userdata('level',$hasil_login['level']);
            $this->session->set_userdata('ses_id',$hasil_login['id_login']);
            $this->session->set_userdata('anggota_id',$hasil_login['anggota_id']);

            echo '<script>window.location="'.base_url().'dashboard";</script>';
        }else{

            echo '<script>alert("Login Gagal, Periksa Kembali Username dan Password Anda");
            window.location="'.base_url().'"</script>';
        }
    }

    // New method for AJAX authentication
    public function auth_ajax()
    {
        $user = htmlspecialchars($this->input->post('user',TRUE),ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass',TRUE),ENT_QUOTES);
        
        $response = array();
        
        // First check if username exists
        $check_user = $this->db->query("SELECT * FROM tbl_login WHERE user='$user'");
        $user_exists = $check_user->num_rows();
        
        if($user_exists == 0) {
            // Username doesn't exist
            $response['status'] = 'error';
            $response['error_type'] = 'username';
            $response['message'] = 'Username tidak ditemukan';
        } else {
            // Username exists, now check password
            $proses_login = $this->db->query("SELECT * FROM tbl_login WHERE user='$user' AND pass = md5('$pass')");
            $row = $proses_login->num_rows();
            
            if($row > 0) {
                // Login successful
                $hasil_login = $proses_login->row_array();

                // create session
                $this->session->set_userdata('masuk_sistem_rekam',TRUE);
                $this->session->set_userdata('level',$hasil_login['level']);
                $this->session->set_userdata('ses_id',$hasil_login['id_login']);
                $this->session->set_userdata('anggota_id',$hasil_login['anggota_id']);

                $response['status'] = 'success';
                $response['message'] = 'Login berhasil';
                $response['redirect'] = base_url('dashboard');
            } else {
                // Password wrong
                $response['status'] = 'error';
                $response['error_type'] = 'password';
                $response['message'] = 'Password salah';
            }
        }
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Improved auth method (non-AJAX version)
    public function auth_improved()
    {
        $user = htmlspecialchars($this->input->post('user',TRUE),ENT_QUOTES);
        $pass = htmlspecialchars($this->input->post('pass',TRUE),ENT_QUOTES);
        
        // First check if username exists
        $check_user = $this->db->query("SELECT * FROM tbl_login WHERE user='$user'");
        $user_exists = $check_user->num_rows();
        
        if($user_exists == 0) {
            // Username doesn't exist
            $this->data['error_message'] = 'Username tidak ditemukan!';
            $this->data['error_type'] = 'username';
            $this->data['username'] = $user;
            $this->data['title_web'] = 'Login | Sistem Informasi Perpustakaan';
            $this->load->view('login_view',$this->data);
        } else {
            // Username exists, now check password
            $proses_login = $this->db->query("SELECT * FROM tbl_login WHERE user='$user' AND pass = md5('$pass')");
            $row = $proses_login->num_rows();
            
            if($row > 0) {
                // Login successful
                $hasil_login = $proses_login->row_array();

                // create session
                $this->session->set_userdata('masuk_sistem_rekam',TRUE);
                $this->session->set_userdata('level',$hasil_login['level']);
                $this->session->set_userdata('ses_id',$hasil_login['id_login']);
                $this->session->set_userdata('anggota_id',$hasil_login['anggota_id']);

                redirect('dashboard');
            } else {
                // Password wrong
                $this->data['error_message'] = 'Password salah!';
                $this->data['error_type'] = 'password';
                $this->data['username'] = $user;
                $this->data['title_web'] = 'Login | Sistem Informasi Perpustakaan';
                $this->load->view('login_view',$this->data);
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        echo '<script>window.location="'.base_url().'";</script>';
    }
}