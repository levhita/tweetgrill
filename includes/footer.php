    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/vendor/jquery-2.2.1.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/bootbox.min.js"></script>
    <script src="/vendor/handlebars-v4.0.5.js"></script>
        
    <?php foreach($scripts as $script): ?>
        <script src="<?php echo $script ?>"></script>
    <?php endforeach;?>
  
  </body>
</html>