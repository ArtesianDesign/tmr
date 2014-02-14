<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php $this->inc('_/elements/head.php'); ?>
<?php $this->inc('_/elements/header.php'); ?>

  <div class="row">
    <div id="main_column" class="eight columns">
      <?php
      $ma = new Area('Main');
      $ma->display($c);
      ?>
    </div>

    <div class="four columns">
      <?php
      $sa = new Area('Sidebar');
      $sa->display($c);
      ?>
    </div>
  </div>

<?php $this->inc('_/elements/footer.php'); ?>
<?php $this->inc('_/elements/foot.php'); ?>

