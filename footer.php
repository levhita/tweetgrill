    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <?php foreach($scripts as $script): ?>
        <script src="<?php echo $script ?>"></script>
    <?php endforeach;?>
  </body>
</html>
