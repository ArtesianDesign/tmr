<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<?php $u = new User(); ?>

  <?php if (!$u->isRegistered()) { ?>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/jquery.js"></script>
  <?php } ?>
  
  <?php if (1) { //hack to easily toggle this section on/off ?>
  <!-- Included Foundation JS Files (Uncompressed) -->
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/jquery.foundation.mediaQueryToggle.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/jquery.foundation.forms.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/jquery.foundation.reveal.js"></script>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/jquery.foundation.clearing.js"></script>
  <?php } ?>

  <!-- Included Foundation JS Files (Compressed) -->
  <?php /* TO DO: minify the above */ ?>
  <?php if (0) { //hack to easily toggle this section on/off ?>
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/foundation.min.js"></script>
  <?php } ?>

  <!-- Initialize Foundation JS Plugins -->
  <script src="<?php echo $this->getThemePath(); ?>/_/js/libs/foundation/app.js"></script>
  
  <!-- Site-specific JS -->
	<script src="<?php echo $this->getThemePath(); ?>/_/js/plugins.js"></script>
	<script src="<?php echo $this->getThemePath(); ?>/_/js/script.js"></script>

	<?php Loader::element('footer_required'); ?>
</body>
</html>