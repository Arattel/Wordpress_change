<?php

if (!defined('ABSPATH'))
    exit();

class AvartanSliderLiteFunctions {

    /**
     * @since 1.3
     * @param string $message message for error
     * @param integer $code
     * @return string throw error
     */
    public static function throwError($message, $code = null) {
        if (!empty($code)) {
            throw new Exception($message, $code);
        } else {
            throw new Exception($message);
        }
    }

    /**
     * get value from array. if not - return alternative
     *
     * @since 1.3
     * @param object|array $arr
     * @param string|integer $key
     * @param string $altVal
     * @return object|array
     */
    public static function getVal($arr, $key, $altVal = "") {
        if (is_array($arr)) {
            if (isset($arr[$key])) {
                return($arr[$key]);
            }
        } elseif (is_object($arr)) {
            if (isset($arr->$key)) {
                return($arr->$key);
            }
        }
        return($altVal);
    }

    /**
     * get value from array. if not - return alternative
     *
     * @since 1.3
     * @param object|array $arr
     * @param string|integer $key
     * @param string|integer $oldkey
     * @param string $altVal
     * @return object|array
     */
    public static function getData($arr, $key, $oldkey = "", $altVal = "") {
        
        if (is_array($arr)) {
            if ($oldkey != '' && isset($arr[$oldkey])) {
                return($arr[$oldkey]);
            } else if (isset($arr[$key])) {
                return($arr[$key]);
            }
        } elseif (is_object($arr)) {
            if ($oldkey != '' && isset($arr->$oldkey)) {
                return($arr->$oldkey);
            } else if (isset($arr->$key)) {
                return($arr->$key);
            }
        }
        return($altVal);
    }

    /**
     * get value from old array. if not - return from new array
     *
     * @since 1.3
     * @param object|array $arr
     * @param string|integer $key
     * @param object|array $oldarr
     * @param string|integer $oldkey
     * @param string $altVal
     * @return object|array
     */
    public static function getDataDetail($arr, $key, $oldarr, $oldkey, $altVal = "") {
        if (is_array($oldarr) && isset($oldarr[$oldkey])) {
            return($oldarr[$oldkey]);
        } elseif (is_object($oldarr) && isset($oldarr->$oldkey)) {
            return($oldarr->$oldkey);
        } elseif (is_array($arr) && isset($arr[$key])) {
            return($arr[$key]);
        } elseif (is_object($arr) && isset($arr->$key)) {
            return($arr->$key);
        }
        return($altVal);
    }
    
    /**
     * get mode value from old array. if not - return mode value from new array
     *
     * @since 1.3
     * @param object|array $arr
     * @param string|integer $key
     * @param string $mode
     * @param object|array $oldarr
     * @param string|integer $oldkey
     * @param string|integer $altVal
     * @return object|array
     */
    public static function getDataMode($arr, $key, $mode, $oldarr, $oldkey, $altVal = "") {
        if (is_array($oldarr) && isset($oldarr[$oldkey]) && !is_array($oldarr[$oldkey])) {
            return($oldarr[$oldkey]);
        } elseif (is_object($oldarr) && isset($oldarr->$oldkey) && !is_object($oldarr[$oldkey])) {
            return($oldarr->$oldkey);
        } elseif (is_array($arr) && isset($arr[$key]) && is_array($arr[$key]) && isset($arr[$key][$mode])) {
            return($arr[$key][$mode]);
        } elseif (is_object($arr) && isset($arr->$key) && is_object($arr->$key) && isset($arr->$key->$mode)) {
            return($arr->$key->$mode);
        }
        return($altVal);
    }
    
    /**
     * set default value if value is blank
     *
     * @since 1.3
     * @param object|array $arr
     * @param string|integer $key
     * @param string|integer $deftVal
     * @return string|integer
     */
    public static function setDeftVal($arr, $key, $deftVal) {
        if (is_array($arr) && isset($arr[$key]) && !is_array($arr[$key]) && trim($arr[$key]) != '') {
            return($arr[$key]);
        } 
        return($deftVal);
    }

    /**
     * validate variable not empty
     *
     * @since 1.3
     * @param integer $val
     * @param string $fieldName
     */
    public static function validateNotEmpty($val, $fieldName = "") {

        if (empty($fieldName))
            $fieldName = "Field";

        if (empty($val) && is_numeric($val) == false)
            self::throwError(__('Field', 'avartan-slider-lite') . " <b>$fieldName</b>" . __('should not be empty', 'avartan-slider-lite'));
    }

