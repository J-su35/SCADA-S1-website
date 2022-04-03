<?php
  include "config.php";
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stat = $db->prepare("SELECT * FROM load01 WHERE id=?");
    $stat->bindParam(1, $id);
    $stat->execute();
    $data = $stat->fetch();

    $file = 'load01/'.$data['filename'];

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
