<?php include "Header.php" ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Menu Aktif</h1>
        <a>Lihat Detail Laporan Korban Anak-anak</a>
    </div>
    <!-- Content Row -->

    <div class="card shadow mb-4">
        <?php if (!empty($lihat)) { ?>
            <?php foreach ($lihat as $data) { //ngabsen data
        ?>
        <?php if ($data['status_laporan'] == 1) { ?>
            <div class="card border-left-success shadow h-100 py-2">
       <?php } else { ?>
            <div class="card border-left-danger shadow h-100 py-2">
        <?php } ?>
        <div class="card-body">
            <form action="#" id="form" class="form-horizontal">
                
                        <input class="form-control" type="hidden" value="<?php echo $data['id_korban'] ?>" name="id_korban" />
                        <!-- <div class="modal-body"> -->

                        <h5 style="font-weight:bold">Data Pelapor</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Pelapor</label>
                                    <input class="form-control" type="text" name="nama_pelapor" id="nama_pelapor" tabindex="1" value="<?php echo $data['nama_pelapor'] ?>" readonly>    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Umur Pelapor</label>
                                    <input class="form-control" type="text" name="umur_pelapor" id="umur_pelapor" tabindex="2" value="<?php echo $data['umur_pelapor']. " Tahun" ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Alamat Pelapor</label>
                                    <input class="form-control" type="text" name="alamat_pelapor" id="alamat_pelapor" tabindex="3" value="<?php echo $data['alamat_pelapor'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. HP Pelapor</label>
                                    <input class="form-control" type="text" name="nohp_pelapor" id="nohp_pelapor" tabindex="4" value="<?php echo $data['nohp_pelapor'] ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <h5 style="font-weight:bold">Data Korban</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Korban</label>
                                    <input class="form-control" type="text" name="nama_korban" id="nama_korban" tabindex="5" value="<?php echo $data['nama_korban'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Umur Korban</label>
                                    <input class="form-control" type="text" name="umur_korban" id="umur_korban" tabindex="6" value="<?php echo $data['umur_korban']. " Tahun" ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Alamat Korban</label>
                                    <input class="form-control" type="text" name="alamat_korban" id="alamat_korban" tabindex="7" value="<?php echo $data['alamat_korban'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. HP Korban</label>
                                    <input class="form-control" type="text" name="nohp_korban" id="nohp_korban" tabindex="8" value="<?php echo $data['nohp_korban'] ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <br>
                        <h5 style="font-weight:bold">Lain-lain</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keterangan Pengaduan</label>
                                    <input class="form-control" type="text" name="keterangan_pengaduan" id="keterangan_pengaduan" tabindex="9" value="<?php echo $data['keterangan'] ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status Pengaduan</label>
                                    <?php if ($data['status_laporan'] == 1) {
                                        $ket = "Selesai ditangani";
                                    } else {
                                        $ket = "Belum ditangani";
                                    }
                                    ?>
                                    <input class="form-control" type="text" name="status_pengaduan" id="status_pengaduan" tabindex="10" value="<?php echo $ket?>" readonly>
                                </div>
                            </div>
                        </div>
                <!-- </div> -->
                <a href="<?php echo base_url(); ?>superadmin/anak" class="btn btn-secondary" tabindex="20">Kembali</a>
            </form>
        </div>
        </div>
        <?php } ?>
        <?php } else { ?>
            <h5 style="color: red; text-align: center">Data tidak ditemukan</h5>
        <?php } ?>
    </div>


    <!-- Content Row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include "Footer.php" ?>

</body>

</html>