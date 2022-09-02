<?php

namespace App\Http\Services;
use App\Http\Contracts\FileParsingByTypeInterface;

class CsvFileParser implements FileParsingByTypeInterface
{

    final public static function parseFile(mixed  $file): array
    {
      $data = [];
      $params = ["payment_date", "client_id", "client_type", "payment_type", "amount", "currency"];
      $fileOpen = fopen($file, 'r');

      $x = 0;
      while (!feof($fileOpen)) {
          $arr = [];
          $singleLine = fgetcsv($fileOpen, null, ",");
          for ($i=0; $i < count($params); $i++) {
            $arr[$params[$i]] = $singleLine[$i];
          }
          $data[$x] = $arr;
          $x++;
      }
      fclose($fileOpen);
      return $data;
    }
}



// $data["payment_date"] = fgetcsv($fileHandle, null, ",");
// $data["user_id"] = fgetcsv($fileHandle, null, ",");
// $data["client_type"] = fgetcsv($fileHandle, null, ",");
// $data["payment_type"] = fgetcsv($fileHandle, null, ",");
// $data["amount"] = fgetcsv($fileHandle, null, ",");
// $data["currency"] = fgetcsv($fileHandle, null, ",");
