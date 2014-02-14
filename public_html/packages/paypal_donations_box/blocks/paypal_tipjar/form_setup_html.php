<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); 

$includeAssetLibrary = true; 
$assetLibraryPassThru = array(
	'type' => 'image'
);
	$al = Loader::helper('concrete/asset_library');

$bf = null;

if ($bObj->donateButton_fID > 0) { 
	$bf = File::getByID($bObj->donateButton_fID);
}



?> 
<ul class="ccm-dialog-tabs" id="ccm-paypaltipjar-tabs">
	<li class="ccm-nav-active"><a href="javascript:void(0)" id="ccm-paypaltipjar-required"><?php   echo t('Basic')?></a></li>
	<li><a href="javascript:void(0)" id="ccm-paypaltipjar-optional"><?php   echo t('Advanced')?></a></li>
</ul>

<div id="ccm-paypaltipjar-required-tab"> 
	<div>
        <label><?php  echo t('Paypal Account Email/Merchant ID')?>*</label>
        <input type="text" style="width:90%" name="paypal_user" id="paypal_user" value="<?php  echo $bObj->paypal_user?>"/>
        <div class="ccm-note" style="margin-top:4px;">
            <?php  echo t('Sign up for an account at')?>
            <a href="http://www.paypal.com" target="_blank">paypal.com</a>
        </div>
	</div>
    <div>
        <label><?php  echo t('Item Name')?></label>
        <input type="text" style="width:90%" name="item_name" value="<?php  echo $bObj->item_name?>"/>
    </div>
    <div>
        <label><?php  echo t('Item Number')?></label>
        <input type="text" name="item_number" value="<?php  echo $bObj->item_number?>"/>
    </div>    
</div>
<div id="ccm-paypaltipjar-optional-tab" style="display:none">
	<div>
        <label><?php  echo t('Title')?></label>
        <input type="text" name="title" value="<?php  echo $bObj->title?>"/>
        <div class="ccm-note" style="margin-bottom:4px; margin-top:4px;">
            <?php  echo t('will appear above the donate button')?>
        </div>
    </div>
    <div style="float:left;">
        <label><?php  echo t('Currency Code')?></label>
        <input type="text" name="currency_code" value="<?php  echo $bObj->currency_code?>"/>
        <div class="ccm-note" style="margin-bottom:4px; margin-top:4px;">
        	<a href="https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes" target="_blank"><?php  echo t('valid currency codes')?></a>
        </div>
    </div>
    <div style="float:left; margin-left: 10px;">
        <label><?php  echo t('Currency Symbol')?></label>
        <input type="text" name="currency_symbol" value="<?php  echo $bObj->currency_symbol?>" size="2"/>
    </div>
    <br style="clear:both" />
    <div>
        <label><?php  echo t('Specify Amount(s)')?></label>
        <textarea name="amount"><?php  echo $bObj->amount?></textarea>
        <div class="ccm-note" style="margin-bottom:4px; margin-top:4px;">
            <?php  echo t('enter multiple ammounts on seperate lines');?>
        </div>
    </div>
     
     <div>
        <label><?php  echo t('Button Image')?></label>
        <?php  echo $al->image('ccm-b-image', 'donateButton_fID', t('Choose Image'), $bf);?>
        <div class="ccm-note" style="margin-bottom:4px; margin-top:4px;">
            <?php  echo t('leave blank for standard Paypal donate button')?>
        </div>
    </div>
     
     
     <div>
        <input type="checkbox" name="useSandbox" value="1" <?php  echo ($bObj->useSandbox?"checked=\"checked\"":"")?>/>
        <label style="display:inline"><?php  echo t('Use Paypal Sandbox')?></label>
        <div class="ccm-note" style="margin-bottom:16px; margin-top:4px;">
            will post to use sandbox.paypal.com (for testing)
        </div>
    </div>
</div>


<!-- Tab Setup -->
<script type="text/javascript">
	var ccm_fpActiveTab = "ccm-paypaltipjar-required";	
	$("#ccm-paypaltipjar-tabs a").click(function() {
		$("li.ccm-nav-active").removeClass('ccm-nav-active');
		$("#" + ccm_fpActiveTab + "-tab").hide();
		ccm_fpActiveTab = $(this).attr('id');
		$(this).parent().addClass("ccm-nav-active");
		$("#" + ccm_fpActiveTab + "-tab").show();
	});
</script>