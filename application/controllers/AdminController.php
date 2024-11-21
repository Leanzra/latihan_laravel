<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session'); // Load the session library

        // Memeriksa apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect(base_url('login'));
        }
    }

    public function index() {
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $data['jumlah_pelanggan'] = $this->UserModel->ambil_jumlah_pelanggan();
        $data['jumlah_tarif'] = $this->UserModel->ambil_jumlah_tarif();
        $data['jumlah_penggunaan'] = $this->UserModel->ambil_jumlah_penggunaan();
        $data['jp_agen'] = $this->UserModel->jumlah_penggunaan_berdasarkan_id_petugas($id);
        $data['total_bayar'] = $this->UserModel->ambil_total_bayar();
        $data['pemasukan'] = $this->UserModel->hitung_total_pemasukan($id);


        $data['title'] = 'Admin Area';
        $this->load->view('templates/header', $data);
        $this->load->view('backend/dashboard');
        $this->load->view('templates/footer');
    }
}
