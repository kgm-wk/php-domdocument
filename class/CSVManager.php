<?php
class CSVManager {
  private $csvFileName;
  private $tempDir;

  public function __construct($csvFileName) {
    $this->csvFileName = $csvFileName;
    $this->tempDir = 'temp';
    $this->mkdir();
  }

  private function mkdir() {
    if(!file_exists($this->tempDir)){
      mkdir($this->tempDir, 0777);
    }
  }

  public function getFilePath() {
    return $this->tempDir . '/' . $this->csvFileName;
  }
}