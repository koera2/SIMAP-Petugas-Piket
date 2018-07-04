<?php  
    include '../../../config/koneksi.php';
    include '../../../library/fungsi.php';
    session_start();
    $aksi = new oop();
    date_default_timezone_set("Asia/Jakarta");
    if (empty($_SESSION['nip'])) {
        $aksi->redirect("../../../index.php");
    }

    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $today = date("Y-m-d");
    $kesiswaan = $aksi->caridata("tbl_pegawai WHERE hak_akses = 'kesiswaan'");

?>
<!DOCTYPE HTML>
<html>
<head>
    <title><?php echo  $nama; ?></title>
    <link rel="icon" href="../../../assets/images/defaultimage.png">
    <style type="text/css">
        html,body{
            margin:0;
            padding:0;
            height:100%;

            font-family: Arial;
        }
        #wrapper{
            /*background-color: gray;*/
            min-height:100%;
            position:relative;
        }
        #header{
            /*background-color: red;*/
            padding-top: 20px;
            padding-left:20px;
            /*padding:5px;*/
            height:100px;
        }
        #judul{
            text-align: center;
            font:12px Arial;
            font-weight: bolder;
        }

        #isi{
            /*background-color: green;*/
            padding-bottom:150px;
            padding-left:30px;
            margin-right:10px;
            font:12px Arial;
        }
        #footer{
            /*background-color: yellow;*/
            position:absolute;
            bottom:1px;
            padding-right: 100px;
            padding-left: 20px;
            width:100%;
            font-weight: bold;
            color:black;
            font:13px Arial;
          }
    </style>
</head>
<body onload="window.print()">
    <div id="wrapper">
        <!-- bagian header laporan -->
        <div id="header">
            <table>
                <tr>
                    <!-- <td><img src="../../../assets/images/logowk.png" alt="Logo" width="90px" height="90px"></td>
                    <td></td> -->
                    <td colspan="4" align="lef">
                        <h4 style="margin: 0;margin-left: 2px;"><strong>YAYASAN PRAWITAMA</strong></h4>
                        <h1 style="margin: 0;margin-left: 2px;"><strong>SMK WIKRAMA BOGOR</strong> </h1>
                        <h5 style="margin: 0;margin-left: 2px;">Jl. Raya Wangun Kel. Sindangsari Kec. Bogor Timur</h5>
                        <h5 style="margin: 0;margin-left: 2px;">Telp/Fax.(0251) 8242411, email : prohumasi@smkwikrama.net, website : www.smkwikrama.net</h5>
                    </td>
                </tr>
            </table>
        </div>
        <!-- end bagian header laporan -->
        <hr style="border: 2px solid black;">

        <!-- bagian judul laporan -->
        <div id="judul">
          <!--  <h4 style="margin-bottom: 10px;margin-top: 20px;"><strong>LAPORAN GRAFIK ALASAN SISWA TIDAK HADIR PERIODE <?php $aksi->tanggal_kapital($dari);echo " - ";$aksi->tanggal_kapital($sampai) ?></strong></h4> -->
        </div>
        <!-- end bagian judul laporan -->

        <!-- bagian isi laporan -->
        <div id="isi">
            <div id="container" style="width:65%;"></div>
             <div id="judul">
               <h4 style="margin-bottom: 10px;margin-top: 20px;"><strong>DATA ALASAN SISWA TIDAK HADIR PERIODE <?php $aksi->tanggal_kapital($dari);echo " - ";$aksi->tanggal_kapital($sampai) ?></strong></h4>
            </div>
            <div id="judul">&nbsp;&nbsp;&nbsp;</div>

            <table width="100%" align="center" border="1" cellspacing="0" cellpadding="3" >
                <thead>
                    <tr>
                        <th width="10%"><center>No.</center></th>
                        <th><center>Alasan</center></th>
                        <th width="20%"><center>Jumlah</center></th>
                        <th width="20%"><center>Presentase</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $r = $aksi->sumdata("SUM(hadir) as hadir,SUM(sakit) as sakit,SUM(izin) as izin,SUM(tugas) as tugas,SUM(alpa) as alpa","tbl_absensi_siswa WHERE hadir != '1' AND tgl_absen BETWEEN '$dari' AND '$sampai'");  
                        $total = $aksi->cekdata("tbl_absensi_siswa WHERE hadir != '1' AND tgl_absen BETWEEN '$dari' AND '$sampai'");
                        if (empty($r['sakit']) AND empty($r['izin']) AND empty($r['tugas']) AND empty($r['alpa']) ) { 
                            echo "<tr><td></td><td></td><td align='center'>Data Tidak Ada</td><td></td></tr>";
                        }else{ 
                            ?>
                            <tr>
                                <td align="center">1.</td>
                                <td align="center">Sakit</td>
                                <td align="center"><?php echo $r['sakit']; ?></td>
                                <td align="center"><?php echo round(($r['sakit']*100)/$total,2); ?>%</td>
                            </tr>
                            <tr>
                                <td align="center">2.</td>
                                <td align="center">Izin</td>
                                <td align="center"><?php echo $r['izin']; ?></td>
                                <td align="center"><?php echo round(($r['izin']*100)/$total,2); ?>%</td>
                            </tr>
                            <tr>
                                <td align="center">3.</td>
                                <td align="center">Tugas</td>
                                <td align="center"><?php echo $r['tugas']; ?></td>
                                <td align="center"><?php echo round(($r['tugas']*100)/$total,2); ?>%</td>
                            </tr>
                            <tr>
                                <td align="center">4.</td>
                                <td align="center">Alpa</td>
                                <td align="center"><?php echo $r['alpa']; ?></td>
                                <td align="center"><?php echo round(($r['alpa']*100)/$total,2); ?>%</td>
                            </tr>
                        <?php }?>
                </tbody>
            </table>
        </div>
        <!-- end bagian isi laporan -->

        <!-- bagian tanda tangan -->
        <div id="footer">
            <!-- tanda tangan kiri -->
           <!--  <table align="left" style="margin-left: 10px;">
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left">Mengetahui</td>
                </tr>
                <tr>
                    <td align="left">Wakasek Kesiswaan,</td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left"><?php echo $kesiswaan['nama']; ?></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
            </table> -->
            <!-- end tanda tangan kiri -->

            <!-- tanda tangan kanan -->
            <!-- <table align="right" style="margin-right: 40px;">
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left">Bogor, <?php $aksi->hari(date("N"));echo " ";$aksi->format_tanggal(date("Y-m-d")) ?></td>
                </tr>
                <tr>
                    <td align="left">Petugas Piket,</td>
                </tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr>
                    <td align="left"><?php echo $_SESSION['nama']; ?></td>
                </tr>
                <tr><td>&nbsp;</td></tr>
            </table> -->
            <!-- end tanda tangan kanan -->
        </div>
        <!-- end bagian tanda tangan -->
    </div>

