<?php
  include "config.php";
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stat = $db->prepare("SELECT * FROM usermanual WHERE id=?");
    $stat->bindParam(1, $id);
    $stat->execute();
    $data = $stat->fetch();

    $file = 'user_manual/'.$data['filename'];

    if(file_exists($file)){
      header("Content-Type:application/download");
      header("Content-Disposition:attachment;filename=$file");
      header("Content-Transfer-Encoding:binary");
      readfile("$file");

      exit();
    }
  }

 ?>
