<?php
/*



*/

require 'vendor/autoload.php';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("./excel.xlsx");

$worksheet = $spreadsheet->getActiveSheet();
$worksheetArray = $worksheet->toArray();
array_shift($worksheetArray);

echo '<table style="width:100%"  border="1">';
echo '<tr align="center">';
echo '<td>Sno</td>';
echo '<td>Name</td>';
echo '<td>Image</td>';
echo '</tr>';

foreach ($worksheetArray as $key => $value) {

    $worksheet = $spreadsheet->getActiveSheet();
    $drawing = $worksheet->getDrawingCollection()[$key];

    $zipReader = fopen($drawing->getPath(), 'r');
    $imageContents = '';
    while (!feof($zipReader)) {
        $imageContents .= fread($zipReader, 1024);
    }
    fclose($zipReader);
    $extension = $drawing->getExtension();

    echo '<tr align="center">';
    echo '<td>' . $value[0] . '</td>';
    echo '<td>' . $value[1] . '</td>';
    echo '<td><img  height="150px" width="150px"   src="data:image/jpeg;base64,' . base64_encode($imageContents) . '"/></td>';
    echo '</tr>';
}