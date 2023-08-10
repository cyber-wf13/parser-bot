<?php

namespace Testbot\Video;

use Error;
use Testbot\FileSystem;
use YouTube\YouTubeDownloader;

class Youtube
{
  private $link;
  public $baseFileName;
  public $storage;

  // https://www.youtube.com/watch?v=QC8iQqtG0hg&ab_channel=PanamaCityNewsHerald
  public function __construct($link = '', $fileName = '', $storageName  = 'storage/')
  {
    $this->link = $link;
    if (strlen($fileName) === 0) {
      $fileName = $this->getUrlVideoId($link) . '.mp4';
      // $fileName = date('j-m-o_H:i:s') . '.mp4';
    }
    $this->storage = new FileSystem($storageName);

    $this->storage->checkDir();
    $this->baseFileName =  $this->storage->dir . $fileName;
  }

  public function init()
  {
    if (file_exists($this->baseFileName)) {
      return;
    }
    $youtube = new YouTubeDownloader();
    $downloadOpts = $youtube->getDownloadLinks($this->link);
    prettyResponse($downloadOpts->getAllFormats(), 'yt.json');

    // $downloadUrl = $downloadOpts->getAllFormats()[0]->url;
    // $this->downloadVideo($downloadUrl);
  }

  public function deleteVideo()
  {
    if (file_exists($this->baseFileName)) {
      unlink($this->baseFileName);
    } else {
      throw new Error("File is not exist");
    }
  }

  public function getUrlVideoId($url)
  {
    $urlComponents = parse_url($url);
    if ($urlComponents['host'] === 'youtu.be') {
      // prettyResponse($this->baseFileName, 'response.html', false);
      return ltrim($urlComponents['path'], '/');
    }

    parse_str($urlComponents['query'], $urlQueryItems);
    return $urlQueryItems['v'];
  }

  public function clearFolder()
  {
    array_map('unlink', glob($this->storage->dir . '*.mp4'));
  }

  public function checkStorageSize()
  {
    $sizeOfBytes = 700000000;
    if ($this->storage->folderSize() > $sizeOfBytes) {
      $this->clearFolder();
    }
  }



  protected function downloadVideo($url)
  {
    // file_put_contents('log.json', json_encode($downloadOpts->getAllFormats()[0]->toArray()));
    file_put_contents($this->baseFileName, file_get_contents($url));
  }
}
