<textarea name="gdpr_header" rows="5" cols="40">
<?php if($content!=""){?>
<?= _x($content, 'gdpr-framework');?>
<?php }else{ ?>
<?= _x('Cookies used on the website!', 'gdpr-framework');?>
<?php } ?>
</textarea>
<p class="description">
<?= _x("Leave blank if don't want header to get display.", 'gdpr-framework');?>
</p>
