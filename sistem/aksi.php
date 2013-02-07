<?php
/* aksi.php ------------------------------------------------------
   	version: 1.0.2

	Part of AhadPOS : http://AhadPOS.com
	License: GPL v2
			http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
			http://vlsm.org/etc/gpl-unofficial.id.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License v2 (links provided above) for more details.
----------------------------------------------------------------*/

session_start();
include "../config/config.php";
include "../config/library.php";
include "modul/function.php";

$module=$_GET[module];
$act=$_GET[act];


// Input Kas Awal
if ($module=='transaksi_kas' AND $act=='input'){
  $tglHariIni = date("Y-m-d");
//  echo "$_POST[idUser]";
  mysql_query("INSERT INTO transaksikas(tglTransaksiKas,idUser,kasAwal)
        VALUES('$tglHariIni','$_POST[idUser]','$_POST[kasAwal]')");
  header('location:media.php?module=home');
}

// Input user
elseif ($module=='user' AND $act=='input'){
  $pass=md5($_POST[pass]);
  $ambilID = mysql_query("select max(idUser)+1 from user");
	$ID = mysql_fetch_array($ambilID);
	$id_user;
	if($ID[0]=='')
		$id_user = '1';
	else
		$id_user = $ID[0];
  mysql_query("INSERT INTO user(idUser,
                                namaUser,
                                idLevelUser,
                                uname,
                                pass)
	                       VALUES('$id_user',
                                '$_POST[namaUser]',
                                '$_POST[levelUser]',
                                '$_POST[uname]',
                                '$pass')");
  header('location:media.php?module='.$module);
}//end input user

// Update user
elseif ($module=='user' AND $act=='update'){
  // Apabila password tidak diubah
  if (empty($_POST[pass])) {
    mysql_query("UPDATE user SET namaUser       = '$_POST[namaUser]',
                                 idLevelUser    = '$_POST[levelUser]',
                                 uname          = '$_POST[uname]'
                           WHERE idUser         = '$_POST[idUser]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[pass]);
    mysql_query("UPDATE user SET namaUser       = '$_POST[namaUser]',
                                 idLevelUser    = '$_POST[levelUser]',
                                 uname          = '$_POST[uname]',
                                 pass           = '$pass'
                           WHERE idUser         = '$_POST[idUser]'");
  }

  if ($_GET[home]) {
		header('location:media.php?module=home');
	} else {
		header('location:media.php?module='.$module);
	};

}// end update user

// Hapus User
elseif ($module=='user' AND $act=='hapus'){
  mysql_query("DELETE FROM user WHERE idUser = '$_GET[id]'");
  header('location:media.php?module='.$module);
} // end hapus user



// Input modul ==========================================================
elseif ($module=='modul' AND $act=='input'){
    $ambilID = mysql_query("select max(idModul)+1 from modul");
	$ID = mysql_fetch_array($ambilID);
	$id_modul;
	if($ID[0]=='')
		$id_modul = '1';
	else
		$id_modul = $ID[0];
    $ambilUrut = mysql_query("select max(urutan)+1 from modul where urutan < 100");
	$u = mysql_fetch_array($ambilUrut);
	$urut;
	if($u[0]=='')
		$urut = '1';
	else
		$urut = $u[0];
  mysql_query("INSERT INTO modul(idModul,
                                 namaModul,
                                 link,
                                 publish,
                                 idLevelUser,
                                 urutan)
	                       VALUES('$id_modul',
                                '$_POST[namaModul]',
                                '$_POST[link]',
                                '$_POST[publish]',
                                '$_POST[levelUser]',
                                '$urut')");
  header('location:media.php?module='.$module);
}// end input modul

// Update modul
elseif ($module=='modul' AND $act=='update'){
  mysql_query("UPDATE modul SET namaModul = '$_POST[namaModul]',
                                link       = '$_POST[link]',
                                publish    = '$_POST[publish]',
                                idLevelUser= '$_POST[levelUser]'
                          WHERE idModul   = '$_POST[idModul]'");
  header('location:media.php?module='.$module);
}// end update modul

// Hapus Modul
elseif ($module=='modul' AND $act=='hapus'){
  mysql_query("DELETE FROM modul WHERE idModul = '$_GET[id]'");
  header('location:media.php?module='.$module);
} // end hapus modul



// Workstation Management ============================================================================================================

elseif ($module=='workstation' AND $act=='input'){
 mysql_query("INSERT INTO workstation (namaWorkstation, keterangan, workstation_address, printer_type, printer_commands) 
		VALUES ('$_POST[namaWorkstation]', '$_POST[keterangan]','$_POST[workstation_address]','$_POST[printer_type]','$_POST[printer_commands]') 
	");

  header('location:media.php?module='.$module);
}

elseif ($module=='workstation' AND $act=='update'){
  mysql_query("UPDATE workstation SET namaWorkstation 		= '$_POST[namaWorkstation]',
					keterangan		= '$_POST[keterangan]',
					workstation_address 	= '$_POST[workstation_address]',
					printer_type		= '$_POST[printer_type]',
					printer_commands	= '$_POST[printer_commands]' 
		WHERE idWorkstation = '$_POST[idWorkstation]' 	
	");
  header('location:media.php?module='.$module);
}

elseif ($module=='workstation' AND $act=='hapus'){
  mysql_query("DELETE FROM workstation 	WHERE idWorkstation = '$_POST[idWorkstation]'");
  header('location:media.php?module='.$module);
}




// Input Satuan Barang
elseif ($module=='satuan_barang' AND $act=='input'){ // ==============================================================================
    $ambilID = mysql_query("select max(idSatuanBarang)+1 from satuan_barang");
	$ID = mysql_fetch_array($ambilID);
	$id_satuan;
	if($ID[0]=='')
		$id_satuan = '1';
	else
		$id_satuan = $ID[0];
    mysql_query("INSERT INTO satuan_barang(idSatuanBarang,namaSatuanBarang)
                    VALUES('$id_satuan','$_POST[namaSatuanBarang]')");
    header('location:media.php?module='.$module);
}// end Input Satuan Barang

// Update Satuan Barang
elseif ($module=='satuan_barang' AND $act=='update'){
    mysql_query("UPDATE satuan_barang SET namaSatuanBarang = '$_POST[namaSatuanBarang]'
                    WHERE idSatuanBarang = '$_POST[idSatuanBarang]'");
    header('location:media.php?module='.$module);
}// end Update Satuan Barang

// Hapus Satuan Barang
elseif ($module=='satuan_barang' AND $act=='hapus'){
	$sql = "DELETE FROM satuan_barang WHERE idSatuanBarang = '$_GET[id]'";
	mysql_query($sql) or die(mysql_error());
    	header('location:media.php?module='.$module);
}// end Hapus Satuan Barang



// Input Kategori Barang ==============================================================================================
elseif ($module=='kategori_barang' AND $act=='input'){
    $ambilID = mysql_query("SELECT max(idKategoriBarang)+1 FROM kategori_barang");
	$ID = mysql_fetch_array($ambilID);
	$id_rak;
	if($ID[0]=='')
		$id_rak = '1';
	else
		$id_rak = $ID[0];
    mysql_query("INSERT INTO kategori_barang(idKategoriBarang,namaKategoriBarang)
                    VALUES('$id_rak','$_POST[namaKategoriBarang]')");
    header('location:media.php?module='.$module);
}// end Input Kategori Barang

// Update Kategori Barang, bugfix credit to: Yono Nox <weyouknow@yahoo.com> 
elseif ($module=='kategori_barang' AND $act=='update'){
    mysql_query("UPDATE kategori_barang SET namaKategoriBarang = '$_POST[namaKategoriBarang]'
                    WHERE idKategoriBarang = '$_POST[idKategoriBarang]'");
    header('location:media.php?module='.$module);
}// end Update Kategori Barang

// Hapus Kategori Barang, credit: mianova.net@gmail.com
elseif ($module=='kategori_barang' AND $act=='hapus'){
    mysql_query("DELETE FROM kategori_barang  
                    WHERE idKategoriBarang = '$_GET[id]'");
    header('location:media.php?module='.$module);
}// end Hapus Kategori Barang



// Input Rak =============================================================
elseif ($module=='rak' AND $act=='input'){
    $ambilID = mysql_query("select max(idRak)+1 from rak");
	$ID = mysql_fetch_array($ambilID);
	$id_rak;
	if($ID[0]=='')
		$id_rak = '1';
	else
		$id_rak = $ID[0];
    mysql_query("INSERT INTO rak(idRak,namaRak)
                    VALUES('$id_rak','$_POST[namaRak]')");
    header('location:media.php?module='.$module);
}// end Input Rak

// Update Rak
elseif ($module=='rak' AND $act=='update'){
    mysql_query("UPDATE rak SET namaRak = '$_POST[namaRak]'
                    WHERE idRak = '$_POST[idRak]'");
    header('location:media.php?module='.$module);
}// end Update Rak

// Hapus Rak
elseif ($module=='rak' AND $act=='hapus'){
  mysql_query("DELETE FROM rak WHERE idRak = '$_GET[id]'");
  header('location:media.php?module='.$module);
} // end hapus rak



// Input Barang     =============================================================================================================================
elseif ($module=='barang' AND $act=='input'){

	//fixme: bagaimana dengan idBarangnya ? generate dulu di tmp_detail_beli ?
    $tgl = date("Y-m-d");
    mysql_query("INSERT INTO barang(namaBarang,
                    idKategoriBarang,idSatuanBarang,last_update, barcode, username)
                    VALUES('$_POST[namaBarang]',
                    '$_POST[kategori_barang]','$_POST[satuan_barang]',
                    '$tgl', '$_POST[barcode]', '$_SESSION[uname]')");
    header('location:media.php?module='.$module);
}// end Input Barang


// Hapus Barang
elseif ($module=='barang' AND $act=='hapus'){
	// copy data barang ke table arsip_barang
	$sql	= "INSERT INTO arsip_barang (idBarang, namaBarang, idKategoriBarang, idSatuanBarang, jumBarang, 
			hargaJual, last_update, idSupplier, barcode, username, idRak)
				SELECT idBarang, namaBarang, idKategoriBarang, idSatuanBarang, jumBarang, 
					hargaJual, '".date("Y-m-d")."', idSupplier, barcode, '".$_SESSION[uname]."', idRak 
				FROM barang WHERE idBarang = ".$_GET['id'];
	$hasil	= mysql_query($sql) or die("Error : ".mysql_error()." :: $sql");

	// hapus data barang dari table barang
	$sql	= "DELETE FROM barang WHERE idBarang = ".$_GET['id'];
	$hasil	= mysql_query($sql) or die("Error : ".mysql_error()." :: $sql");

    header('location:media.php?module='.$module);

}// end Hapus Barang


// Update Barang
elseif ($module=='barang' AND $act=='update'){
    $tgl = date("Y-m-d");

	// jika barcode diubah, maka ubah juga semua di :
	// 	detail_beli
	// 	detail_jual
	// 	detail_retur_beli
	//	detail_retur_barang
	//	detail_stock_opname
	// 	fast_stock_opname
	if ($_POST[barcode] <> $_POST[oldbarcode]) {

		// check apakah barcode baru ini sudah ada di database
		// jika sudah ada, batalkan semua tindakan
		$hasil = mysql_query("SELECT * FROM barang WHERE barcode='$_POST[barcode]'");
		if(mysql_num_rows($hasil) > 0) {
			echo "<h2>Barcode $_POST[barcode] sudah ada di database ! Tidak ada perubahan yang dilakukan.</h2><br />
				[<a href='media.php?module=barang'> Kembali ke Menu </a>]";
			exit;
		};		
		
		$hasil	= mysql_query("UPDATE detail_beli 		SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
		$hasil	= mysql_query("UPDATE detail_jual 		SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
		$hasil	= mysql_query("UPDATE detail_retur_beli 	SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
		$hasil	= mysql_query("UPDATE detail_retur_barang 	SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
		$hasil	= mysql_query("UPDATE detail_stock_opname 	SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
		$hasil	= mysql_query("UPDATE fast_stock_opname 	SET barcode='$_POST[barcode]' WHERE barcode='$_POST[oldbarcode]'");
	}

    $sql = "UPDATE barang SET namaBarang = '$_POST[namaBarang]',
			barcode = '$_POST[barcode]',
			idSupplier = $_POST[supplier],
                    	idKategoriBarang = $_POST[kategori_barang],
                    	idSatuanBarang = $_POST[satuan_barang],
                    	hargaJual = $_POST[hargaJual],
                    	last_update = '$tgl',
		    	username = '$_SESSION[uname]', 
		    	idRak = $_POST[rak]  
                    WHERE barcode = '$_POST[barcode]'";
    mysql_query($sql);
    header('location:media.php?module='.$module);
}// end Update Barang



// Input Supplier     =============================================================================================================================
elseif ($module=='supplier' AND $act=='input'){
    //HS idSupplier sekarang auto-increment oleh MySQL, untuk menghindari dobel
    /* 	$ambilID = mysql_query("select max(idSupplier)+1 from supplier");
	$ID = mysql_fetch_array($ambilID);
	$id_supplier;
	if($ID[0]=='')
		$id_supplier = '1';
	else
		$id_supplier = $ID[0];   */

    $tgl = date("Y-m-d");
    mysql_query("INSERT INTO supplier(namaSupplier,
                    alamatSupplier,telpSupplier,Keterangan,last_update)
                    VALUES('$_POST[namaSupplier]',
                    '$_POST[alamatSupplier]','$_POST[telpSupplier]',
                    '$_POST[Keterangan]','$tgl')");
    header('location:media.php?module='.$module);
}// end Input Supplier

// Update Supplier
elseif ($module=='supplier' AND $act=='update'){
    $tgl = date("Y-m-d");
    mysql_query("UPDATE supplier SET namaSupplier = '$_POST[namaSupplier]',
                    alamatSupplier = '$_POST[alamatSupplier]',
                    telpSupplier = '$_POST[telpSupplier]',
                    Keterangan = '$_POST[Keterangan]',
                    last_update = '$tgl'
                    WHERE idSupplier = '$_POST[idSupplier]'");
    header('location:media.php?module='.$module);
}// end Update Supplier

// Hapus Supplier
elseif ($module=='supplier' AND $act=='hapus'){
  mysql_query("DELETE FROM supplier WHERE idSupplier = '$_GET[id]'");
  header('location:media.php?module='.$module);
} // end hapus user



// Input Customer =====================================================================================================
elseif ($module=='customer' AND $act=='input'){
    $ambilID = mysql_query("select max(idCustomer)+1 from customer");
	$ID = mysql_fetch_array($ambilID);
	$id_customer;
	if($ID[0]=='')
		$id_customer = '1';
	else
		$id_customer = $ID[0];
    $tgl = date("Y-m-d");
    mysql_query("INSERT INTO customer(idCustomer,namaCustomer,
                    alamatCustomer,telpCustomer,keterangan,last_update)
                    VALUES('$id_customer','$_POST[namaCustomer]',
                    '$_POST[alamatCustomer]','$_POST[telpCustomer]',
                    '$_POST[keterangan]','$tgl')");
    header('location:media.php?module='.$module);
}// end Input Customer

// Update Customer
elseif ($module=='customer' AND $act=='update'){
    $tgl = date("Y-m-d");
    mysql_query("UPDATE customer SET namaCustomer = '$_POST[namaCustomer]',
                    alamatCustomer = '$_POST[alamatCustomer]',
                    telpCustomer = '$_POST[telpCustomer]',
                    keterangan = '$_POST[keterangan]',
                    last_update = '$tgl'
                    WHERE idCustomer = '$_POST[idCustomer]'");
    header('location:media.php?module='.$module);
}// end Update Customer

// Hapus Customer
elseif ($module=='customer' AND $act=='hapus'){
  mysql_query("DELETE FROM customer WHERE idCustomer = '$_GET[id]'");
  header('location:media.php?module='.$module);
} // end hapus customer



// Input Transaksi Beli =================================================================================================================
elseif ($module=='pembelian_barang' AND $act=='input'){
    $tgl = $_POST[TanggalInvoice];

    //HS - idTransaksi sekarang di generate MySQL, untuk menghindari duplikat / dobel
    /* $ambilID = mysql_query("select max(idTransaksiBeli)+1 from transaksibeli");
	$ID = mysql_fetch_array($ambilID);
	$id_transaksi;
	if($ID[0]=='')
		$id_transaksi = '1';
	else
		$id_transaksi = $ID[0];*/

	//HS jika keliru input tipe pembayaran, default ke 1 = CASH
	if ($_POST[tipePembayaran] == 0) { $_POST[tipePembayaran] = 1;};

	$sql_trans = "INSERT INTO transaksibeli(tglTransaksiBeli,
                    idSupplier,nominal,idTipePembayaran,username,last_update,NomorInvoice)
                    VALUES('$tgl','$_SESSION[idSupplier]',
                           '$_POST[tot_pembayaran]','$_POST[tipePembayaran]',
                            '$_SESSION[uname]','$tgl','$_POST[NomorInvoice]')";
//	echo $sql_trans;

    mysql_query($sql_trans) or die(mysql_error());
	$idTransaksiBeli = mysql_insert_id();

    if($_POST[tipePembayaran]=='2'){

          mysql_query("INSERT INTO hutang(idTransaksiBeli,nominal,tglBayar,
                        username,last_update)
                        VALUES('$idTransaksiBeli','$_POST[tot_pembayaran]',
                        '$_POST[tglBayar]','$_SESSION[uname]','$tgl')") or die(mysql_error());

    }

	$dataBarang = mysql_query("SELECT * from tmp_detail_beli
            where idSupplier = '$_SESSION[idSupplier]' and username = '$_SESSION[uname]' and idBarang != 0") or die(mysql_error());

    while($simpan = mysql_fetch_array($dataBarang)){

	$sql_simpan = "INSERT INTO detail_beli(idTransaksiBeli,barcode,
                        tglExpire,jumBarang,jumBarangAsli,hargaBeli,username,idBarang)
                    VALUES('$idTransaksiBeli','$simpan[barcode]',
                    '$simpan[tglExpire]',$simpan[jumBarang],$simpan[jumBarang],'$simpan[hargaBeli]','$_SESSION[uname]','$simpan[idBarang]')";
//	echo $sql_simpan;
	mysql_query($sql_simpan) or die(mysql_error());

        $jumlahAkhir = 0;
        $jumBarang = mysql_query("select jumBarang from barang where barcode = '$simpan[barcode]'") or die(mysql_error());
        $jumlah = mysql_fetch_array($jumBarang);
        $jumlahAkhir = $jumlah[jumBarang] + $simpan[jumBarang];

        mysql_query("UPDATE barang SET jumBarang = '$jumlahAkhir',
                     hargaJual = '$simpan[hargaJual]' WHERE barcode = '$simpan[barcode]'") or die(mysql_error());
    }
    mysql_query("DELETE FROM tmp_detail_beli where idSupplier = '$_SESSION[idSupplier]' and username = '$_SESSION[uname]'") or die(mysql_error());

    releaseSupplier();
    header('location:media.php?module=pembelian_barang');
}


//Batal sebuah item di Nota Beli
elseif ($module=='pembelian_barang' AND $act=='hapus_detil'){
    mysql_query("DELETE FROM tmp_detail_beli where idSupplier = '$_SESSION[idSupplier]' and idBarang = '$_GET[id]'");
    header('location:media.php?module=pembelian_barang&act=carisupplier');
}


//Batal Seluruh Invoice / Transaksi Beli
elseif ($module=='pembelian_barang' AND $act=='batal'){
    mysql_query("DELETE FROM tmp_detail_beli where idSupplier = '$_SESSION[idSupplier]' and tglTransaksi = '$tgl'");
    releaseSupplier();
    header('location:media.php?module='.$module);
}


// Input Transaksi Jual ======================================================================================================================
elseif ($module=='penjualan_barang' AND $act=='input'){

        //$ambilID = mysql_query("select max(idTransaksiJual)+1 from transaksijual");
	//$ID = mysql_fetch_array($ambilID);
	//$id_transaksi;
	//if($ID[0]=='')
	//	$id_transaksi = '1';
	//else
	//	$id_transaksi = $ID[0];

	// simpan transaksi ke database
	$tgl = date("Y-m-d H:i:s");

	$sql = "INSERT INTO transaksijual(tglTransaksiJual,
                    idCustomer,idTipePembayaran,nominal,idUser,last_update,uangDibayar)
                    VALUES('$tgl','$_SESSION[idCustomer]',
                           '$_POST[tipePembayaran]','$_POST[tot_pembayaran]',
                            '$_SESSION[iduser]','$tgl', $_POST[uangDibayar])";
	$hasil 	= mysql_query($sql) or die(mysql_error());
	//echo $sql;

	$NomorStruk = mysql_insert_id();


	// cetak struk -------------

	// ambil footer & header struk
	$sql   	= "SELECT `option`,`value` FROM config"; 
	$hasil 	= mysql_query($sql) or die(mysql_error());
	while ($x = mysql_fetch_array($hasil)) {
		if ($x[option]=='store_name') { $store_name=$x[value];};
		if ($x[option]=='receipt_header1') { $header1=$x[value];};
		if ($x[option]=='receipt_footer1') { $footer1=$x[value];};
		if ($x[option]=='receipt_footer2') { $footer2=$x[value];};
	};

	// ambil alamat printer
	$sql 	= "SELECT w.printer_commands, w.printer_type FROM kasir AS k, workstation AS w 
		WHERE k.tglTutupKasir IS NULL AND k.idUser = $_SESSION[iduser] AND k.currentWorkstation = w.idWorkstation";
	$hasil 	= mysql_query($sql) or die(mysql_error());
	$x	= mysql_fetch_array($hasil);
	$perintah_printer = $x[printer_commands];
	$jenis_printer = $x[printer_type];

	// ambil transaksi yang akan dicetak
	$sql = "SELECT t.jumBarang,t.hargaJual,b.namaBarang FROM barang AS b, tmp_detail_jual AS t
		WHERE t.username='$_SESSION[uname]' AND t.barcode=b.barcode";
	//echo $sql;
	$hasil 	= mysql_query($sql);
	
	// siapkan string yang akan dicetak
	$struk  = str_pad($store_name, 40, " ", STR_PAD_BOTH) . "\n" . str_pad($header1, 40, " ", STR_PAD_BOTH) . "\n" . str_pad($_SESSION[uname] ." : ". date("d-m-Y H:i") ." #$NomorStruk", 40, " ", STR_PAD_BOTH) ." \n";

	$struk .= "-------------------------------------\n";
	while ($x = mysql_fetch_array($hasil)) {	
		$temp = $x[jumBarang] . "x ". $x[namaBarang]. " @".number_format($x[hargaJual],0,',','.').
				": ".number_format(($x[hargaJual] * $x[jumBarang]),0,',','.')."\n";
		// jika panjang baris > 40 huruf, pecah jadi 2 baris		
		if (strlen($temp) > 40) {
			$tmp = substr($temp, 0, 40) . "- \n -" . substr($temp, 40);
			$temp = $tmp;
		};
		$struk .= $temp;
	}
	$struk .= "-------------------------------------\n";
	$struk .= " TOTAL   : ".number_format($_POST[tot_pembayaran],0,',','.')." \n";
	$struk .= " Dibayar : ".number_format($_POST[uangDibayar],0,',','.')." \n";
	$struk .= " Kembali : ".number_format(($_POST[uangDibayar]-$_POST[tot_pembayaran]),0,',','.')." \n";
	$struk .= "-------------------------------------\n";
	$struk .= str_pad($footer1, 40, " ", STR_PAD_BOTH) . "\n" . str_pad($footer2, 40, " ", STR_PAD_BOTH) . "\n\n\n\n\n\n\n\n\n\n\n\n\n";

	if ($jenis_printer == 'pdf') {
		require('classes/fpdf.php');
		$pdf=new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',9);
		$struk_pdf = explode("\n", $struk);
		foreach ($struk_pdf as $baris)
		{
			$width 	= 40;
			$length	= 1;
			$pdf->Cell($width,$length,$baris);
			$pdf->Ln(3);
		}
		$pdf->Output();

	} elseif ($jenis_printer == 'rlpr') {
		include "classes/PrintSend.php";
		include "classes/PrintSendLPR.php";
		$perintah = "echo \"$struk\" |lpr $perintah_printer -l";
		//echo $perintah; exit;
		exec($perintah, $output);
	};


    if($_POST[tipePembayaran]=='2'){
        mysql_query("INSERT INTO piutang(idTransaksiJual,nominal,tglDiBayar,
                        idUser,last_update)
                        VALUES('$id_transaksi','$_POST[tot_pembayaran]',
                        '$_POST[tglBayar]','$_SESSION[iduser]','$tgl')") or die(mysql_error());
    }


    $dataBarang = mysql_query("SELECT * from tmp_detail_jual
            			WHERE idCustomer = '$_SESSION[idCustomer]' AND username = '$_SESSION[uname]'");
    while($simpan = mysql_fetch_array($dataBarang)){
        $jumlahAkhir = 0;
        $jumBarang = mysql_query("SELECT jumBarang FROM barang WHERE barcode = '$simpan[barcode]'");
        $jumlah = mysql_fetch_array($jumBarang);
        $jumlahAkhir = $jumlah[jumBarang] - $simpan[jumBarang];
	if ($jumlahAkhir < 0) { $jumlahAkhir = 0;};

	//fixme: kurangi quantity pembelian dengan benar :
	//	(1) cari barang di tabel detail_beli, yang stoknya masih ada, lalu
	//	(2) catat quantity nya, lalu
	$sql = "SELECT * FROM detail_beli 
		WHERE isSold='N' AND barcode='$simpan[barcode]' ORDER BY idDetailBeli ASC";
	$hasil = mysql_query($sql);
	$x = mysql_fetch_array($hasil);

	// 	(3) update dengan jumlah yang terjual
	// 		(4) jika stok habis : tandai
	//		(5) jika stok kurang : cari lagi stok lainnya
	//			(6) jika tidak ada lagi - laporkan ke user, bahwa stok kurang 
	$Sold = $simpan[jumBarang];
	$StockAvailable = $x[jumBarang];
	$SoldOut = false; $Finish = false;
	do { // looping mengurangi jumlah terjual (Sold) dengan stok yg ada (StockAvailable)

		// kurangi stok di record tsb dengan $Sold
		if ($Sold >= $StockAvailable) {
			$newStock = 0;
			$Sold = $Sold - $StockAvailable;
			// catat bahwa record ini sudah habis stok nya
			$sql = "UPDATE detail_beli SET isSold='Y' WHERE idDetailBeli=$x[idDetailBeli]";
                	mysql_query($sql);
		} else {
			$newStock = $StockAvailable - $Sold;
			$Finish   = true; $Sold = 0;
		}
		// catat jumlah stok yang baru / sudah dikurangi penjualan
		$sql = "UPDATE detail_beli SET jumBarang=$newStock WHERE idDetailBeli=$x[idDetailBeli]";
		mysql_query($sql);		

		// ambil record berikutnya dari database
		$records = $records - 1;
		if (!($x = mysql_fetch_array($hasil))) { $SoldOut = true;};
		$StockAvailable = $x[jumBarang];
	} while (!$SoldOut && !$Finish);

	if (!$SoldOut) { // kurangi sisa item terjual yang masih ada dengan stok yang ada di database
		// kurangi stok di record tsb dengan $Sold
		if ($Sold > $StockAvailable) {
			$newStock = 0;
		} else {
			$newStock = $StockAvailable - $Sold;
		}
		$sql="UPDATE detail_beli SET jumBarang=$newStock WHERE idDetailBeli=$x[idDetailBeli]";
		mysql_query($sql);
	}

	// 	(7) cari barang di tabel barang, lalu
	//	(8) catat quantity nya, lalu
	// 	(9) update dengan jumlah yang terjual
	//
	$sql = "UPDATE barang SET jumBarang = '$jumlahAkhir' WHERE barcode = '$simpan[barcode]'";        
	$hasil = mysql_query($sql);


	$sql = "INSERT INTO detail_jual(idBarang, barcode, 
                        jumBarang,hargaJual,username, nomorStruk, hargaBeli)
                    VALUES('$simpan[idBarang]', '$simpan[barcode]', 
                    '$simpan[jumBarang]','$simpan[hargaJual]','$_SESSION[uname]', $NomorStruk, $simpan[hargaBeli])";
	//echo $sql;
        mysql_query($sql) or die(mysql_error());
	}

    mysql_query("DELETE FROM tmp_detail_jual WHERE idCustomer = '$_SESSION[idCustomer]' AND username = '$_SESSION[uname]'");
    
    $_SESSION[tot_pembelian] = 0;	
    releaseCustomer();
    //header('location:media.php?module='.$module);
	echo "<script>window.close();</script>";
}

//Batal Transaksi Jual
elseif ($module=='penjualan_barang' AND $act=='batal'){

    mysql_query("DELETE FROM tmp_detail_jual where idCustomer = '$_SESSION[idCustomer]'  AND username = '$_SESSION[uname]'");
    releaseCustomer();

    header('location:media.php?module='.$module);
}

// BUKA KASIR  // -----------------------------------------------------------------------------------------------------------------------------------
elseif ($module=='buka_kasir' AND $act=='input'){

	// cari apakah kasir ini sedang aktif - jika ya, maka tolak
	$sql = "SELECT * FROM kasir WHERE idUser=$_POST[idKasir] AND tglTutupKasir IS NULL";
	$hasil = mysql_query($sql);

	if (mysql_num_rows($hasil) > 0) {
		echo "Kasir ini sedang Aktif ! Silakan ditutup dulu.
			<p>&nbsp;</p>
			    <a href=javascript:history.go(-1)><< Kembali</a>";
	} else {
		$sql = "INSERT INTO kasir(tglBukaKasir,idUser,kasAwal,currentWorkstation) 
			VALUES ('$_POST[tglBukaKasir]',$_POST[idKasir],$_POST[kasAwal],$_POST[idWorkstation])";
		mysql_query($sql);
		header('location:media.php?module=kasir');
	};

}

//TUTUP KASIR
elseif ($module=='tutup_kasir' AND $act=='input'){

	if (empty($_POST[kasAkhir])) {$_POST[kasAkhir] = 0;};
	if (empty($_POST[totalTransaksi])) {$_POST[totalTransaksi] = 0;};
	if (empty($_POST[totalProfit])) {$_POST[totalProfit] = 0;};

	$sql = "UPDATE kasir SET kasTutup 	= $_POST[kasAkhir],
         		kasSeharusnya 		= $_POST[kasSeharusnya],
			tglTutupKasir 		= '$_POST[tglTutupKasir]',
			totalTransaksi 		= $_POST[totalTransaksi], 
			totalProfit 		= $_POST[totalProfit], 
			totalRetur 		= $_POST[totalRetur], 
			totalTransaksiKas 	= $_POST[totalTransaksiKas], 
			totalTransaksiKartu 	= $_POST[totalTransaksiKartu] 
        WHERE idUser = $_POST[idKasir] AND tglTutupKasir IS NULL";
	//echo $sql;

	mysql_query($sql);
	header('location:media.php?module=kasir');
}




elseif($module=='retur_barang' AND $act=='input'){ // ====================================================================================

	$tgl = date("Y-m-d H:i:s");

/*	fixme : simpan ke table 'retur', dan dapatkan nomor nota retur nya

	mysql_query("INSERT INTO transaksijual(tglTransaksiJual,
                    idCustomer,idTipePembayaran,nominal,idUser,last_update,uangDibayar)
                    VALUES('$tgl','$_SESSION[idCustomer]',
                           '$_POST[tipePembayaran]','$_POST[tot_pembayaran]',
                            '$_SESSION[iduser]','$tgl', $_POST[uangDibayar])") or die(mysql_error());
	$NomorStruk = mysql_insert_id();
*/


	// cetak struk -------------
	// ambil transaksi yang akan dicetak
	$sql = "SELECT t.jumBarang,t.hargaJual,t.hargaBeli,b.namaBarang,t.barcode FROM barang AS b, tmp_detail_retur_barang AS t
		WHERE t.username='$_SESSION[uname]' AND t.barcode=b.barcode";
	//echo $sql;
	$hasil 	= mysql_query($sql);

	echo "namaPrinter : ".$_POST[namaPrinter];


		// cetak struk
		//cetakStruk ("$_POST[namaPrinter]", 1, "$_SESSION[uname]", $_POST[tot_retur], 0, $hasil, true);


    // mulai simpan data ke detail_retur_barang
    $dataBarang = mysql_query("SELECT * from tmp_detail_retur_barang 
            			WHERE username = '$_SESSION[uname]'");

    while($simpan = mysql_fetch_array($dataBarang)){

echo "1 <br>";

        $jumlahAkhir = 0;
        $jumBarang = mysql_query("SELECT jumBarang FROM barang WHERE barcode = '$simpan[barcode]'");
        $jumlah = mysql_fetch_array($jumBarang);
        $jumlahAkhir = $jumlah[jumBarang] + $simpan[jumBarang];

	//fixme: kurangi quantity pembelian dengan benar :
	//	(1) cari barang di tabel detail_beli, yang stoknya masih ada, lalu
	//	(2) catat quantity nya, lalu
	$sql = "SELECT * FROM detail_beli 
		WHERE isSold='N' AND barcode='$simpan[barcode]' ORDER BY idDetailBeli ASC";
	$hasil = mysql_query($sql);
	$x = mysql_fetch_array($hasil);

	// 	(3) update dengan jumlah yang di retur
	$retur = $simpan[jumBarang];
	$StockAvailable = $x[jumBarang];

	$newStock = $StockAvailable + $retur;

	mysql_query("UPDATE detail_beli SET jumBarang=$newStock WHERE idDetailBeli=$x[idDetailBeli]");		


	// 	(4) cari barang di tabel barang, lalu
	//	(5) catat quantity nya, lalu
	// 	(6) update dengan jumlah yang di retur
	//
	$sql = "UPDATE barang SET jumBarang = '$jumlahAkhir' WHERE barcode = '$simpan[barcode]'";        
	$hasil = mysql_query($sql);


	$sql = "INSERT INTO detail_retur_barang (tglTransaksi, idBarang, barcode, 	
                        jumBarang,hargaJual,username, hargaBeli)
                    VALUES('$tgl', '$simpan[idBarang]', '$simpan[barcode]', 
                    '$simpan[jumBarang]',$simpan[hargaJual],'$_SESSION[uname]', $simpan[hargaBeli])";
	echo $sql;
        mysql_query($sql) or die(mysql_error());
	}

    mysql_query("DELETE FROM tmp_detail_retur_barang WHERE username = '$_SESSION[uname]'");
    
    $_SESSION[tot_retur] = 0;		
    //header('location:media.php?module='.$module);
	echo "<script>window.close();</script>";
}



//Batal Transaksi Retur Barang
elseif ($module=='retur_barang' AND $act=='batal'){

    mysql_query("DELETE FROM tmp_detail_retur_barang WHERE username = '$_SESSION[uname]'");
    $_SESSION[tot_retur] = 0;	

    header('location:media.php?module=barang');




}

elseif($module=='inputreturbeli' AND $act=='inputtemp'){ // ====================================================================================
	$sql = "INSERT INTO tmp_edit_detail_retur_beli (idDetailBeli,idTransaksiBeli,idBarang,tglExpire,jumBarang,hargaBeli,barcode)
                    SELECT d.idDetailBeli,d.idTransaksiBeli,d.idBarang,d.tglExpire,d.jumBarang,d.hargaBeli,d.barcode 
			FROM detail_beli AS d, barang AS b 
			WHERE b.barcode = d.barcode AND d.idTransaksiBeli = '$_POST[idNota]' AND d.idTransaksiBeli != 0";    
	mysql_query($sql) or die(mysql_error());
	//echo $sql; exit;
    header('location:media.php?module=pembelian_barang&act=inputreturbeli&idnota='.$_POST[idNota]);
}

elseif($module=='inputreturbeli' AND $act=='simpanretur'){ // -----------------------------------------------------------------------------------

	// baca detail nota ybs dari transaksibeli
	$sql = "SELECT * FROM transaksibeli WHERE idTransaksiBeli = $_POST[idNota]" or die(mysql_error());
	$hasil = mysql_query($sql);
	$x = mysql_fetch_array($hasil);
		$idSupplier 		= $x[idSupplier];
		$idTipePembayaran	= $x[idTipePembayaran];
		$NomorInvoice		= $x[NomorInvoice];

	// hitung nominal retur
	$sql = "SELECT SUM(jumRetur * hargaBeli) AS totalRetur, SUM(jumBarang * hargaBeli) AS totalCurrent FROM tmp_edit_detail_retur_beli WHERE idTransaksiBeli = '$_POST[idNota]'";
	$hasil = mysql_query($sql) or die(mysql_error());
	$x = mysql_fetch_array($hasil);
		$nominal 		= $x[totalCurrent] - $x[totalRetur];
		$totalRetur		= $x[totalRetur];
		$username 		= $_SESSION[uname];
		$last_update		= date("Y-m-d");

	// mulai baca data perubahan dari tmp_edit_detail_retur_beli
    	$query = mysql_query("SELECT idTransaksiBeli, idBarang,tglExpire,jumBarang,hargaBeli,barcode,jumRetur, idDetailBeli  
			FROM tmp_edit_detail_retur_beli WHERE idTransaksiBeli = '$_POST[idNota]'") or die(mysql_error());

    while($tmpEdit = mysql_fetch_array($query)){
        $jumBarang = getJumBarangDiBarang($tmpEdit[idDetailBeli], $tmpEdit[barcode]);
        $jumBarangDetail = getJumBarangDetailPembelian($tmpEdit[idDetailBeli]);
        $jumBarangBaru 		= $jumBarang - $tmpEdit[jumRetur];
        $jumBarangDetailBaru 	= $jumBarangDetail - $tmpEdit[jumRetur];

	// update nota pembelian
	if ($jumBarangDetail > 0) { // jika stok sudah nol, jangan dikurangi (jadi minus)
	        mysql_query("UPDATE detail_beli SET jumBarang = '$jumBarangDetailBaru' 
	            WHERE idDetailBeli = '$tmpEdit[idDetailBeli]'") or die(mysql_error());
	}

	// update stok barang
	if ($jumBarang > 0) {  // jika stok sudah nol, jangan dikurangi (jadi minus) 
	        mysql_query("UPDATE barang SET jumBarang = $jumBarangBaru
	                WHERE barcode = '$tmpEdit[barcode]'") or die(mysql_error());
	}

	// input transaksi retur ke database
	if ($tmpEdit[jumRetur] > 0) { // yang jumRetur 0 (nol) tidak usah dicatat
		$z = $tmpEdit;
		$sql = "INSERT INTO detail_retur_beli (idTransaksiBeli,idBarang,tglExpire,jumRetur,hargaBeli,barcode, 
				username,idSupplier,nominal,idTipePembayaran,NomorInvoice,tglRetur) 
			VALUES ($z[idTransaksiBeli],$z[idBarang],'$z[tglExpire]',$z[jumRetur],$z[hargaBeli],'$z[barcode]', 
				'$username','$idSupplier', $totalRetur, $idTipePembayaran, '$NomorInvoice','$last_update')";
		mysql_query($sql) or die(mysql_error());
	}
    }

	// update transaksibeli
	mysql_query("UPDATE transaksibeli SET last_update = '$last_update', nominal = $nominal 
                WHERE idTransaksiBeli = '$_POST[idNota]'") or die(mysql_error());

	// hapus data temporary
	mysql_query("DELETE FROM tmp_edit_detail_retur_beli WHERE idTransaksiBeli = '$_POST[idNota]'") or die(mysql_error());
	header('location:media.php?module=pembelian_barang');
}





elseif($module=='editlaporanpembelian' AND $act=='inputtemp'){ // ====================================================================================
    mysql_query("INSERT INTO tmp_edit_detail_beli(idDetailBeli,idTransaksiBeli,idBarang,tglExpire,jumBarang,hargaBeli)
                    SELECT detail_beli.idDetailBeli,detail_beli.idTransaksiBeli,detail_beli.idBarang,detail_beli.tglExpire,
                            detail_beli.jumBarang,detail_beli.hargaBeli
                            from detail_beli,barang where barang.idBarang = detail_beli.idBarang AND detail_beli.idTransaksiBeli = '$_POST[idNota]' AND detail_beli.idTransaksiBeli != 0") or die(mysql_error());
    header('location:media.php?module=pembelian_barang&act=editlaporan&idnota='.$_POST[idNota]);
}

elseif($module=='editlaporanpembelian' AND $act=='simpanedit'){ // -----------------------------------------------------------------------------------
//    echo "Edit nota $_POST[idNota]";
    $query = mysql_query("SELECT idDetailBeli, idBarang,tglExpire,jumBarang,hargaBeli FROM tmp_edit_detail_beli WHERE idTransaksiBeli = '$_POST[idNota]'") or die(mysql_error());
    while($tmpEdit = mysql_fetch_array($query)){
        $jumBarang = getJumBarangDiBarang($tmpEdit[idDetailBeli]);
        $jumBarangDetail = getJumBarangDetailPembelian($tmpEdit[idDetailBeli]);
        $jumBarangEdit = $jumBarangDetail - $tmpEdit[jumBarang];
        $jumBarangBaru = $jumBarang + $jumBarangEdit;

        mysql_query("UPDATE detail_beli SET tglExpire = '$tmpEdit[tglExpire]', jumBarang = '$tmpEdit[jumBarang]', hargaBeli = '$tmpEdit[hargaBeli]'
            WHERE idDetailBeli = '$tmpEdit[idDetailBeli]'") or die(mysql_error());
        mysql_query("UPDATE barang SET jumBarang = '$jumBarangBaru'
                WHERE idBarang = '$tmpEdit[idBarang]'") or die(mysql_error());
    }
    mysql_query("DELETE FROM tmp_edit_detail_beli WHERE idTransaksiBeli = '$_POST[idNota]'") or die(mysql_error());
    header('location:media.php?module=pembelian_barang&act=detaillaporan&idnota='.$_POST[idNota]);
}

elseif($module=='laporanpenjualan' AND $act=='hapuslaporan'){
//    echo "Kasir : $_POST[kasir], No Nota : $_POST[idNota]";
    $query = mysql_query("SELECT idBarang, jumBarang FROM detail_jual WHERE idTransaksiJual = '$_POST[idNota]'") or die(mysql_error());

    while($penjualan = mysql_fetch_array($query)){
        $queryBarang = mysql_query("SELECT jumBarang FROM barang WHERE idBarang = '$penjualan[idBarang]'") or die(mysql_error());
        $jum = mysql_fetch_array($queryBarang);
        $jumBarangBaru = $jum[jumBarang] + $penjualan[jumBarang];
        mysql_query("UPDATE barang SET jumBarang = $jumBarangBaru WHERE idBarang = '$penjualan[idBarang]'") or die(mysql_error());
    }
    mysql_query("DELETE FROM detail_jual WHERE idTransaksiJual = '$_POST[idNota]'") or die(mysql_error());
    mysql_query("DELETE FROM transaksijual WHERE idTransaksiJual = '$_POST[idNota]'") or die(mysql_error());
}               



else{ // =======================================================================================================================================
    echo "Tidak Ada Aksi untuk modul ini";
}


/* CHANGELOG -----------------------------------------------------------

 1.6.0 / 2013-02-07 : Harry Sufehmi	: bugfix: hapus barang kini sudah bisa
 1.2.5 / 2012-04-17 : Harry Sufehmi 	: bugfix: hapus satuan barang tidak berfungsi
 1.2.5 / 2012-03-16 : Harry Sufehmi 	: bugfix: kini perubahan barang (dari Barang - Cari Barang - Ubah) disimpan dengan benar
						(branch "($module=='barang' AND $act=='update')")
 1.2.5 / 2012-02-14 : Harry Sufehmi	: bugfix: kini Retur Pembelian ($act=='simpanretur') akan mengurangi jumlah stok (jumBarang) di table barang dengan benar
 1.0.3 / 2011-07-14 : Harry Sufehmi	: jika ganti / edit barcode, maka otomatis barcode ybs di table-table lainnya juga di update
 1.0.2 / 2011-03-04 : Harry Sufehmi	: jika user biasa ganti password, kembali ke Home
 1.0.1 / 2010-06-03 : Harry Sufehmi	: penambahan fasilitas workstation management, print ke PDF

 0.9.1		    : Gregorius Arief		: initial release

------------------------------------------------------------------------ */

?>
