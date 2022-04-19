<!DOCTYPE html>
<html>
<head>
  <style>
          body {
              font-family: Sans-Serif;
              font-size: 12px;
          }
          table, td, th {
              border: 1px solid lightgray;
              border-spacing: 2px;
              font-size: 12px;
          }
          td {
              text-align: left;
              vertical-align: top;
              font-size: 12px;
          }
        </style>
</head>




<body>

 <h1>Espadons Fits File Converter</h1><p><br>

  This page allows you to convert Espadons fits files into ascii .s files, to use with other tools. There are 2 ways to use this program:

    <ul>
      <li>
  1. you have the Espadons (odometer)i.fits.gz or (odometer)p.fits.gz file on your computer, you can upload and convert it.
</li><li>
  2. It's a file that is publicly available at <a href="https://www.cadc-ccda.hia-iha.nrc-cnrc.gc.ca/en/search/?collection=CFHT&noexec=true">CADC</a>, you can 
supply the odometer (and i or p). An example is '1005827i'. we will then download the file on the server, and convert it.
      </li>
    </ul>
    
  Both options will provide the same output/links/files.

    If you encounter problems, please contact Heather Flewelling at heather@cfht.hawaii.edu.

    If you want to convert a lot of files, please contact us for guidance!

<br><p style="color:red"><b>WARNING-1: Once you click 'Upload file' or 'Get from CADC', it will take up to a few minutes for the script to complete. Please be patient!</b></p>
<p style="color:red"><b>WARNING-2: The fits file and converted .s files will live on this server for a random amount of time.</b></p>
<?php
$odom="test";
$odom=$_POST["odomtxt"];

?>

   <table>
      <tr>
        <td style="width:800px;">
          <b>Choose Espadons File - either from your computer or CADC</b>
        <br><p>


<form action="upload.php" method="post" enctype="multipart/form-data">
  Select fits file to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload file" name="submit">
</form>
<br>
 -- or -- 
<br><p>
<form action="upload.php" method="post" enctype="multipart/form-data">
  Select CADC odometer:
  <input type="text" value="<?php echo $odom?>" name="odomtxt" id="odomtxt">
  <input type="submit" value="Get from CADC" name="submit2">
</form>
        (example/valid odometer is 1005827i)<br>
        </td>
      </tr>
      <td style="height:150px;">
         <b>Output Files</b><br>





<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit2"])) {



if (isset($_POST["odomtxt"])) {
$odom=$_POST["odomtxt"];

echo "Getting $odom header from CADC..<br>";

#get the file from cadc

$out=null;
$ret=null;
if (!file_exists("uploads/$odom.hdr")) {
echo "wget https://ws.cadc-ccda.hia-iha.nrc-cnrc.gc.ca/data/pub/CFHT/$odom.fits.gz?fhead=true -O uploads/$odom.hdr -o uploads/$odom.log";
echo "<br>";

exec("wget https://ws.cadc-ccda.hia-iha.nrc-cnrc.gc.ca/data/pub/CFHT/$odom.fits.gz?fhead=true -O uploads/$odom.hdr -o uploads/$odom.log", $out, $ret);
}
echo "checking if it is an Espadons file: ";

#if it matches 'ESPaDOnS':

$line=system("grep INSTRUM uploads/$odom.hdr | grep -i espadons | wc -l", $ret3);

if ($line == 1) {
   echo "<br>$odom is an Espadons fits file!<br>";
   if (!file_exists("uploads/$odom.fits.gz")) {
      exec("wget https://ws.cadc-ccda.hia-iha.nrc-cnrc.gc.ca/data/pub/CFHT/$odom.fits.gz -O uploads/$odom.fits.gz -o uploads/$odom.log", $out, $ret);
      echo "Downloading $odom.fits.gz from CADC<br>";
   } else {
         echo "File has been downloaded before, not downloading again.<br>";
   }

   if (!file_exists("uploads/$odom.sn")) {
   
      $out2=null;
      $ret2=null;
      echo "Converting file to txt files<br>";
      exec("/home/heather/Downloads/opera/operaFits2txt-1.0/operaFits2txt uploads/$odom.fits.gz",$out2, $ret2);
   } else {
      echo "File has been converted before, not converting again.<br>";
   }

#if good, then do stuff with it
    echo "<br>";
        if (file_exists("uploads/$odom.sn")) {
       echo "<br> Converted Files --> <a href='uploads/$odom.sn'>$odom.sn</a> ";
    }
        if (file_exists("uploads/".$odom."n.s")) {
       echo "<a href='uploads/".$odom."n.s'>".$odom."n.s</a> ";
    }
            if (file_exists("uploads/".$odom."u.s")) {
       echo "<a href='uploads/".$odom."u.s'>".$odom."u.s</a> ";
    }
                if (file_exists("uploads/".$odom."nw.s")) {
       echo "<a href='uploads/".$odom."nw.s'>".$odom."nw.s</a> ";
    }
            if (file_exists("uploads/".$odom."uw.s")) {
       echo "<a href='uploads/".$odom."uw.s'>".$odom."uw.s</a> ";
    }
    if (file_exists("uploads/$odom.hdr")) {
       echo "Converted Files --> <a href='uploads/$odom.hdr'>$odom.hdr</a> ";
    }


}
}
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
#  if($check !== false) {
#    echo "File is an image - " . $check["mime"] . ".";
#    $uploadOk = 1;
#  } else {
#    echo "File is not an image.";
#    $uploadOk = 0;
#  }


// Check if file already exists
if (file_exists($target_file)) {
  echo "File already exists. Skipping upload.";
  $uploadOk = 1;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "fits" && $imageFileType != "fits.gz" && $imageFileType != "fit"
&& $imageFileType != "fits.fz" ) {
  echo "Sorry, only fits, fits.fz, fits.gz files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

    

  } else {
    echo "Sorry, there was an error uploading your file.";
  }

$fileup=htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]));
echo $fileup;
echo "<br>";
$odom2=basename($fileup,".$imageFileType");
echo $odom2;
echo "<br>";
if (file_exists("uploads/$fileup")) {
echo "uploads/$fileup exists!";
#file exists, do stuff

   if (!file_exists("uploads/$odom2.sn")) {
   
      $out2=null;
      $ret2=null;
      echo "Converting file to txt files<br>";
      exec("/home/heather/Downloads/opera/operaFits2txt-1.0/operaFits2txt uploads/$fileup",$out2, $ret2);
   } else {
      echo "File has been converted before, not converting again.<br>";
   }

#if good, then do stuff with it
    echo "<br>";
        if (file_exists("uploads/$odom2.sn")) {
       echo "<br>Converted Files --> <a href='uploads/$odom2.sn'>$odom2.sn</a> ";
    }
        if (file_exists("uploads/".$odom2."n.s")) {
       echo "<a href='uploads/".$odom2."n.s'>".$odom2."n.s</a> ";
    }
            if (file_exists("uploads/".$odom2."u.s")) {
       echo "<a href='uploads/".$odom2."u.s'>".$odom2."u.s</a> ";
    }
                if (file_exists("uploads/".$odom2."nw.s")) {
       echo "<a href='uploads/".$odom2."nw.s'>".$odom2."nw.s</a> ";
    }
            if (file_exists("uploads/".$odom2."uw.s")) {
       echo "<a href='uploads/".$odom2."uw.s'>".$odom2."uw.s</a> ";
    }
    if (file_exists("uploads/$odom2.hdr")) {
       echo "<a href='uploads/$odom2.hdr'>$odom2.hdr</a> ";
    }


}

}
}
?>


        </td><p>
      </tr>
      </table>

   

<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

</body>
</html>