<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran Listrik PLN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 1.2em;
            color: #555;
        }
        .section-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            background-color: #fff;
        }
        .section label {
            font-weight: bold;
        }
        .section p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
            border-top: 2px solid #ddd;
            margin-top: 20px;
            padding-top: 10px;
        }

        /* CSS for printing */
        @media print {
            body {
                margin: 0;
                padding: 0;
                border: 1px;
                background-color: #fff;
                width: 210mm; /* A4 width */
                height: 297mm; /* A4 height */
                box-sizing: border-box;
            }
            .header, .section-container, .footer {
                width: 100%;
            }
            .section-container {
                padding: 20mm; /* Margins for printing */
            }
            .section {
                margin-bottom: 10mm; /* Spacing between sections */
            }
            @page {
                size: A4;
                margin: 20mm; /* Margins for A4 paper */
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/97/Logo_PLN.png/438px-Logo_PLN.png" alt="Logo PLN"> <!-- Placeholder for PLN logo -->
        <h2>PT PLN (Persero)</h2>
        <p>Jl. Jendral Sudirman Kav. 52-53, Jakarta</p>
        <p>Telp: 123-456-789</p>
    </div>
    
    <h1>Bukti Pembayaran Listrik</h1>

    <div class="section-container">
        <div class="section">
            <p><label>Kode Bayar:</label> <?php echo htmlspecialchars($pembayaran->id_tagihan); ?></p>
            <p><label>ID Penggunaan:</label> <?php echo htmlspecialchars($pembayaran->id_penggunaan); ?></p>
            <p><label>ID Petugas:</label> <?php echo htmlspecialchars($pembayaran->id_petugas); ?></p>
            <p><label>ID Pelanggan:</label> <?php echo htmlspecialchars($pembayaran->id_pelanggan); ?></p>
            <p><label>Nomor Meter:</label> <?php echo htmlspecialchars($pembayaran->no_meter); ?></p>
        </div>
        
        <div class="section">
            <p><label>Meter Awal:</label> <?php echo htmlspecialchars($pembayaran->meter_awal); ?></p>
            <p><label>Meter Akhir:</label> <?php echo htmlspecialchars($pembayaran->meter_akhir); ?></p>
            <p><label>Kode Tarif:</label> <?php echo htmlspecialchars($pembayaran->kode_tarif); ?></p>
            <p><label>Bulan:</label> <?php echo nama_bulan($pembayaran->bulan);?></p>
            <p><label>Tahun:</label> <?php echo htmlspecialchars($pembayaran->tahun); ?></p>
            <p><label>Nama Pelanggan:</label> <?php echo htmlspecialchars($pembayaran->nama_pelanggan); ?></p>
        </div>
    
        <div class="section">
            <p><label>Jumlah Meter:</label> <?php echo htmlspecialchars($pembayaran->jumlah_meter); ?> kWh</p>
            <p><label>Tarif Per kWh:</label> Rp <?php echo number_format($pembayaran->tarif_perkwh, 0, ',', '.'); ?></p>
            <p><label>Tagihan Listrik:</label> Rp <?php echo number_format($pembayaran->tagihan_listrik, 0, ',', '.'); ?></p>
            <p><label>Biaya Admin:</label> Rp <?php echo number_format($pembayaran->biaya_admin, 0, ',', '.'); ?></p>
            <p><label>Denda:</label> Rp <?php echo number_format($pembayaran->denda, 0, ',', '.'); ?></p>
            <p><label>Total Bayar:</label> Rp <?php echo number_format($pembayaran->total_bayar, 0, ',', '.'); ?></p>
        </div>

        <div class="section">
            <p><label>Jumlah Uang:</label> <?php echo nominal($pembayaran->jumlah_uang);?></p>
            <p><label>Uang Kembali:</label> <?php echo nominal($pembayaran->uang_kembali);?></p>
        </div>
    </div>
    
    <div class="footer">
        <p>Terima kasih atas pembayaran Anda. Bukti ini adalah konfirmasi resmi dari transaksi yang telah dilakukan.</p>
        <p>PT PLN (Persero) - Customer Service</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
