<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
    <footer>
    	<div id="row_footer" class="row">
      	<div class="twelve columns">
        	<?php
        	$f = new GlobalArea('Footer');
        	$f->display($c);
        	?>
        </div>
      </div>
      <div class="row">
        <div id="copyright" class="twelve columns legal">
          &copy; <?php echo date('Y') . ' ' . SITE ?>. All rights reserved.
        </div>
      </div>
      <div class="row">
        <div id="credit" class="twelve columns legal">
          <p>Web site design and web development donated by <a href="http://artesiandesigninc.com">Artesian Design Inc</a> of Riverside, CA</p>
        </div>
      </div>
    </footer>
    
  </div><!-- #wrapper -->