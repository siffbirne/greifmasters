<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<script src="<?= PAGE_ROOT ?>/javascripts/prototype.js" type="text/javascript"></script>
<script src="<?= PAGE_ROOT ?>/javascripts/jquery-1.4.1.min.js" type="text/javascript"></script>
<script src="<?= PAGE_ROOT ?>/javascripts/scriptaculous.js" type="text/javascript"></script>
<!--<script src="<?= PAGE_ROOT ?>/javascripts/display.js" type="text/javascript"></script>-->
<script src="<?= PAGE_ROOT ?>/javascripts/time.js" type="text/javascript"></script>
<script>jQuery.noConflict();</script>


<title><?= $page_title ?></title>
<!-- add your meta tags here -->

<link href="<?= PAGE_ROOT ?>/css/my_layout.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<link href="<?= PAGE_ROOT ?>/css/patches/patch_my_layout.css" rel="stylesheet" type="text/css" />
<![endif]-->
</head>
<body>
  <div class="page_margins">
    <!-- start: skip link navigation -->
    <a class="skip" title="skip link" href="#navigation">Skip to the navigation</a><span class="hideme">.</span>
    <a class="skip" title="skip link" href="#content">Skip to the content</a><span class="hideme">.</span>
    <!-- end: skip link navigation -->
    <div class="page">
      <div id="header">&nbsp;
      </div>
      <div id="main">
        <div id="col1">
          <div id="col1_content" class="clearfix">
            <?= $col1_content ?>
          </div>
        </div>
        <div id="col2">
          <div id="col2_content" class="clearfix">
            
          </div>
        </div>
        <div id="col3">
          <div id="col3_content" class="clearfix">
            <?= $col2_content ?>
          </div>
          <!-- IE Column Clearing -->
          <div id="ie_clearing"> &#160; </div>
        </div>
      </div>
      <div id="footer"><?= $page_footer ?></a>
      </div>
    </div>
  </div>
</body>
</html>
																																																																																																																																																						