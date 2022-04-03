<?php
  include "config.php";
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stat = $db->prepare("SELECT * FROM sigleline WHERE id=?");
    $stat->bindParam(1, $id);
    $stat->execute();
    $data = $stat->fetch();


    // $file1 = 'sigleline/115kV/2007/'.$data['filename'];
    // $file2 = 'sigleline/115kV/2013/'.$data['filename'];
    // $file3 = 'sigleline/115kV/pdf/'.$data['filename'];
    //
    // $file4 = 'sigleline/22-33kV/2007/'.$data['filename'];
    // $file5 = 'sigleline/22-33kV/20013/'.$data['filename'];
    // $file6 = 'sigleline/22-33kV/pdf/'.$data['filename'];
    $file = 'sigleline/'.$data['filename'];

    if(file_exists($file)){
      // header('Content-Description: '. $data['description']);
      // header('Content-Type: '.$data['type']);
      // header('Content-Disposition: '.$data['disposition'].'; filename="'.basename($file).'"');
      // header('Expires: '.$data['expires']);
      // header('Cache-Control: '.$data['cache']);
      // header('Pragma: '.$data['pragma']);
      // header('Content-Length: '.filesize($file));
      // readfile($file);

      header("Content-Type:application/download");
      header("Content-Disposition:attachment;filename=$file");
      header("Content-Transfer-Encoding:binary");
      readfile("$file");

      exit();
    }
  }

 ?>
