<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : header.php
  Description                 : Contains the Javascript,Css file inclusion
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
if(isset($_SESSION[CLIENT_ID])){
    $client_id =  $_SESSION[CLIENT_ID];
}else{
    $client_id = NULL;
}
?>


<script type="text/javascript">
    var baseurlString = "<?php echo BASE_URL_STRING; ?>";
    var cmsbaseurlString = "<?php echo CMS_BASE_URL_STRING; ?>";
    var apibaseurlString = "<?php echo API_BASE_URL_STRING . API_VERSION . "/"; ?>";
    var environment = "<?php echo (ENVIRONMENT === "Production") ? "-prod" : ((ENVIRONMENT === "Stage") ? "-stage" : "-dev"); ?>"
//    var environment = "<?php echo (ENVIRONMENT === "Production") ? "-prod" : ((ENVIRONMENT === "Stage") ? "-stage" : "-dev"); ?>"
    var client_id = "<?php echo $client_id; ?>"
</script>

<?php
$baseurlString = BASE_URL_STRING;
?>

<link href="<?php echo BASE_URL_STRING ?>/src/views/css/oriole.css" rel="stylesheet">
<link href="<?php echo S3_STATIC_URL ?>bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo S3_STATIC_URL ?>bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet">

<script src="<?php echo S3_STATIC_URL ?>jquery/jquery-2.1.3.min.js"></script>
<script src="<?php echo S3_STATIC_URL ?>bootstrap-3.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo S3_STATIC_URL ?>bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
<script src="<?php echo BASE_URL_STRING ?>src/views/js/signin.min.js"></script>
<!--<script src="<?php echo BASE_URL_STRING ?>src/views/js/validation.min.js"></script>-->
<script src="<?php echo BASE_URL_STRING ?>src/views/js/validation.js"></script>

<!-- DataTables CSS & JS -->

<script type="text/javascript" src="<?php echo S3_STATIC_URL ?>DataTables/media/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.css"/>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
