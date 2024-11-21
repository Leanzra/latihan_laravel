<!-- Display flash messages -->
<?php if ($this->session->flashdata('success') || $this->session->flashdata('error')): ?>
    <div class="container-fluid">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $title; ?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered rohman-syah" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bayar</th>
                            <th>Nama Pelanggan</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th style="display: none;">Jumlah Meter</th>
                            <th style="display: none;">Tarif PerkWh</th>
                            <th>Tagihan Listrik</th>
                            <th style="display: none;">Status</th>
                            <th style="display: none;">ID Petugas</th>
                            <th style="display: none;">ID Penggunaan</th>
                            <th class="text-center"><i class="fas fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($pembayaran as $item): ?>
                        <?php if ($this->session->userdata('session_akses') == 'Agen' && $item->id_petugas != 
                        $this->session->userdata('session_id')) {continue;}?> 
                        
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item->id_tagihan; ?></td>
                                <td><?php echo $item->nama_pelanggan; ?></td>
                                <td><?php echo nama_bulan($item->bulan); ?></td>
                                <td><?php echo $item->tahun; ?></td>
                                <td style="display: none;"><?php echo $item->jumlah_meter; ?></td>
                                <td style="display: none;"><?php echo $item->tarif_perkwh; ?></td>
                                <td><?php echo nominal($item->jumlah_bayar); ?></td>
                                <td style="display: none;"><?php echo $item->status; ?></td>
                                <td style="display: none;"><?php echo $item->id_petugas; ?></td>
                                <td style="display: none;"><?php echo $item->id_penggunaan; ?></td>
                                <td class="text-center">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPembayaran<?php echo $item->id_tagihan; ?>">
                                        Bayar
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


<!-- Modal Pembayaran -->
<?php foreach ($pembayaran as $item): ?>
<div class="modal fade" id="modalPembayaran<?php echo $item->id_tagihan; ?>" tabindex="-1" role="dialog" aria-labelledby="modalPembayaranLabel<?php echo $item->id_tagihan; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPembayaranLabel<?php echo $item->id_tagihan; ?>">Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url('PembayaranController/bayar'); ?>" method="POST">
                    <input type="hidden" name="id_tagihan" value="<?php echo $item->id_tagihan; ?>">
                    <input type="hidden" name="id_penggunaan" value="<?php echo $item->id_penggunaan; ?>">
                    <input type="hidden" name="id_petugas" value="<?php echo $item->id_petugas; ?>">
                    <input type="hidden" name="id_pelanggan" value="<?php echo $item->id_pelanggan; ?>">
                    <input type="hidden" name="no_meter" value="<?php echo $item->no_meter; ?>">
                    <input type="hidden" name="meter_awal" value="<?php echo $item->meter_awal; ?>">
                    <input type="hidden" name="meter_akhir" value="<?php echo $item->meter_akhir; ?>">
                    <input type="hidden" name="kode_tarif" value="<?php echo $item->kode_tarif; ?>">
                    <input type="hidden" name="bulan" value="<?php echo $item->bulan; ?>">
                    <input type="hidden" name="tahun" value="<?php echo $item->tahun; ?>">
                    
                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input type="text" class="form-control" name="nama_pelanggan" value="<?php echo $item->nama_pelanggan; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Meter</label>
                        <input type="text" class="form-control" name="jumlah_meter" value="<?php echo $item->jumlah_meter; ?>">
                    </div>
                    <div class="form-group">
                        <label>Tarif PerkWh</label>
                        <input type="text" class="form-control" name="tarif_perkwh" value="<?php echo $item->tarif_perkwh; ?>">
                    </div>
                    <div class="form-group">
                        <label>Tagihan Listrik</label>
                        <input type="text" class="form-control" name="tagihan_listrik" value="<?php echo nominal($item->jumlah_bayar); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Biaya Admin</label>
                        <input type="text" class="form-control" name="biaya_admin" value="<?php echo nominal($item->biaya_admin); ?>" readonly>
                    </div>
                    <?php if (!is_null($item->denda) && $item->denda != 0): ?>
                        <div class="form-group">
                            <label>Denda</label>
                            <input type="text" class="form-control" name="denda" value="<?php echo nominal($item->denda); ?>" readonly>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Total Bayar</label>
                        <?php
                        // Menghitung total bayar
                        $total_bayar = $item->jumlah_bayar + $item->biaya_admin;
                        if (isset($item->denda) && $item->denda > 0) {
                            $total_bayar += $item->denda;
                        }
                        ?>
                        <input type="text" class="form-control" name="total_bayar" value="<?php echo nominal($total_bayar); ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label>Jumlah Uang</label>
                        <input type="text" class="form-control jumlah-uang" data-id="<?php echo $item->id_tagihan; ?>" placeholder="Masukan Jumlah uang" name="jumlah_uang">
                    </div>


                    <button type="submit" class="btn btn-success float-right">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<script>
    function formatRupiah(angka, prefix) {
        let number_string = angka.replace(/[^,\d]/g, '').toString();
        let split = number_string.split(',');
        let sisa = split[0].length % 3;
        let rupiah = split[0].substr(0, sisa);
        let ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix === undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
    }

    function formatNumber(angka) {
        return angka.replace(/[^0-9]/g, '');
    }

    document.addEventListener('keyup', function (e) {
        if (e.target.classList.contains('jumlah-uang')) {
            e.target.value = formatRupiah(e.target.value, '');
        }
    });

    // Menangani form submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            // Menghapus format Rupiah sebelum mengirim data
            const jumlahUangField = form.querySelector('input[name="jumlah_uang"]');
            jumlahUangField.value = formatNumber(jumlahUangField.value);
        });
    });
</script>
