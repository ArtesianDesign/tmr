<?php defined('C5_EXECUTE') or die(_('Access Denied.'));
$sd = Loader::helper('sitewide_data');
$pinImg = BASE_URL . DIR_REL . $sd->getPlaceholderFile()->getRelativePath();
?>
<div class="social-share clearfix">
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<ul>
		<li class="twitter">
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		</li>
		<li class="pintrest">
			<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(BASE_URL . DIR_REL); ?>&media=<?php echo urlencode($pinImg); ?>" class="pin-it-button" count-layout="none"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
			<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
		</li>
		<li class="facebook">
			<fb:like send="true" layout="button_count" width="150" show_faces="false"></fb:like>
		</li>
		<li class="gplus">
			<div class="g-plusone" data-size="medium"></div>
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>			
		</li>
	</ul>
</div>
