<?php
  require_once "../srv/_config_admin.php";

  $imp = new Implantation($db);
  $impCount = $imp->getImplantationCount(); // number of implantations
  $impNumberResults = 1; // you can change the number of results displayed here
  $impPageCount = ceil($impCount / $impNumberResults); // number of pages for the pagination
  $impStartList = $imp->getImplantationList(0, $impNumberResults, 'nameimplantation', 'ASC'); // results showed on the first page
?>
