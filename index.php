<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHPでスクレイピング</title>
    <link rel="stylesheet" href="https://unpkg.com/ress@4.0.0/dist/ress.min.css">
    <link rel="stylesheet" href="index.css">
  </head>
  <body>
    <?php
      require './vendor/autoload.php';
      $dotenv = Dotenv\Dotenv::createImmutable('./config');
      $dotenv->load();

      require("./class/Scraping.php");
      require("./class/ReadCSV.php");
      require("./class/WriteCSV.php");
      require("./class/LocalDB.php");
      require("./class/CSVManager.php");

      $csv = new CSVManager($_ENV['CSV']);
      $writer = new WriteCSV($csv);
      $scraping = new Scraping($writer);
      $db = new LocalDB($_ENV['DB'], $_ENV['TABLE']);
      $scraping->pageElementToCSV($db->getArray($_ENV['ROW']));
      $readcsv = new ReadCSV($csv);
      $records = $readcsv->get();
    ?>

    <div class="wrap">
      <?php foreach($records as $item): ?>
        <?php
          echo <<<HTML
          <a href="{$item['url']}" class="box">
            <h2 class="box__ttl">{$item['title']}</h2>
            <p class="box__img"><img src="{$item['img_src']}"></p>
            <p class="box__desc">{$item['description']}</p>
          </a><!-- /.box -->
          HTML;
        ?>
      <?php endforeach; ?>
    </div><!-- /.wrap -->
  </body>
</html>