<?php

namespace Testbot;

class FileSystem
{

  public $dir;

  public function __construct($dir)
  {
    $this->dir = $dir;
  }

  public function checkDir()
  {
    if (is_dir($this->dir)) {
      return $this->dir;
    }

    if (!mkdir($this->dir,  0777, true)) {
      throw new Error('Dir is not created');
    }
  }

  public  function folderSize($dir = '')
  {
    if (!$dir) {
      $dir = $this->dir;
    }
    $countSize = 0;
    $count = 0;
    $dirArray = scandir($dir);
    foreach ($dirArray as $key => $filename) {
      if ($filename != ".." && $filename != ".") {
        if (is_dir($dir . "/" . $filename)) {
          $newFoldersize = foldersize($dir . "/" . $filename);
          $countSize = $countSize + $newFoldersize;
        } else if (is_file($dir . "/" . $filename)) {
          $countSize = $countSize + filesize($dir . "/" . $filename);
          $count++;
        }
      }
    }
    return $countSize;
  }
}
