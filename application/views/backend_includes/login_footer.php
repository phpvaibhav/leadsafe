    <!--================================================== -->  
    <?php $backend_assets =  base_url().'backend_assets/'; ?><!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
    <script src="<?php echo $backend_assets; ?>js/plugin/pace/pace.min.js"></script>
    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script> if (!window.jQuery) { document.write('<script src="<?php echo $backend_assets; ?>js/libs/jquery-3.2.1.min.js"><\/script>');} </script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $backend_assets; ?>js/libs/jquery-ui.min.js"><\/script>');} </script>
    <!-- IMPORTANT: APP CONFIG -->
    <script src="<?php echo $backend_assets; ?>js/app.config.js"></script>
    <!-- JS TOUCH : include this plugin for mobile drag / drop touch events     
    <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->
    <!-- BOOTSTRAP JS -->   
    <script src="<?php echo $backend_assets; ?>js/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- JQUERY VALIDATE -->
    <script src="<?php echo $backend_assets; ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>
    <!-- JQUERY MASKED INPUT -->
    <script src="<?php echo $backend_assets; ?>js/plugin/masked-input/jquery.maskedinput.min.js"></script>
    <!--[if IE 8]>
    <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
    <![endif]-->
    <!-- MAIN APP JS FILE -->
    <script src="<?php echo $backend_assets; ?>js/app.min.js"></script>
    <script src="<?php echo $backend_assets; ?>admin/js/login.js"></script>
    <script src="<?php echo $backend_assets; ?>custom/js/custom.js"></script>
  </body>
</html>