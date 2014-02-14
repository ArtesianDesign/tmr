<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php $this->inc('_/elements/head.php'); ?>
<?php $this->inc('_/elements/header.php'); ?>

  <div id="row_content" class="row">
    <div id="main_column" class="seven columns">
      <div class="panel">
        <div class="inner">
          <?php echo $innerContent; ?>
        </div>
      </div>
    </div>

    <div id="column_sidebar" class="five columns">
      <?php $this->inc('_/elements/social.php'); ?>
      <?php 
        $ss = Stack::getByName('Sidebar');
        $ss->display($c);
      ?>
      <?php
      $sa = new Area('Sidebar');
      $sa->display($c);
      ?>
    </div>
  </div>

<?php $this->inc('_/elements/footer.php'); ?>
<?php $this->inc('_/elements/foot.php'); ?>