<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php $this->inc('_/elements/head.php'); ?>
<?php $this->inc('_/elements/header.php'); ?>

  <div id="row_content" class="row">
    <div id="main_column" class="seven columns">
      <div class="panel">
        <div class="inner">
          <?php if ($cView->heading) echo '<h1>' . $cView->heading . '</h1>'; ?>

          <?php if ($story) { ?>
          <div class="credits">
          	<?php echo t('Submitted by'); ?>
          	<span class="author">
          		<?php if ($story->email) { ?>
          		<a href="mailto:<?php echo $story->email; ?>">
      			<?php } ?>
	          		<?php echo $story->author; ?>
          		<?php if ($story->email) { ?>
	          	</a>
	          	<?php } ?>
          	</span>
          	on <span class="date">
          		<?php echo $story->date; ?>
          	</span>
          </div>
          <?php } // end if story ?>


          <?php if ($story->image) { ?>
          <img class="story-image" src="<?php echo BASE_URL . DIR_REL . $story->image->getRelativePath(); ?>" />
          <?php } // end if story image ?>

          <?php
          $ma = new Area('Main');
          $ma->display($c);
          ?>
        </div>
      </div>
    </div>

    <div id="column_sidebar" class="five columns">
      <?php $this->inc('_/elements/social.php'); ?>
      <?php $this->inc('_/elements/steps.php'); ?>
      <?php
      $sa = new Area('Sidebar');
      $sa->display($c);
      ?>
    </div>
  </div>

<?php $this->inc('_/elements/footer.php'); ?>
<?php $this->inc('_/elements/foot.php'); ?>