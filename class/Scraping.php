<?php
class Scraping {
  private $writer;

  public function __construct(WriteCSV $writer) {
    $this->writer = $writer;
  }

  public function pageElementToCSV($urlList) {
    $dom = new DOMDocument('1.0', 'UTF-8');

    foreach ($urlList as $url) {
      $html = file_get_contents($url);
      @$dom->loadHTML($html);
      $xpath = new DOMXpath($dom);
      $elements = $xpath->query('//body//*[self::main or self::section or self::div or self::p]/text()[string-length() > 20]');
      $desc = array_reduce(iterator_to_array($elements), function($acc, $cur) {
        $acc .= $cur->nodeValue;
        return $acc;
      }, '');
      $ttl = preg_replace('/ \| .+/', '', $xpath->query("//title")[0]->nodeValue);
      $imgsrc = $xpath->query("//div[@class='as-banner-image--top']//child::img/@src")->length
                ? $imgsrc = $xpath->query("//div[@class='as-banner-image--top']//child::img/@src")[0]->nodeValue
                : 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Apple_logo_black.svg/120px-Apple_logo_black.svg.png';
      $this->writer->write([$url, $ttl, $desc, $imgsrc]);
    }
  }
}