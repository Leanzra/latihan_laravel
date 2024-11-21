<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form'); // Load the form helper
        $this->load->library('session'); // Load the session library
        $this->load->model('UserModel'); // Load the model
    }

    public function index() {
        $data['title'] = 'Login';
        $this->load->view('halaman_login', $data);
    }

    public function login() {
        // Check if user is already logged in
        if ($this->session->userdata('session_id')) {
            $this->session->set_flashdata('alert', 'already_logged_in');
            redirect(base_url('admin'));
        }

        // Check if request method is POST
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $username = $this->input->post('username', TRUE); // XSS Filtering
            $password = $this->input->post('password', TRUE); // XSS Filtering

            // Validate input
            if (empty($username) || empty($password)) {
                $data['title'] = 'Login';
                $data['error_message'] = 'Username or password cannot be empty';
                $this->load->view('halaman_login', $data);
                return; // Stop execution
            }

            $user = $this->UserModel->dapatkan_akun_petugas($username);

            if ($user) {
                // Verify password using password_verify
                if (md5($password, $user['password'])) {
                    // Prepare session data
                    $session_data = array(
                        'session_id' => $user['id_petugas'],
                        'session_username' => $user['username'],
                        'session_nama_petugas' => $user['nama_petugas'],
                        'session_foto' => $this->dapatkan_foto_profil($user['foto_profil']),
                        'session_akses' => $user['akses']
                    );

                    // Set session data
                    $this->session->set_flashdata('alert', 'login_success');
                    $this->session->set_userdata($session_data);

                    // Redirect to admin page
                    redirect(base_url('admin'));
                } else {
                    // Password incorrect
                    $data['title'] = 'Login';
                    $data['error_message'] = 'Invalid username or password';
                    $this->load->view('halaman_login', $data); // Pass data to the view
                }
            } else {
                // Username not found
                $data['title'] = 'Login';
                $data['error_message'] = 'Invalid username or password';
                $this->load->view('halaman_login', $data); // Pass data to the view
            }
        } else {
            // Display login page if not POST
            $data['title'] = 'Login';
            $this->load->view('halaman_login', $data);
        }
    }

    public function logout() {
        // Destroy the session
        $this->session->sess_destroy();

        // Redirect to login page or home page
        redirect('login');
    }

    // Ensure you have a method to get profile picture URL if needed
    private function dapatkan_foto_profil($foto_profil) {
        if (empty($foto_profil)) {
            return 'assets/images/foto_profil/foto-default.png';
        }
        return 'assets/images/foto_profil/' . $foto_profil;
    }
}
