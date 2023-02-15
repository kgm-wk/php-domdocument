<?php
class ReadCSV {
  private $csv;

  public function __construct(CSVManager $csv) {
    $this->csv = $csv;
  }

  private function getArrayFromCSV() {
    $file = new SplFileObject($this->csv->getFilePath());
    $file->setFlags(SplFileObject::READ_CSV);
    foreach ($file as $line) {
      $file_array[] = $line;
    }
    return $file_array;
  }

  private function toAssociativeArray($file_array) {
    $headings = [];
    foreach ($file_array as $key => $line) {
      if ($key === array_key_first($file_array)) {
        foreach($line as $item) {
          $headings[] = $item;
        }
        continue;
      }
      mb_convert_variables('UTF-8', array('SJIS-win'), $line);
      if(!is_null($line[0])){
        foreach($headings as $index => $hd) {
          $content[$hd] = $line[$index];
        }
        $records[] = $content;
      }
    }
    return $records;
  }

  public function get() {
    return $this->toAssociativeArray($this->getArrayFromCSV());
  }
}