<?php
if (!defined('ABSPATH'))
    exit();
?>
<h4><?php _e( 'Slide General Options', 'avartan-slider-lite' ); ?></h4>
<div class="as-action-button">
    <button title="<?php esc_attr_e('Save Slide','avartan-slider-lite'); ?>" class="as-btn as-btn-green as-save-slide" data-slide-id="<?php echo $slide->getID() ?>"><i class="fa fa-save"></i> <span><?php _e( 'Save Slide', 'avartan-slider-lite' ); ?></span></button>
    <button title="<?php esc_attr_e('Preview','avartan-slider-lite'); ?>" class="as-btn as-btn-orange as-preview-slide"><i class="fa fa-search"></i> <span><?php _e( 'Preview', 'avartan-slider-lite' ); ?></span></button>
    <button title="<?php esc_attr_e('Slider Settings','avartan-slider-lite'); ?>" onclick="location.href='?page=avartanslider&view=slider&id=<?php echo $slider->getId(); ?>'" class="as-btn as-btn-blue as-slider-setting"><i class="fa fa-gear"></i> <span><?php _e( 'Slider Settings', 'avartan-slider-lite' ); ?></span></button>
</div>