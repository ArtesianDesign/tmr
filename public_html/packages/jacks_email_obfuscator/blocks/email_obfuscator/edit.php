<?php       defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<div class="ccm-block-field-group">
<h2><?php       echo t('Email Address')?></h2>
<?php       echo $form->text('content', $content, array('style' => 'width: 320px'));?>
</div>
<div class="ccm-block-field-group">
<h2><?php       echo t('Link Text')?></h2>
<?php         echo $form->text('title', $title, array('style' => 'width: 320px'));?>
</div>
<?php      echo t('Link text is what you want the link to your email to be displayed as.')?>

