<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BV KIT</title>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW"/>
<?php require_once(APPPATH . 'views/css-page.php'); ?>
</head>
<body class="light_theme   fixed_header left_nav_fixed">
<div class="wrapper">
  <!--\\\\\\\ wrapper Start \\\\\\-->
 <?php require_once(APPPATH . 'views/top-bar.php'); ?>
  <!--\\\\\\\ header end \\\\\\-->
  <div class="inner">
    <!--\\\\\\\ inner start \\\\\\-->
   <?php require_once(APPPATH . 'views/left-menu.php'); ?>
    <!--\\\\\\\left_nav end \\\\\\-->
    <div class="contentpanel">
      <!--\\\\\\\ contentpanel start\\\\\\-->
      <script language="javascript" type="text/javascript">
                                function resizeIframe(obj) {
                                    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                                    // obj.style.width = obj.contentWindow.document.body.scrollHeight + 'px';
                                }
                            </script>
                            <iframe id="frame" name="frame" frameborder="no" border="0" onload="resizeIframe(this)" scrolling="no"  style="padding: 10px; min-height:600px;" width="100%" class="span12" src="<?php echo base_url() . "index.php/task/add"; ?>"> </iframe>         

    </div>
    <!--\\\\\\\ content panel end \\\\\\-->
  </div>
  <!--\\\\\\\ inner end\\\\\\-->
</div>
<!--\\\\\\\ wrapper end\\\\\\-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Compose New Task</h4>
      </div>
      <div class="modal-body"> content </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- sidebar chats -->
<?php require_once(APPPATH . 'views/side-chat.php'); ?>
<!-- /sidebar chats -->

<?php require_once(APPPATH . 'views/js-page.php'); ?>

</body>
</html>