<script src="../../../assets/plugins/highchart/code/highcharts.js"></script>
<script src="../../../assets/plugins/highchart/code/modules/exporting.js"></script>
<script type="text/javascript">
    Highcharts.theme = {
        colors: ['#dd4b39', '#337ab7', '#00c0ef', '#00a65a', '#f39c12', '#86E2D5', 
                 '#22313F', '#95A5A6', '#947CB0','#E9D460'],
        title: {
            style: {
                color: '#000',
                font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
            }
        },
        subtitle: {
            style: {
                color: '#666666',
                font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
            }
        },

        legend: {
            itemStyle: {
                font: '9pt Trebuchet MS, Verdana, sans-serif',
                color: 'black'
            },
            itemHoverStyle:{
                color: 'gray'
            }   
        }
    };

    Highcharts.setOptions(Highcharts.theme);

     Highcharts.chart('container', {
                chart: {
                    type: 'column',
                    spacing : [20,15,20,15],
                },
                title: {
                    text: 'Grafik Alasan Siswa Tidak Hadir'
                },
                subtitle: {
                    text: 'Periode <?php $aksi->format_tanggal($dari);echo " - ";$aksi->format_tanggal($sampai); ?>'
                },
                xAxis: {
                    type: 'category',
                    
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Jumlah'
                    }
                },
                legend: {
                    enabled: true
                },
                tooltip: {
                    pointFormat: 'Jumlah Tidak Hadir Periode <?php $aksi->format_tanggal($dari);echo " -  ";$aksi->format_tanggal($sampai); ?>: <b>{point.y:1f} Kali</b>'
                },
                series: [
                    <?php  
                        $no = 0;
                        $table = "tbl_absensi_siswa";
                        $where = "WHERE tgl_absen BETWEEN '$dari' AND '$sampai'";
                        $sum = "semester,MONTH(tgl_absen) as bulan,YEAR(tgl_absen) as tahun,SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
                        $data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY bulan,semester");
                        $total = $aksi->cekdata("tbl_izin_siswa WHERE tgl_izin BETWEEN '$dari' AND '$sampai'");
                        if (empty($data)) {
                            echo "<script>alert('Data Tidak Ada')</script>";
                        }else{
                            foreach ($data as $r) {
                                $bulan = $r['bulan'];
                                $tahun = $r['tahun'];

                                $whr = "WHERE hadir != '1' AND MONTH(tgl_absen) = '$bulan' AND YEAR(tgl_absen) = '$tahun' AND semester = '$r[semester]'";
                                $dat = "SUM(hadir) as jumlah_hadir,SUM(sakit) as jumlah_sakit,SUM(izin) as jumlah_izin,SUM(alpa) as jumlah_alpa,SUM(tugas) as jumlah_tugas";
                                $detail = $aksi->tampil_sum($dat,$table,$whr,"");
                                foreach ($detail as $c) {
                                   $sakit = $c['jumlah_sakit'];
                                   $izin = $c['jumlah_izin'];
                                   $tugas = $c['jumlah_tugas'];
                                   $alpa = $c['jumlah_alpa'];
                                }
                    ?>
                {
                    name: '<?php $aksi->bulan($bulan);echo " ".$tahun; ?>',
                    data: [ 
                            ['Sakit', <?php echo $sakit; ?>],
                            ['Izin', <?php echo $izin; ?>],
                            ['Tugas', <?php echo $tugas; ?>],
                            ['Alpa', <?php echo $alpa; ?>]
                          ],
                    pointWidth: 20,
                    dataLabels: {
                        enabled: true,
                        color: '#22313F',
                        align: 'center',
                        format: '{point.y:1f}', // one decimal
                        y: 1, // 10 pixels down from the top
                        style: {
                            fontSize: '20px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
            <?php } } ?>
            ] });
</script>

</body>
</html>
