<?php
if (!defined('ABSPATH'))
    exit();
?>
<ul class="as-slide-tabs as-sortable">
    <input type="hidden" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" class="as-slide-id">
    <input type="hidden" value="<?php echo $slide->getSliderId(); ?>" class="as-slider-id">
    <?php
    if ($edit) {
        $j = 1;
        $slides_num = count($slides);
        foreach ($slides as $slide_single) {
            $all_slide_data = maybe_unserialize($slide_single->getParams());
            
            $slide_name = __('Slide', 'avartan-slider-lite');
            $slide_id = $slide_single->getID();
            
            //Background
            $bg_options = AvartanSliderLiteFunctions::getVal($all_slide_data,'background',array());
            $bgtype = AvartanSliderLiteFunctions::getVal($bg_options,'type','transparent');
            $style = $slide_single->avsGetSlideBG($all_slide_data);
            
            $slide_publish = 'as-publish';
            $slide_title = __('Publish','avartan-slider-lite');
            $visible_class = 'fa-eye';
            $act_class = '';
            
            if($slide_id == $id) {
                $act_class = 'as-active';
            }
            ?>
            <li class="as-slide-tab-block as-sorting-li <?php echo $act_class; ?>">
                <a href="<?php echo '?page=avartanslider&view=slide&id='.$slide_id; ?>">
                    <div <?php echo $style; ?> class="as-slide-tab-img <?php if( $style != '' ) echo "bgtype_".$bgtype; ?>">
                        <div class="as-slide-action-left">
                            <button id="visibility_as_slide_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-slide-visibility as-pro-version <?php echo $slide_publish; ?>" title="<?php echo $slide_title; ?>">
                                <span class="fa <?php echo $visible_class; ?>"></span>
                            </button>
                        </div>
                        <div class="as-slide-action">                            
                            <span class="as-animation-rightToLeft">
                                <button id="delete_as_slide_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-delete-slide" title="<?php esc_attr_e('Delete Slide', 'avartan-slider-lite'); ?>">
                                    <span class="fa fa-trash"></span>
                                </button>
                                <button id="duplicate_as_slide_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-duplicate-slide as-pro-version <?php echo ($slide_id==0) ? 'as-is-disabled' : ''; ?>" title="<?php esc_attr_e('Duplicate Slide', 'avartan-slider-lite'); ?>">
                                    <span class="fa fa-paste"></span>
                                </button>
                                <button id="copy_move_as_slide_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-copy-move-slide as-pro-version <?php echo ($slide_id==0) ? 'as-is-disabled' : ''; ?>" title="<?php esc_attr_e('Copy & Move', 'avartan-slider-lite'); ?>">
                                    <span class="fa fa-share-square-o"></span>
                                </button>
                                <button id="export_as_slide_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-export-slide as-pro-version <?php echo ($slide_id==0) ? 'as-is-disabled' : ''; ?>" title="<?php esc_attr_e('Export', 'avartan-slider-lite'); ?>">
                                    <span class="fa fa-upload"></span>
                                </button>
                            </span>
                        </div>                        
                    </div>
                </a>
                <div class="as-slide-tab-name">
                    <div class="as-serial-no border-right">#<?php echo $j; ?></div>
                    <input type="text" class="as-slide-name-text as-pro-version" readonly="readonly" value="<?php echo $slide_name; ?>" />
                    <div class="as-slide-action">
                        <button id="slide_save_<?php echo $slide_id; ?>" class="as-btn as-slide-tab-btn as-save-slide-name as-pro-version" title="Save Slide">
                            <span class="fa fa-edit"></span>
                        </button>
                    </div>
                </div>
            </li>
            <?php
            $j++;
        }
    }
    ?>
    <li class="as-slide-tab-block as-create-new-slide">
        <div class="as-create-new-slide-icon">
            <span class="fa fa-plus"></span>
        </div>
        <div class="as-create-new-slide-title">
            <?php _e('Add New Slide', 'avartan-slider-lite'); ?>
        </div>
    </li>
</ul>