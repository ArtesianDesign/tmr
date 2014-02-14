<?php      
defined('C5_EXECUTE') or die(_("Access Denied."));
$emailAddress=str_rot13 ("$content") ; ?>
<br />
<script type="text/javascript">
document.write("<n uers=\"znvygb:<?php       echo $emailAddress; ?>\" ery=\"absbyybj\">".replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+13)?c:c-26);}));
</script><div class="mailto-link"><noscript><div class="hide"></noscript><?php       echo $title; ?><noscript></div></noscript></div></a>
<noscript>
<?php  
$id = "<span style=\"display:none;\">";
$id.= uniqid();
$id.= "</span>"; 
$emailOrig = array("@");
$emailTo = array("$id@");
echo str_replace($emailOrig, $emailTo, $content);
?>
</noscript>
