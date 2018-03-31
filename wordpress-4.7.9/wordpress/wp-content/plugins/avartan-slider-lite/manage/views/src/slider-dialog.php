<?php
if (!defined('ABSPATH'))
    exit();
?>
<!--Delete Slider Dialog-->
<div id="dialog_delete_slider_confirm" title="<?php esc_attr_e('Delete Slider?', 'avartan-slider-lite'); ?>" class="as-delete-dialog">
    <span><i class="fa fa-exclamation-triangle as-danger"></i> <?php _e('This slider will be permanently deleted and cannot be recovered. Are you sure?', 'avartan-slider-lite'); ?></span>
</div>

<!--Delete Slide Dialog-->
<div id="dialog_delete_slide_confirm" title="<?php esc_attr_e('Delete Slide?', 'avartan-slider-lite'); ?>" class="as-delete-dialog">
    <span><i class="fa fa-exclamation-triangle as-danger"></i> <?php _e('This slide will be permanently deleted and cannot be recovered. Are you sure?', 'avartan-slider-lite'); ?></span>
</div>

<?php
if( isset($_GET['view']) && $_GET['view'] == 'slide' ){
?>
<!--Preview Slide Dialog-->
<div id="dialog_preview_slide" title="<?php esc_attr_e('Preview Slide', 'avartan-slider-lite'); ?>">
    <div class="as-preview-button as-text-center">
        <button class="as-btn as-btn-primary as-slider-preview-desktop as-active"><span class="fa fa-desktop"></span></button>        
        <button class="as-btn as-btn-primary as-slider-preview-mobile as-pro-version"><span class="fa fa-mobile"></span></button>
        <input class="as-slider-h" value="" type="hidden" />
    </div>
    <div class="as-slide-live-preview-area"></div>
</div>
<?php
}
?>