    /**
     * Convert std class to array, with all sons
     *
     * @since 1.3
     * @param object $arr
     * @return array $arrNew
     */
    public static function convertStdClassToArray($arr) {
        $arr = (array) $arr;

        $arrNew = array();

        foreach ($arr as $key => $item) {
            if (is_object($item)) {
                $arrNew[$key] = self::convertStdClassToArray($item);
            } elseif (is_array($item)) {
                $arrNew[$key] = self::convertStdClassToArray($item);
            } else {
                $arrNew[$key] = $item;
            }
        }

        return($arrNew);
    }

    /**
     * Convert array to std class, with all sons
     *
     * @since 1.3
     * @param array $arr
     * @return object $arrNew
     */
    public static function convertArrayToStdClass($arr) {
        $arr = (object) $arr;

        $arrNew = array();

        foreach ($arr as $key => $item) {
            $item = (object) $item;
            $arrNew[$key] = $item;
        }

        return($arrNew);
    }

    /**
     * Clean std class to array
     *
     * @since 1.3
     * @param object $arr
     * @return array $arrNew
     */
    public static function cleanStdClassToArray($arr) {
        $arr = (array) $arr;

        $arrNew = array();

        foreach ($arr as $key => $item) {
            $arrNew[$key] = $item;
        }

        return($arrNew);
    }

    /**
     * Encode array into json for client side
     *
     * @since 1.3
     * @param array $arr
     * @return json $json
     */
    public static function jsonEncodeForClientSide($arr) {
        $json = "";
        if (!empty($arr)) {
                $json = wp_json_encode($arr);
            $json = addslashes($json);
        }

        if (empty($json))
            $json = '{}';

        return($json);
    }

    /**
     * Echo json ajax response
     *
     * @since 1.3
     * @param string $success
     * @param string $message
     * @param string $actionName
     * @param string $arrData
     */
    public static function asAjaxRes($success, $message, $actionName = "", $arrData = null) {

        $response = array();
        $response["success"] = $success;

        $response["message"] = $message;

        if (!empty($actionName)) {
            $response["action"] = $actionName;
        }

        if (!empty($arrData)) {

            if (gettype($arrData) == "string")
                $arrData = array("data" => $arrData);

            $response = wp_parse_args($response, $arrData);
        }

        $json = wp_json_encode($response);

        echo $json;
        exit();
    }

    /**
     * Echo json ajax response, without message, only data
     *
     * @since 1.3
     * @param string $actionName
     * @param string $arrData
     */
    public static function asAjaxResData($actionName, $arrData) {
        if (gettype($arrData) == "string")
            $arrData = array("data" => $arrData);

        self::asAjaxRes(true, "", $actionName, $arrData);
    }

    /**
     * Echo json ajax response
     *
     * @since 1.3
     * @param string $message
     * @param string $arrData
     */
    public static function asAjaxResError($message, $arrData = null) {
        self::asAjaxRes(false, $message, "", $arrData, true);
    }

    /**
     * Echo ajax success response
     *
     * @since 1.3
     * @param string $message
     * @param string $actionName
     * @param string $arrData
     */
    public static function asAjaxResSuccess($message, $actionName, $arrData = null) {
        self::asAjaxRes(true, $message, $actionName, $arrData, true);
    }

    /**
     * Echo ajax success response
     *
     * @since 1.3
     * @param string $message
     * @param string $actionName
     * @param string $url
     */
    public static function asAjaxResSuccessRedirect($message, $actionName, $url) {
        $arrData = array("is_redirect" => true, "redirect_url" => $url);
        self::asAjaxRes(true, $message, $actionName, $arrData, true);
    }

    /**
     * get url to some view.
     *
     * @since 1.3
     * @param string $viewName
     * @param string $urlParams
     * @return string $link redirection url
     */
    public static function asGetViewRedirectUrl($viewName = "", $urlParams = "") {
        $params = '';
        if (!empty($viewName)) {
            $params = "&view=" . $viewName;
        }
        if (!empty($urlParams)) {
            $params .= "&" . $urlParams;
        }

        $link = admin_url('admin.php?page=avartanslider' . $params);
        return($link);
    }

    /**
     * get some var from array
     *
     * @since 1.3
     * @param array $arr
     * @param string|integer $key
     * @param string|integer $defaultValue
     * @return string|integer $val
     */
    public static function asgetVar($arr, $key, $defaultValue = "") {
        $val = $defaultValue;
        if (isset($arr[$key]))
            $val = $arr[$key];
        return($val);
    }

