<?php
session_start();
include './config/koneksi.php';
$sesi = $_SESSION["admin"];
if (!isset($sesi)) {
    header("location: index.php");
}
$no = 1;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Bengkel & Dealer Motor di Pemalang | Halaman Admin</title>
        <link rel="icon" href="../icons/logo.png"/>
        <link href="assets/css/bootstrap.css" rel="stylesheet"/>
        <link href="assets/css/style.css" type="text/css" rel="stylesheet"/>
        <link href="assets/css/custom-styles.css" type="text/css" rel="stylesheet"/>
        <link href="assets/js/jquery.min.js" rel="stylesheet"/>
        <link href="assets/js/jquery-1.10.2.js" rel="stylesheet"/>
    </head>
    <body>
        <div class="header">
            <h3 class="title style5">BENGKEL DEALER MOTOR PEMALANG</h3>
        </div>
        <div id="menu">
            <ul>
                <li><a href="beranda.php">Beranda</a></li>
                <li><a href="data_bengkel.php">Data Bengkel</a></li>
                <li><a href="data_dealer.php">Data Dealer</a></li>
                <li><a href="logoutdialog.php">Keluar</a></li>
            </ul>
        </div>
        <div class="container">
            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" align="center">
                                KELOLA DATA DEALER
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <div align="center">
                                        <button type="button" class="btn btn-primary" name="tambah" onclick="window.location.href = 'tambah_dealer.php'">Tambah</button>
                                    </div>
                                <div class="col-md-offset-9" style="margin-bottom: 10px">
                                    <form action="" method="post">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="input_cari" id="input_cari" maxlength="30" placeholder="Cari Berdasarkan Nama Dealer" />
                                            <span class="input-group-btn" style="padding-left: 5px">
                                                <input type="submit" class="btn-group btn-sm btn-primary" name="cari" value="Cari" />
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td align="center"><b>No.</b></td>
                                            <td align="center"><b>Kode</b></td>
                                            <td align="center"><b>Nama Dealer</b></td>
                                            <td align="center"><b>Merk</b></td>
                                            <td align="center"><b>Hari Buka</b></td>
                                            <td align="center"><b>Jam Buka</b></td>
                                            <td align="center"><b>Alamat</b></td>
                                            <td align="center"><b>No. Telp</b></td>
                                            <td align="center"><b>Kecamatan</b></td>
                                            <td align="center" colspan="3"><b>Pilihan</b></td>
                                        </tr>
                                    </thead>
                                    <?php
                                    $input_cari = @$_POST['input_cari'];
                                    $cari = @$_POST['cari'];
                                    if ($cari) {
                                        if ($input_cari != "") {
                                            $stmt = $db->prepare("select * from data_dealer where nmdealer LIKE '%$input_cari%' ORDER BY kddealer DESC");
                                        } else {
                                            $stmt = $db->prepare("select * from data_dealer ORDER BY kddealer DESC");
                                        }
                                    } else {
                                        $stmt = $db->prepare("select * from data_dealer ORDER BY kddealer DESC");
                                    }
                                    $stmt->execute();
                                    $cek = $stmt->rowCount();
                                    if ($cek < 1) {
                                        ?>
                                        <tr>
                                            <td align="center" colspan="10">Data tidak ditemukan</td>
                                        </tr>
                                        <?php
                                    } else {
                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td align="center"><?php echo $no++; ?></td>
                                                    <td align="center"><?php echo $row['kddealer'];?></td>
                                                    <td><?php echo $row['nmdealer']; ?></td>
                                                    <td><?php echo $row['merk']; ?></td>
                                                    <td><?php echo $row['haribuka']; ?></td>
                                                    <td><?php echo $row['jambuka']; ?></td>
                                                    <td><?php echo $row['alamat']; ?></td>
                                                    <td><?php echo $row['telepon']; ?></td>
                                                    <td><?php echo $row['kecamatan']; ?></td>
                                                    <td align="center"><button type="button" class="btn btn-primary" name='lihat_data' onclick='window.location.href = "lihatdata_dealer.php?kddealer=<?php echo $row['kddealer'] ?>"'>Lihat</button></td>
                                                    <td align="center"><button type="button" class="btn btn-success" name="edit" onclick='window.location.href = "ubahdata_dealer.php?kddealer=<?php echo $row['kddealer']?>"'>Edit</button></td>
                                                    <td align="center"><button type="button" class="btn btn-warning" name="hapus" onclick="konfirmasi('<?php echo $row["kddealer"]; ?>');">Hapus</a></button></td>
                                                </tr>
                                            </tbody>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                                <div align="center">
                                    <button type="button" class="btn btn-primary" name="tambah" onclick="window.location.href = 'tambah_dealer.php'">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <br />
        </div>
        <div class="clear"></div>
        <script>
            function konfirmasi(kddealer) {
                var jawab = confirm("Yakin data dealer akan dihapus ?");
                if (jawab) {
                    window.location = "hapusdealer.php?kddealer=" + kddealer;
                }
            }
        </script>
        <div id="footer">
            <marquee><p>&copy; Ripr Lutuk 2017 </p>
            </marquee>
        </div>
    </body>
</html>