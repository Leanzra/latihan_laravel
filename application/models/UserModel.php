<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_petugas_list() {
        $query = $this->db->get('petugas'); 
        return $query->result_array(); 
    }

    public function lihat_petugas() {
        $this->db->where('akses', 'Petugas');
        $query = $this->db->get('petugas');
        return $query->result_array();
    }

    public function lihat_agen() {
        $this->db->where('akses', 'Agen');
        $query = $this->db->get('petugas');
        return $query->result_array();
    }

    public function tambah_petugas($data) {
        $this->db->insert('petugas', $data);
        return $this->db->insert_id();
    }

    public function update_petugas($id, $data) {
        $this->db->where('id_petugas', $id);
        $this->db->update('petugas', $data);
        return $this->db->affected_rows() > 0;
    }

    public function hapus_petugas($id) {
        $this->db->where('id_petugas', $id);
        $this->db->delete('petugas');
        return $this->db->affected_rows();
    }

    public function dapatkan_akun_petugas($username) {
        $query = $this->db->get_where('petugas', array('username' => $username));
        return $query->row_array();
    }

    public function ubah_profil($id, $data) {
        $this->db->where('id_petugas', $id);
        return $this->db->update('petugas', $data);
    }

    public function dapatkan_petugas_berdasarkan_id($id) {
        $query = $this->db->get_where('petugas', array('id_petugas' => $id));
        $petugas = $query->row_array();

        if (empty($petugas['foto_profil'])) {
            $petugas['foto_profil'] = 'assets/foto_profil/foto-default.png';
        } else {
            $petugas['foto_profil'] = 'assets/foto_profil/' . $petugas['foto_profil'];
        }

        return $petugas;
    }


    /*
    *
    *
    */
    // 
    public function ambil_jumlah_pelanggan() {
        return $this->db->count_all('pelanggan');
    }

    public function ambil_jumlah_tarif() {
        return $this->db->count_all('tarif');
    }

    public function ambil_jumlah_penggunaan() {
        return $this->db->count_all('penggunaan');
    }

    public function ambil_total_bayar() {
        // Menggunakan Query Builder untuk menjumlahkan kolom total_bayar
        $this->db->select_sum('total_bayar');
        $query = $this->db->get('pembayaran');
        $result = $query->row();
        return $result->total_bayar;
    }

    // Fungsi untuk menghitung total biaya_admin berdasarkan id_petugas
    public function hitung_total_pemasukan($id_petugas) {
        $this->db->select_sum('biaya_admin');
        $this->db->from('pembayaran');
        $this->db->where('id_petugas', $id_petugas);
        $query = $this->db->get();

        $result = $query->row_array();
        return $result['biaya_admin']; // Menggunakan nama kolom yang benar
    }
    
    public function jumlah_penggunaan_berdasarkan_id_petugas($id){
        $this->db->from('penggunaan');
        $this->db->where('id_petugas', $id); 
        $query = $this->db->get();
        return $query->num_rows();
    }    
}
?>