    /**
     * get post or get variable
     *
     * @since 1.3
     * @param array $key
     * @param string|integer $defaultValue
     * @return string|integer $val
     */
    public static function asGetPostVar($key, $defaultValue = "") {

        if (array_key_exists($key, $_POST))
            $val = self::asgetVar($_POST, $key, $defaultValue);
        else
            $val = self::asgetVar($_GET, $key, $defaultValue);

        return($val);
    }

    /**
     * Return speed and animation type string
     *
     * @since 1.3
     * @param array $animArray
     * @param string $is
     * @return string $retString
     */
    public static function asLayerAnimationByArray($animArray, $is = 'start') {
        $retString = '';
        if ($is == 'start') {
            $retString .= 's:' . AvartanSliderLiteFunctions::getVal($animArray, 'animation_startspeed', 300) . ';';
            $retString .= 'e:' . AvartanSliderLiteFunctions::getVal($animArray, 'animation_ease_in', 'easeOutExpo') . ';';
        } else {
            $es = AvartanSliderLiteFunctions::getVal($animArray, 'animation_endspeed');
            $ee = trim(AvartanSliderLiteFunctions::getVal($animArray, 'animation_ease_out'));
            if (!empty($es)) {
                $retString .= 's:' . $es . ';';
                if (!empty($ee) && $ee !== 'nothing') {
                    $retString .= 'e:' . $ee . ';';
                }
            }
        }
        return $retString;
    }

    /**
     * get all font family types
     *
     * @since 1.3
     * @return array $fonts array of google fonts
     */
    public static function getArrFontFamilies() {

        //Web Safe Fonts
        $fonts = array(
            //Serif Fonts
            array('type' => 'websafe', 'version' => __('Serif Fonts', 'avartan-slider-lite'), 'label' => 'Georgia, serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Serif Fonts', 'avartan-slider-lite'), 'label' => '"Palatino Linotype", "Book Antiqua", Palatino, serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Serif Fonts', 'avartan-slider-lite'), 'label' => '"Times New Roman", Times, serif', 'status' => false),
            //Sans-Serif Fonts
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => 'Arial, Helvetica, sans-serif', 'status' => true),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => '"Arial Black", Gadget, sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => '"Comic Sans MS", cursive, sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => 'Impact, Charcoal, sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => 'Tahoma, Geneva, sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => '"Trebuchet MS", Helvetica, sans-serif', 'status' => false),
            array('type' => 'websafe', 'version' => __('Sans-Serif Fonts', 'avartan-slider-lite'), 'label' => 'Verdana, Geneva, sans-serif', 'status' => false),
            //Monospace Fonts
            array('type' => 'websafe', 'version' => __('Monospace Fonts', 'avartan-slider-lite'), 'label' => '"Courier New", Courier, monospace', 'status' => false),
            array('type' => 'websafe', 'version' => __('Monospace Fonts', 'avartan-slider-lite'), 'label' => '"Lucida Console", Monaco, monospace', 'status' => false)
        );
        return $fonts;
    }
    
}

if (!function_exists('avartan_let_to_num')) {

    /**
     * @since 1.3
     * @param $size
     * @return int This function transforms the php.ini notation for numbers (like '2M') to an integer.
     */
    function avartan_let_to_num($size) {
        $l = substr($size, -1);
        $ret = substr($size, 0, -1);
        switch (strtoupper($l)) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
    }

}
if (!function_exists('avartan_help_tip')) {

    /**
     * Display a Avartan Slider help tip.
     *
     * @since  1.3
     * @param  string $tip  Help tip text
     * @param  bool   $allow_html Allow sanitized HTML if true or escape
     * @return string
     */
    function avartan_help_tip($tip='', $allow_html = false) {
        if ($allow_html) {
            $tip = avartan_sanitize_tooltip($tip);
        } else {
            $tip = esc_attr($tip);
        }

        return '<span class="avs-help-tip" data-tip="' . $tip . '"></span>';
    }

}
if (!function_exists('avartan_sanitize_tooltip')) {

    /**
     * Sanitize a string destined to be a tooltip.
     *
     * @since 1.3
     * @param string $var
     * @return string
     */
    function avartan_sanitize_tooltip($var) {
        return htmlspecialchars(wp_kses(html_entity_decode($var), array(
            'br' => array(),
            'em' => array(),
            'strong' => array(),
            'small' => array(),
            'span' => array(),
            'ul' => array(),
            'li' => array(),
            'ol' => array(),
            'p' => array(),
        )));
    }

}

/**
 * Display slider
 *
 * @param string $alias slider alias
 */
if (!function_exists('avartanSlider')) {

    function avartanSlider($alias) {
        $shortcode_fun = new AvartansliderLiteShortcode();
        $shortcode_fun->avsSliderOutput($alias, true);
    }

}