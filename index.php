<?php 
//password checking
// include("inc/login/password_protect.php");

INCLUDE "sensitive.php";


if (isset($_GET['linkURL'])){
  include "php/addLink.php";
  echo "<script type='text/javascript'>
    var linksAction = 'linksAdd'; 
    var linkObject = new Object(); 
    linkObject.URL = '$linkURL'; 
    linkObject.Title = '$linkTitle';
    </script>";  
}

elseif (isset($_GET['purge'])){
  exec("curl -v 'http://localhost:8983/solr/linkPad/update/?commit=true' -H 'Content-Type: text/xml' -d '<delete><query>*:*</query></delete>'");
  echo "<script type='text/javascript'>
    var linksAction = 'linksPurge';
    </script>";
  // echo "<span class='text-error'>All links purged.</span>";
}

else{
  echo "<script type='text/javascript'>var linksAction = 'linksShow';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>linkPad</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!--<script src="http://code.jquery.com/jquery.js"></script>-->
    <script type="text/javascript" src="js/linkPad.js"></script>

    <!--Local Overrides to Bootstrap defaults-->
    <link type="text/css" rel="stylesheet" href="css/style.css"/>

    <!--Load Bootstrap-->
    <link href="inc/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="inc/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    

    <!--load upload dependencies-->    
    <!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> -->
    <script src="http://malsup.github.com/jquery.form.js"></script>

    <!--jquery cookie-->
    <script src="js/jquery.cookie.js"></script>

  
  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

    <!--load bootstrap js-->    
    <script src="inc/bootstrap/js/bootstrap.js"></script>

    <!--topbar-->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>          
          <a class="brand" href="./">linkPad (alpha)</a>          
          <div class="nav-collapse collapse">

            <ul class="nav pull-right">
              <!-- <li class="active"><a href="index.php?logout=1">logout</a></li>               -->
              <li style="font-size:10px; color:white; padding-right:10px;"><strong>linkPad bookmarklet: </strong>javascript:(function(){window.location="http://littleguy.grahamhukill.com/linkPad/?linkURL="+document.URL;})();</li>
            </ul>

          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container-fluid">      
      <div class="row-fluid">

        <!--side column *****************************************************************************************************************-->
        <div class="span3" id="side_nav">
          
          <!--sidebar-->
          <!-- <div class="row-fluid">            
            <div class="well sidebar-nav">
              <ul class="nav nav-list">
                <li class=""><a href="/linkPad/">All</a></li>
              </ul>
            </div>
          </div>  -->          

        </div><!--/side column span -->

        <!--content span ****************************************************************************************************************-->
        <div id="mainContent" class="span12">        
        
          <div class="row-fluid">

            <div id="linksShow" class="span8 offset2">              
              <h2 class="text-center">Me Links</h2>
              <form class="form-search text-center" onSubmit="searchLinks(); return false;">
                <input id="searchBox" type="text" class="input-medium search-query input-xxlarge">
                <button type="submit" class="btn">Search</button>
              </form> 
              <div class="results">          
                <ul id="links"></ul>
                <p>
                  <a href="#" onClick="paginate('all'); return false;">first</a>
                  <span>/</span>
                  <a href="#" onClick="paginate('prev'); return false;">prev</a>
                  <span>/</span>
                  <a href="#" onClick="paginate('next'); return false;">next</a>
                  <span>/</span>
                  <a href="#" onClick="paginate('last'); return false;">last</a>
                </p>
              </div>

            </div>

            <!--
            <div id="linksDelete" class="span5">
              <h2 class="text-info">Deleted Links:</h2>              
              <ul id="links"></ul>                           
            </div>
            -->

             <div id="linksManage" class="span8 offset2"></div>             

          </div> <!--closes topView row -->                           
        
        </div><!--content span12-->

      </div> <!--all encompassing row -->

    </div><!--/.fluid-container-->   
    
  </body>

  <script type="text/javascript">
    runLinksAction();
  </script

  
</html>
