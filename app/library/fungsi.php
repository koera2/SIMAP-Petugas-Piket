<?php  
	class oop{

		function simpan($table, array $field){
			$sql = "INSERT INTO $table SET ";
			foreach ($field as $key => $value) {
				$sql .=" $key = '$value',";
			}
			$sql = rtrim($sql, ',');
			$jalan = mysql_query($sql);
		}

		function tampil($table,$cari,$urut){
			$sql = mysql_query("SELECT * FROM $table $cari $urut");
			while ($data = mysql_fetch_array($sql))
				$isi[] = $data;
			return @$isi;
		}

		function tampil_sum($sum,$table,$cari,$urut){
			$sql = mysql_query("SELECT $sum FROM $table $cari $urut");
			while ($data = mysql_fetch_array($sql))
				$isi[] = $data;
			return @$isi;
		}

		function edit($table,$where){
			$sql = mysql_query("SELECT * FROM $table WHERE $where");
			$jalan = mysql_fetch_array($sql);
			return $jalan;
		}

		function hapus($table,$where){
			$sql = mysql_query("DELETE FROM $table WHERE $where");
			return $sql;
		}

		function update($table,array $field,$where){
			$sql = "UPDATE $table SET ";
			foreach ($field as $key => $value) {
				$sql.="$key = '$value',";
			}
			$sql=rtrim($sql,',');
			$sql .=" WHERE $where";
			$jalan = mysql_query($sql);
		}


		function pesan($pesan){
			echo "<script>alert('$pesan')</script>";
		}

		function redirect($alamat){
			echo "<script>document.location.href='$alamat'</script>";
		}

		function alert($pesan,$alamat){
			echo "<script>alert('$pesan');document.location.href='$alamat'</script>";
		}

		function no_record($col){
			echo "<tr><td colspan='$col'><center>Data Tidak Ada !!!</center></td></tr>";
		}

		function rupiah($uang){
			echo "Rp. ".number_format($uang, 0,',','.')."-,";
		}

		function caridata($table){
			$sql = mysql_fetch_array(mysql_query("SELECT * FROM $table"));
			return $sql;
		}

		function sumdata($sum,$table){
			$sql = mysql_fetch_array(mysql_query("SELECT $sum FROM $table"));
			return $sql;
		}

		function cekdata($table){
			$sql = mysql_num_rows(mysql_query("SELECT * FROM $table"));
			return $sql;
		}

		function bulan($bulan){
			switch ($bulan) {
				case '01': $bln = "Januari"; break;
				case '02': $bln = "Februari"; break;
				case '03': $bln = "Maret"; break;
				case '04': $bln = "April"; break;
				case '05': $bln = "Mei"; break;
				case '06': $bln = "Juni"; break;
				case '07': $bln = "Juli"; break;
				case '08': $bln = "Agustus"; break;
				case '09': $bln = "September"; break;
				case '10': $bln = "Oktober"; break;
				case '11': $bln = "November"; break;
				case '12': $bln = "Desember"; break;
				default: $bln="";break;
			}
			echo $bln;
		}

		function hari($today){
			switch ($today) {
				case '1': $hari = "Senin"; break;
				case '2': $hari = "Selasa"; break;
				case '3': $hari = "Rabu"; break;
				case '4': $hari = "Kamis"; break;
				case '5': $hari = "Jumat"; break;
				case '6': $hari = "Sabtu"; break;
				case '7': $hari = "Minggu"; break;
				default: $hari="";break;
			}
			echo $hari;
		}

		function bulan_kapital($bulan){
			switch ($bulan) {
				case '01': $bln = "JANUARI"; break;
				case '02': $bln = "FEBRUARI"; break;
				case '03': $bln = "MARET"; break;
				case '04': $bln = "APRIL"; break;
				case '05': $bln = "MEI"; break;
				case '06': $bln = "JUNI"; break;
				case '07': $bln = "JULI"; break;
				case '08': $bln = "AGUSTUS"; break;
				case '09': $bln = "SEPTEMBER"; break;
				case '10': $bln = "OKTOBER"; break;
				case '11': $bln = "NOVEMBER"; break;
				case '12': $bln = "DESEMBER"; break;
				default: $bln="";break;
			}
			echo $bln;
		}

		function format_tanggal($tanggal){
			$thn = substr($tanggal, 0,4);
			$bulan = substr($tanggal, 5,2);
			$tgl = substr($tanggal, 8,2);
			switch ($bulan) {
				case '01': $bln = "Januari"; break;
				case '02': $bln = "Februari"; break;
				case '03': $bln = "Maret"; break;
				case '04': $bln = "April"; break;
				case '05': $bln = "Mei"; break;
				case '06': $bln = "Juni"; break;
				case '07': $bln = "Juli"; break;
				case '08': $bln = "Agustus"; break;
				case '09': $bln = "September"; break;
				case '10': $bln = "Oktober"; break;
				case '11': $bln = "November"; break;
				case '12': $bln = "Desember"; break;
				default: $bln="";break;
			}
			echo $tgl." ".$bln." ".$thn;
		}

		function tanggal_kapital($tanggal){
			$thn = substr($tanggal, 0,4);
			$bulan = substr($tanggal, 5,2);
			$tgl = substr($tanggal, 8,2);
			switch ($bulan) {
				case '01': $bln = "JANUARI"; break;
				case '02': $bln = "FEBRUARI"; break;
				case '03': $bln = "MARET"; break;
				case '04': $bln = "APRIL"; break;
				case '05': $bln = "MEI"; break;
				case '06': $bln = "JUNI"; break;
				case '07': $bln = "JULI"; break;
				case '08': $bln = "AGUSTUS"; break;
				case '09': $bln = "SEPTEMBER"; break;
				case '10': $bln = "OKTOBER"; break;
				case '11': $bln = "NOVEMBER"; break;
				case '12': $bln = "DESEMBER"; break;
				default: $bln="";break;
			}
			echo $tgl." ".$bln." ".$thn;
		}

		function upload($tempat){
			@$alamatfile = $_FILES['foto']['tmp_name'];
			@$namafile = $_FILES['foto']['name'];
			move_uploaded_file($alamatfile, "$tempat/$namafile");
			return $namafile;
		}

	}
?>