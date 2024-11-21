<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PelangganController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PelangganModel'); // Memuat model PelangganModel
        $this->load->model('TarifModel');  
        $this->load->model('UserModel'); // Pastikan model UserModel juga dimuat
        
        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    // Fungsi untuk menampilkan semua data pelanggan
    public function index() {
        $data['title'] = 'Daftar Pelanggan';
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();
        
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        // Ambil pesan alert dari session flashdata
        $data['alert'] = $this->session->flashdata('alert');
        
        $this->load->view('templates/header', $data);
        $this->load->view('backend/pelanggan/index', $data); // Menampilkan view dengan data pelanggan
        $this->load->view('templates/footer');
    }

    // Fungsi untuk menampilkan detail pelanggan berdasarkan ID
    public function detail($id) {
        $data['pelanggan'] = $this->PelangganModel->ambil_pelanggan_berdasarkan_id($id);
        $this->load->view('pelanggan/detail', $data); // Menampilkan view detail pelanggan
    }

    // Fungsi untuk menambahkan pelanggan baru
    public function tambah() {
        if ($this->input->post()) {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan'),
                'no_meter' => $this->input->post('no_meter'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tenggang' => $this->input->post('tenggang'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            $this->PelangganModel->tambah_pelanggan($data);
            $this->session->set_flashdata('alert', 'tambah_sukses'); // Set pesan alert
            redirect('PelangganController'); // Redirect ke halaman utama
        } else {
            $this->load->view('pelanggan/tambah'); // Menampilkan form tambah pelanggan
        }
    }

    // Fungsi untuk memperbarui data pelanggan
    public function perbarui($id) {
        if ($this->input->post()) {
            $data = array(
                'no_meter' => $this->input->post('no_meter'),
                'nama' => $this->input->post('nama'),
                'alamat' => $this->input->post('alamat'),
                'tenggang' => $this->input->post('tenggang'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            $this->PelangganModel->perbarui_pelanggan($id, $data);
            $this->session->set_flashdata('alert', 'update_sukses'); // Set pesan alert
            redirect('PelangganController'); // Redirect ke halaman utama
        } else {
            $data['pelanggan'] = $this->PelangganModel->ambil_pelanggan_berdasarkan_id($id);
            $this->load->view('pelanggan/perbarui', $data); // Menampilkan form perbarui pelanggan
        }
    }

    // Fungsi untuk menghapus pelanggan
    public function hapus($id) {
        $this->PelangganModel->hapus_pelanggan($id);
        $this->session->set_flashdata('alert', 'hapus_sukses'); // Set pesan alert
        redirect('PelangganController'); // Redirect ke halaman utama setelah dihapus
    }

    public function ajaxIndex() {
        header('Content-Type: application/json');

        if (ob_get_contents()) ob_end_clean();

        $data = $this->PelangganModel->get_pelanggan();

        $json_data = json_encode($data);
        log_message('debug', 'JSON Data: ' . $json_data);

        echo $json_data;
        exit(); 
    }
}
?>
