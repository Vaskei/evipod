<?php
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../");

if (isset($_POST['plantingPDF'])) {

  require_once '../connection.php';
  $userId = $_SESSION['user_id'];
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];

  $query = $conn->prepare("SELECT * FROM business WHERE business_id = ? LIMIT 1");
  $query->bind_param("i", $currentBusinessId);
  $query->execute();
  $currentBusiness = $query->get_result()->fetch_assoc();

  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, planting.* FROM planting INNER JOIN fields ON planting.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, planting.planting_date");
  $query->bind_param("i", $currentBusinessId);
  $query->execute();
  $result = $query->get_result();

  // Include the main TCPDF library (search for installation path).
  require_once('../tcpdf/config/tcpdf_config.php');
  require_once('../tcpdf/tcpdf.php');

  // create new PDF document
  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

  // set document information
  $pdf->SetCreator(PDF_CREATOR);
  $pdf->SetAuthor('Evipod');
  $pdf->SetTitle('Izvještaj - sadnja/sjetva');
  $pdf->SetSubject('Izvještaj - sadnja/sjetva');
  $pdf->SetKeywords('TCPDF, PDF');

  // set default header data
  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, html_entity_decode($currentBusiness['business_name']) . ' - Sadnja/sjetva izvještaj', PDF_HEADER_STRING, array(111, 125, 126), array(111, 125, 126));
  $pdf->setFooterData(array(111, 125, 126), array(111, 125, 126));

  // set header and footer fonts
  $pdf->setHeaderFont(array('freeserif', '', PDF_FONT_SIZE_MAIN));
  $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
  if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
  }

  // ---------------------------------------------------------

  // set font
  $pdf->SetFont('freeserif', '', 11, '', true);

  // add a page
  $pdf->AddPage();

  // create some HTML content
  $html = '
  <style>
  .thead {
    background-color: #dddddd;
  }
  th {
    border-top: 2px solid #233140;
    border-bottom: 3px solid #233140;
  }
  td {
    border  : 1px solid #233140;
  }
  </style>

  <table cellpadding="4" align="center">
  <thead>
  <tr class="thead">
    <th>Zemljište (ARKOD)</th>
    <th>Kultivar</th>
    <th>Sjeme (kg/ha)</th>
    <th>Datum</th>
    <th>Porijeklo</th>
    <th>Napomena</th>
  </tr>
  </thead>';

  while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
    <td>{$row['field_name']}<br><small>{$row['field_arkod']}</small></td>
    <td>{$row['planting_name']}</td>
    <td>{$row['planting_count']}</td>
    <td>" . date('d. m. Y.', strtotime($row['planting_date'])) . "</td>
    <td>{$row['planting_source']}</td>
    <td>{$row['planting_note']}</td>
    </tr>";
  }
  $html .= '</table>';

  // output the HTML content
  $pdf->writeHTML($html, true, false, true, false, '');

  //Close and output PDF document
  $pdf->Output($currentBusiness['business_name'] . '_sadnja_sjetva_izvjestaj.pdf', 'D');
} else {
  header('Location: ../../');
}
