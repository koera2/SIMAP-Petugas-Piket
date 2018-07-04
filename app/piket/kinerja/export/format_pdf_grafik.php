<?php  
    include '../../../config/koneksi.php';
    include '../../../library/fungsi.php';
    session_start();
    $aksi = new oop();
    date_default_timezone_set("Asia/Jakarta");
    if (empty($_SESSION['nip'])) {
        $aksi->redirect("../../../index.php");
        // $aksi->redirect("index.php");
    }

    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $today = date("Y-m-d");
    $kesiswaan = $aksi->caridata("tbl_pegawai WHERE hak_akses = 'kesiswaan'");
    $nama = "Laporan Alasan Siswa Melanggar Periode ".$dari." sampai ".$sampai.".pdf";

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
            /*padding-bottom:150px;*/
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
                    <td><img src="../../../assets/images/logowk.png" alt="Logo" width="90px" height="90px"></td>
                    <td></td>
                    <td>
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
       <!--  <div id="judul">
           <h4 style="margin-bottom: 10px;margin-top: 20px;"><strong>LAPORAN GRAFIK ALASAN SISWA MELANGGAR PERIODE <?php $aksi->tanggal_kapital($dari);echo " - ";$aksi->tanggal_kapital($sampai) ?></strong></h4>
        </div> -->
        <!-- end bagian judul laporan -->

        <!-- bagian isi laporan -->
        <div id="isi">
            <div id="container" style="width:65%;"></div>
             <div id="judul">
               <h4 style="margin-bottom: 10px;margin-top: 20px;"><strong>DATA ALASAN SISWA MELANGGAR PERIODE <?php $aksi->tanggal_kapital($dari);echo " - ";$aksi->tanggal_kapital($sampai) ?></strong></h4>
            </div>
            <table width="90%" align="center" border="1" cellspacing="0" cellpadding="3">
                <thead>
                    <tr>
                        <th width="6%">No.</th>
                        <th width="15%">Kode Kinerja</th>
                        <th>Nama Kinerja</th>
                        <th width="15%"><center>Jumlah</center></th>
                        <th width="15%"><center>Presentase</center></th>
                    </tr>
                </thead>
                <tbody>
                    <?php  
                        $no = 0;
                        $table = "tbl_kinerja_siswa";
                        $where = "WHERE kelompok_kinerja = 'PUNISHMENT' AND tgl_kejadian BETWEEN '$dari' AND '$sampai'";
                        $sum = "kode_kinerja,COUNT(kode_kinerja) as jml_kode";
                        $data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY kode_kinerja");
                        $total = $aksi->cekdata("tbl_kinerja_siswa WHERE kelompok_kinerja = 'PUNISHMENT' AND tgl_kejadian BETWEEN '$dari' AND '$sampai'");
                        if (empty($data)) {
                            echo "<tr><td></td><td></td><td align='center'>Data Tidak Ada</td><td></td><td></td></tr>";
                        }else{
                            foreach ($data as $r) {
                                $no++;
                                $kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$r[kode_kinerja]'");
                        ?>

                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['kode_kinerja']; ?></td>
                                <td><?php echo $kinerja['nama_kinerja']; ?></td>
                                <td align="center"><?php echo $r['jml_kode']; ?></td>
                                <td align="center"><?php echo round(($r['jml_kode']*100)/$total,2); ?>%</td>
                            </tr>
                    <?php   } } ?>
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
                    text: 'Grafik Alasan Siswa Melanggar'
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
                        text: 'Jumlah Pelanggaran'
                    }
                },
                plotOptions: {
                    series: {
                        animation: false
                    }
                },
                legend: {
                    enabled: true
                },
                tooltip: {
                    pointFormat: 'Jumlah Pelanggaran Periode <?php $aksi->format_tanggal($dari);echo " -  ";$aksi->format_tanggal($sampai); ?>: <b>{point.y:1f} Pelanggaran</b>'
                },
                series: [
                    <?php  
                        $no = 0;
                        $table = "tbl_kinerja_siswa";
                        $where = "WHERE kelompok_kinerja = 'PUNISHMENT' AND tgl_kejadian BETWEEN '$dari' AND '$sampai'";
                        $sum = "kode_kinerja,COUNT(kode_kinerja) as jml_kode";
                        $data = $aksi->tampil_sum($sum,$table,$where,"GROUP BY kode_kinerja");
                        $total = $aksi->cekdata("tbl_kinerja_siswa WHERE kelompok_kinerja = 'PUNISHMENT' AND tgl_kejadian BETWEEN '$dari' AND '$sampai'");
                        if (empty($data)) {
                            echo "<script>alert('Data Tidak Ada')</script>";
                        }else{
                            foreach ($data as $r) {
                                $kinerja = $aksi->caridata("tbl_poin_kinerja WHERE kode_kinerja = '$r[kode_kinerja]'");
                                $nama_kinerja = $kinerja['nama_kinerja'];
                                $jumlah = $r['jml_kode'];
                                $kode_kinerja = $r['kode_kinerja'];
                    ?>
                {
                    name: '<?php echo "(".$kode_kinerja.") ".$nama_kinerja; ?>',
                    data: [ 
                            ['<?php echo $kode_kinerja; ?>', <?php echo $jumlah; ?>]
                          ],
                    pointWidth: 50,
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
                ]
            });
</script>

</body>
</html>
