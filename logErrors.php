<?php if(count($logErrors) > 0) : ?>
 <div>
   <?php foreach($logErrors as $logError) : ?>
     <p><?php echo $logError; ?></p>
   <?php endforeach ?>
  </div>
<?php endif ?>   