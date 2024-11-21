<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PembayaranController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->model('PenggunaanModel'); 
        $this->load->model('PelangganModel'); 
        $this->load->model('TarifModel');  
        $this->load->model('TagihanModel');
        $this->load->model('PembayaranModel');
        
        // Cek apakah pengguna sudah login
        if (!$this->session->has_userdata('session_id')) {
            $this->session->set_flashdata('alert', 'belum_login');
            redirect('login'); // Gunakan URL relatif
        }
    }

    // Fungsi untuk menampilkan semua data tagihan
    public function index() {
        $data['title'] = 'Pembayaran Tagihan';
        $data['pembayaran'] = $this->PembayaranModel->ambil_tagihan_belum_bayar();
        $data['tagihan'] = $this->TagihanModel->ambil_semua_tagihan();
        $data['penggunaan'] = $this->PenggunaanModel->ambil_semua_penggunaan();
        $data['pelanggan'] = $this->PelangganModel->ambil_semua_pelanggan();
        $data['tarif'] = $this->TarifModel->lihat_tarif();

        // Mendapatkan ID petugas dari sesi
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/pembayaran/index', $data); // Menampilkan view dengan data tagihan
        $this->load->view('templates/footer');
    }

    // Halaman Riwayat Pembayaran
    public function riwayat_pembayaran() {
        $data['title'] = 'Riwayat Pembayaran';
        $data['pembayaran'] = $this->PembayaranModel->ambil_semua_pembayaran();

        // Mendapatkan ID petugas dari sesi
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        $this->load->view('templates/header', $data);
        $this->load->view('backend/pembayaran/riwayat_pembayaran', $data); // Menampilkan view dengan data tagihan
        $this->load->view('templates/footer');
    }

    public function bayar() {
        // Mendapatkan data dari POST
        $id_tagihan = $this->input->post('id_tagihan');
        $id_penggunaan = $this->input->post('id_penggunaan');
        $id_petugas = $this->input->post('id_petugas');
        $id_pelanggan = $this->input->post('id_pelanggan');
        $no_meter = $this->input->post('no_meter');
        $meter_awal = $this->input->post('meter_awal');
        $meter_akhir = $this->input->post('meter_akhir');
        $kode_tarif = $this->input->post('kode_tarif');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $nama_pelanggan = $this->input->post('nama_pelanggan');
        $jumlah_meter = $this->input->post('jumlah_meter');

        // Mendapatkan dan membersihkan data mata uang dari POST
        $tarif_perkwh = $this->sanitize_currency($this->input->post('tarif_perkwh'));
        $tagihan_listrik = $this->sanitize_currency($this->input->post('tagihan_listrik'));
        $biaya_admin = $this->sanitize_currency($this->input->post('biaya_admin'));
        $denda = $this->sanitize_currency($this->input->post('denda'));
        $total_bayar = $this->sanitize_currency($this->input->post('total_bayar'));
        $jumlah_uang = $this->sanitize_currency($this->input->post('jumlah_uang'));

        // Hitung uang kembali
        $uang_kembali = $this->hitungan_uang_kembali($jumlah_uang, $total_bayar);

        // Cek apakah jumlah uang mencukupi total bayar
        if ($jumlah_uang < $total_bayar) {
            // Set flashdata error
            $this->session->set_flashdata('error', 'Jumlah uang tidak mencukupi total bayar.');
            // Redirect kembali ke halaman sebelumnya
            redirect('pembayaran'); // Gunakan URL relatif
            return;
        }

        // Jika jumlah uang mencukupi total bayar, ubah status tagihan menjadi 'lunas'
        $this->PembayaranModel->ubah_status_tagihan($id_tagihan, 'Sudah Terbayar');

        // Simpan data pembayaran ke tabel pembayaran
        $data_pembayaran = array(
            'id_tagihan' => $id_tagihan,
            'id_penggunaan' => $id_penggunaan,
            'id_petugas' => $id_petugas,
            'id_pelanggan' => $id_pelanggan,
            'no_meter' => $no_meter,
            'meter_awal' => $meter_awal,
            'meter_akhir' => $meter_akhir,
            'kode_tarif' => $kode_tarif,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'nama_pelanggan' => $nama_pelanggan,
            'jumlah_meter' => $jumlah_meter,
            'tarif_perkwh' => $tarif_perkwh,
            'tagihan_listrik' => $tagihan_listrik,
            'biaya_admin' => $biaya_admin,
            'denda' => $denda,
            'total_bayar' => $total_bayar,
            'jumlah_uang' => $jumlah_uang,
            'uang_kembali' => $uang_kembali
        );

        $this->PembayaranModel->simpan_pembayaran($data_pembayaran);

        $this->session->set_flashdata('success', 'Pembayaran berhasil.');

        // Redirect ke halaman bukti bayar
        redirect('PembayaranController/bukti_bayar/' . $id_tagihan);
    }

        // Redirect kembali ke halaman sebelumnya
        // redirect('pembayaran'); // Gunakan URL relatif

        // Redirect ke tampilan struk pembayaran
        /*$data['id_tagihan'] = $id_tagihan;
        $data['nama_pelanggan'] = $nama_pelanggan;
        $data['no_meter'] = $no_meter;
        $data['meter_awal'] = $meter_awal;
        $data['meter_akhir'] = $meter_akhir;
        $data['tarif_perkwh'] = $tarif_perkwh;
        $data['tagihan_listrik'] = $tagihan_listrik;
        $data['biaya_admin'] = $biaya_admin;
        $data['denda'] = $denda;
        $data['total_bayar'] = $total_bayar;
        $data['jumlah_uang'] = $jumlah_uang;
        $data['uang_kembali'] = $uang_kembali;
        
        $this->load->view('backend/pembayaran/struk_pembayaran', $data);*/


    // Fungsi untuk membersihkan format mata uang
    private function sanitize_currency($currency) {
        // Hapus "Rp", titik dan koma
        return (int) preg_replace('/[^0-9]/', '', $currency);
    }

    // Fungsi untuk menghitung uang kembali
    private function hitungan_uang_kembali($jumlah_uang, $total_bayar) {
        return $jumlah_uang - $total_bayar;
    }


    public function bukti_bayar($id_tagihan) {
        
        // Mendapatkan ID petugas dari sesi
        $id = $this->session->userdata('session_id');
        $data['cek_login'] = $this->UserModel->dapatkan_petugas_berdasarkan_id($id);

        // Ambil data pembayaran berdasarkan ID tagihan
        $data['pembayaran'] = $this->PembayaranModel->get_pembayaran_by_id($id_tagihan);
        
        // Pastikan data ada
        if (!$data['pembayaran']) {
            show_404(); // Menampilkan halaman 404 jika tidak ditemukan
        }
        
        // Load view bukti bayar dengan data
        $this->load->view('backend/pembayaran/bukti_bayar', $data);
    }



}
