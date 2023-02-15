<?php
class WriteCSV {
  private $fp;

  public function __construct(CSVManager $csv) {
    $this->fp = fopen($csv->getFilePath(), 'w');
    fwrite($this->fp, mb_convert_encoding(implode(',', ['url', 'title', 'description', 'img_src']), "SJIS", "UTF-8") . "\r\n");
  }

  public function __destruct() {
    fclose($this->fp);
  }

  public function write($content) {
    fwrite($this->fp, mb_convert_encoding(implode(',', array_map(function($value){return "\"{$value}\"";}, $content)), "SJIS", "UTF-8") . "\r\n");
  }
}