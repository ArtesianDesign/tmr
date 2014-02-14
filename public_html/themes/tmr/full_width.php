<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>
<?php if (!$_REQUEST['ajax']) { ?>
<?php $this->inc('_/elements/head.php'); ?>
<?php $this->inc('_/elements/header.php'); ?>

  <div id="row_content" class="row">
    <div id="main_column" class="twelve columns">
      <div class="panel">
        <div class="inner">
          <?php if ($cView->heading) echo '<h1>' . $cView->heading . '</h1>'; ?>
          <?php } ?>
          <?php
          $ma = new Area('Main');
          $ma->display($c);
          ?>
          <?php if (!$_REQUEST['ajax']) { ?>
        </div>
      </div>
    </div>
  </div>

<?php $this->inc('_/elements/footer.php'); ?>
<?php $this->inc('_/elements/foot.php'); ?>
<?php } ?>