<?php
session_start();
require_once './app/includes/connection.php';
$userId = $_SESSION['user_id'];
$query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
$query->bind_param("i", $userId);
$query->execute();
$result = $query->get_result()->fetch_assoc();
$currentBusinessId = $result['current_business_id'];

$query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
$query->bind_param("i", $currentBusinessId);
$query->execute();
$result = $query->get_result();
// while ($field = $result->fetch_assoc()) {
//   $field = array_map('html_entity_decode', $field);
//   $data[] = $field;
// }
// var_dump($data);
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Hello, world!</title>
  <style>
  </style>
</head>

<body>

  <?php
  echo "
  <table border='2' cellpadding='4' vertical-align='center'>
    <tr>
      <th>Naziv</th>
      <th>Površina (ha)</th>
      <th>ARKOD ID</th>
      <th>Napomena</th>
    </tr>";
  while ($row = $result->fetch_assoc()) {
    // $row = array_map('html_entity_decode', $row);
    echo "<tr>";
    echo "<td>{$row['field_name']}</td>";
    echo "<td>{$row['field_size']}</td>";
    echo "<td>{$row['field_arkod']}</td>";
    echo "<td>{$row['field_note']}</td>";
    echo "</tr>";
  }
  echo "</table>";
  ?>

  <!-- <table border="2">
    <tr>
      <th>Naziv</th>
      <th>Površina (ha)</th>
      <th>ARKOD ID</th>
      <th>Napomena</th>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </table> -->

  <?php

  // class MYPDF extends TCPDF
  // {
  //   // Load table data from file
  //   public function LoadData()
  //   {
  //     require_once '../connection.php';
  //     $userId = $_SESSION['user_id'];
  //     $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  //     $query->bind_param("i", $userId);
  //     $query->execute();
  //     $result = $query->get_result()->fetch_assoc();
  //     $currentBusinessId = $result['current_business_id'];

  //     $query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
  //     $query->bind_param("i", $currentBusinessId);
  //     $query->execute();
  //     $result = $query->get_result();
  //     while ($field = $result->fetch_assoc()) {
  //       $field = array_map('html_entity_decode', $field);
  //       $data[] = $field;
  //     }
  //     return $data;
  //   }

  //   // Colored table
  //   public function ColoredTable($header, $data)
  //   {
  //     // Colors, line width and bold font
  //     $this->SetFillColor(224, 235, 255);
  //     $this->SetTextColor(0);
  //     $this->SetDrawColor(135, 153, 154);
  //     $this->SetLineWidth(0.3);
  //     $this->SetFont('', 'B');
  //     // Header
  //     $w = array(107, 30, 30, 100);
  //     $num_headers = count($header);
  //     for ($i = 0; $i < $num_headers; ++$i) {
  //       $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
  //     }
  //     $this->Ln();
  //     // Color and font restoration
  //     $this->SetFillColor(230, 230, 230);
  //     $this->SetTextColor(0);
  //     $this->SetFont('');
  //     // Data
  //     $fill = 0;
  //     foreach ($data as $row) {
  //       $this->Cell($w[0], 6, $row['field_name'], 'LR', 0, 'C', $fill);
  //       $this->Cell($w[1], 6, $row['field_size'], 'LR', 0, 'C', $fill);
  //       $this->Cell($w[2], 6, $row['field_arkod'], 'LR', 0, 'C', $fill);
  //       $this->Cell($w[3], 6, $row['field_note'], 'LR', 0, 'C', $fill);
  //       $this->Ln();
  //       $fill = !$fill;
  //     }
  //     $this->Cell(array_sum($w), 0, '', 'T');
  //   }
  // }

  // // create new PDF document
  // $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // // set document information
  // $pdf->SetCreator(PDF_CREATOR);
  // $pdf->SetAuthor('Evipod');
  // $pdf->SetTitle('Izvještaj - zemljišta');
  // $pdf->SetSubject('Izvještaj - zemljišta');
  // $pdf->SetKeywords('TCPDF, PDF');

  // // set default header data
  // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Izvještaj - zemljišta', PDF_HEADER_STRING);

  // // set header and footer fonts
  // $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
  // $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

  // // set default monospaced font
  // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

  // // set margins
  // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
  // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
  // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

  // // set auto page breaks
  // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

  // // set image scale factor
  // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

  // // set some language-dependent strings (optional)
  // if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
  //   require_once(dirname(__FILE__) . '/lang/eng.php');
  //   $pdf->setLanguageArray($l);
  // }

  // // ---------------------------------------------------------

  // // set font
  // $pdf->SetFont('freeserif', '', 11, '', true);

  // // add a page
  // $pdf->AddPage();

  // // column titles
  // $header = array('Naziv', 'Površina (ha)', 'ARKOD ID', 'Napomena');

  // // data loading
  // $data = $pdf->LoadData('data/table_data_demo.txt');

  // // print colored table
  // $pdf->ColoredTable($header, $data);

  // // ---------------------------------------------------------

  // // close and output PDF document
  // $pdf->Output('izvjestaj-zemljista.pdf', 'I');

  // //============================================================+
  // // END OF FILE
  // //============================================================+


  /*
// Include the main TCPDF library (search for installation path).
require_once('../tcpdf/config/tcpdf_config.php');
require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Evipod');
$pdf->SetTitle('Izvještaj - zemljišta');
$pdf->SetSubject('Izvještaj - zemljišta');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Izvještaj - zemljišta', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
*/

?>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>