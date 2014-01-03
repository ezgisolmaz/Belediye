<?php 
 
require("database.php");
  $komut=$_POST["komut"];
  
  if($komut=="seferler"){
  $SQ = sprintf("SELECT * from guzergah where GuzergahID = '%s' ",mysql_real_escape_string($_POST["seferID"]));
     $result = mysql_query($SQ);
      if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
      } 
	  $rows = array();
  
       while($r = mysql_fetch_assoc($result)){
	   $rows[] = $r;
	   }
       print json_encode($rows);										
  
  }else if($komut=="saatler"){
     $SQ = sprintf("SELECT saat,dakika,oto_id,ozel_gun_durum FROM saatlar WHERE oto_id=%d Order BY saat,dakika ASC",$_POST["OtoID"]);
     $result = mysql_query($SQ);
      if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
      } 
	  $rows = array();
  
       while($r = mysql_fetch_assoc($result)){
	   $rows[] = $r;
	   }
       print json_encode($rows);										
  
  
  }else if($komut=="oto_update"){
        $SQ = sprintf("DELETE FROM saatlar WHERE oto_id=%d",$_POST["oto_id"]);
        $result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
         } 
         foreach ( $_POST["normal_zaman"] as $saat){
	      //INSERT INTO `ebb-otobus`.`saatlar` (`id`, `oto_id`, `saat`, `dakika`, `ozel_gun_durum`) VALUES (NULL, '1', '9', '30', '0');
	      $SQ = sprintf("INSERT INTO saatlar (oto_id,saat,dakika,ozel_gun_durum) VALUES (%d, %d, %d, %d)",$_POST["oto_id"],$saat["saat"],$saat["dakika"],0);
	    	$result = mysql_query($SQ);
          if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
          } 
	  
	  }
      foreach ( $_POST["resmi_tatil"] as $saat ){
	  //INSERT INTO `ebb-otobus`.`saatlar` (`id`, `oto_id`, `saat`, `dakika`, `ozel_gun_durum`) VALUES (NULL, '1', '9', '30', '0');
	    $SQ = sprintf("INSERT INTO saatlar (oto_id,saat,dakika,ozel_gun_durum) VALUES (%d, %d, %d, %d)",$_POST["oto_id"],$saat["saat"],$saat["dakika"],1);
		$result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
        } 
	  
	  }
	 //UPDATE `otobus` SET `Renk`=[value-1],`No`=[value-2],`OtobusID`=[value-3],`GuzergahID`=[value-4] WHERE 1
	$SQ = sprintf("UPDATE otobus SET GuzergahID=%d WHERE OtobusID=%d",$_POST["sefer"],$_POST["oto_id"]);
		$result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
        } 
  }else if($komut=="add_oto"){
       $SQ = sprintf(" SELECT COUNT(1) AS a_exists FROM otobus WHERE Renk='%s' AND No=%d",$_POST["oto_color"],$_POST["oto_number"]);
        $result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
         }
		 
		 $r = mysql_fetch_assoc($result);
		 
		 if((int)$r["a_exists"]>0){
		   print  json_encode("[{'hata':'otobus mevcut'}]");		
		  }else{
		     print_r($_POST); 
		    $SQ = sprintf("INSERT INTO otobus (Renk,No,GuzergahID) VALUES ('%s','%s',%d)",$_POST["oto_color"],$_POST["oto_number"],$_POST["sefer"]);
            $result = mysql_query($SQ);
            if (!$result) {
              die('Geçersiz Sorgu: ' . mysql_error());
            }
			
			 $r = mysql_fetch_assoc(mysql_query("SELECT last_insert_id() as oto_id"));
			  foreach ( $_POST["normal_zaman"] as $saat){
	      //INSERT INTO `ebb-otobus`.`saatlar` (`id`, `oto_id`, `saat`, `dakika`, `ozel_gun_durum`) VALUES (NULL, '1', '9', '30', '0');
	      $SQ = sprintf("INSERT INTO saatlar (oto_id,saat,dakika,ozel_gun_durum) VALUES (%d, %d, %d, %d)",$r["oto_id"],$saat["saat"],$saat["dakika"],0);
	    	$result = mysql_query($SQ);
          if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
          } 
	  
	   }
        foreach ( $_POST["resmi_tatil"] as $saat ){
	  //INSERT INTO `ebb-otobus`.`saatlar` (`id`, `oto_id`, `saat`, `dakika`, `ozel_gun_durum`) VALUES (NULL, '1', '9', '30', '0');
	    $SQ = sprintf("INSERT INTO saatlar (oto_id,saat,dakika,ozel_gun_durum) VALUES (%d, %d, %d, %d)",$r["oto_id"],$saat["saat"],$saat["dakika"],1);
		$result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
        } 
	  
	  }
		    
		   
		   
		  }
		 
       		 
  
  
  
  
  }else if($komut=="guz_update"){
    //komut:"guz_update",
   // basnok:$("#baslangic").val(),
//	bitnok:$("#bitis").val(),
//g_bitis:$("#g_bitis").val(),
//	g_basla:$("#g_basla").val(),
 //   guz_id:$("#g_sefer").val() 
       if($_POST["guz_id"]=="-1"){
	   //INSERT INTO `guzergah`(`GuzergahID`, `BasNok`, `BitNok`, `DonusAraDurak`, `GidisAraDurak`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5])
	    $SQ = sprintf("INSERT INTO guzergah (BasNok,BitNok,DonusAraDurak,GidisAraDurak) VALUES ('%s', '%s', '%s', '%s')",$_POST["basnok"],$_POST["bitnok"],$_POST["g_bitis"],$_POST["g_basla"]);
		$result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
        }
	   
	   }else{
	   //UPDATE `guzergah` SET `GuzergahID`=[value-1],`BasNok`=[value-2],`BitNok`=[value-3],`DonusAraDurak`=[value-4],`GidisAraDurak`=[value-5] WHERE 1
	   $SQ = sprintf("UPDATE guzergah SET BasNok='%s',BitNok='%s',DonusAraDurak='%s',GidisAraDurak='%s' WHERE GuzergahID=%d",$_POST["basnok"],$_POST["bitnok"],$_POST["g_bitis"],$_POST["g_basla"],$_POST["guz_id"]);
		$result = mysql_query($SQ);
        if (!$result) {
         die('Geçersiz Sorgu: ' . mysql_error());
        }
	   }
  
  
  
  
  }







 
?>
