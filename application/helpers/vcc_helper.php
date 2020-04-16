<?php
if(!function_exists('url_friendly')) {
    function url_friendly($string, $space="-"){
        return sanitizeTitle($string, $space);
    }
}
if(!function_exists('sanitizeTitle')) {
    function sanitizeTitle($string, $space="-") {
        if(!$string) return false;
        $unicode = array(
            '0'    => array('°', '₀', '۰'),
            '1'    => array('¹', '₁', '۱'),
            '2'    => array('²', '₂', '۲'),
            '3'    => array('³', '₃', '۳'),
            '4'    => array('⁴', '₄', '۴', '٤'),
            '5'    => array('⁵', '₅', '۵', '٥'),
            '6'    => array('⁶', '₆', '۶', '٦'),
            '7'    => array('⁷', '₇', '۷'),
            '8'    => array('⁸', '₈', '۸'),
            '9'    => array('⁹', '₉', '۹'),
            'a'    => array('à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'ā', 'ą', 'å', 'α', 'ά', 'ἀ', 'ἁ', 'ἂ', 'ἃ', 'ἄ', 'ἅ', 'ἆ', 'ἇ', 'ᾀ', 'ᾁ', 'ᾂ', 'ᾃ', 'ᾄ', 'ᾅ', 'ᾆ', 'ᾇ', 'ὰ', 'ά', 'ᾰ', 'ᾱ', 'ᾲ', 'ᾳ', 'ᾴ', 'ᾶ', 'ᾷ', 'а', 'أ', 'အ', 'ာ', 'ါ', 'ǻ', 'ǎ', 'ª', 'ა', 'अ', 'ا'),
            'b'    => array('б', 'β', 'Ъ', 'Ь', 'ب', 'ဗ', 'ბ'),
            'c'    => array('ç', 'ć', 'č', 'ĉ', 'ċ'),
            'd'    => array('ď', 'ð', 'đ', 'ƌ', 'ȡ', 'ɖ', 'ɗ', 'ᵭ', 'ᶁ', 'ᶑ', 'д', 'δ', 'د', 'ض', 'ဍ', 'ဒ', 'დ'),
            'e'    => array('é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'ë', 'ē', 'ę', 'ě', 'ĕ', 'ė', 'ε', 'έ', 'ἐ', 'ἑ', 'ἒ', 'ἓ', 'ἔ', 'ἕ', 'ὲ', 'έ', 'е', 'ё', 'э', 'є', 'ə', 'ဧ', 'ေ', 'ဲ', 'ე', 'ए', 'إ', 'ئ'),
            'f'    => array('ф', 'φ', 'ف', 'ƒ', 'ფ'),
            'g'    => array('ĝ', 'ğ', 'ġ', 'ģ', 'г', 'ґ', 'γ', 'ဂ', 'გ', 'گ'),
            'h'    => array('ĥ', 'ħ', 'η', 'ή', 'ح', 'ه', 'ဟ', 'ှ', 'ჰ'),
            'i'    => array('í', 'ì', 'ỉ', 'ĩ', 'ị', 'î', 'ï', 'ī', 'ĭ', 'į', 'ı', 'ι', 'ί', 'ϊ', 'ΐ', 'ἰ', 'ἱ', 'ἲ', 'ἳ', 'ἴ', 'ἵ', 'ἶ', 'ἷ', 'ὶ', 'ί', 'ῐ', 'ῑ', 'ῒ', 'ΐ', 'ῖ', 'ῗ', 'і', 'ї', 'и', 'ဣ', 'ိ', 'ီ', 'ည်', 'ǐ', 'ი', 'इ'),
            'j'    => array('ĵ', 'ј', 'Ј', 'ჯ', 'ج'),
            'k'    => array('ķ', 'ĸ', 'к', 'κ', 'Ķ', 'ق', 'ك', 'က', 'კ', 'ქ', 'ک'),
            'l'    => array('ł', 'ľ', 'ĺ', 'ļ', 'ŀ', 'л', 'λ', 'ل', 'လ', 'ლ'),
            'm'    => array('м', 'μ', 'م', 'မ', 'მ'),
            'n'    => array('ñ', 'ń', 'ň', 'ņ', 'ŉ', 'ŋ', 'ν', 'н', 'ن', 'န', 'ნ'),
            'o'    => array('ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ø', 'ō', 'ő', 'ŏ', 'ο', 'ὀ', 'ὁ', 'ὂ', 'ὃ', 'ὄ', 'ὅ', 'ὸ', 'ό', 'о', 'و', 'θ', 'ို', 'ǒ', 'ǿ', 'º', 'ო', 'ओ'),
            'p'    => array('п', 'π', 'ပ', 'პ', 'پ'),
            'q'    => array('ყ'),
            'r'    => array('ŕ', 'ř', 'ŗ', 'р', 'ρ', 'ر', 'რ'),
            's'    => array('ś', 'š', 'ş', 'с', 'σ', 'ș', 'ς', 'س', 'ص', 'စ', 'ſ', 'ს'),
            't'    => array('ť', 'ţ', 'т', 'τ', 'ț', 'ت', 'ط', 'ဋ', 'တ', 'ŧ', 'თ', 'ტ'),
            'u'    => array('ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'û', 'ū', 'ů', 'ű', 'ŭ', 'ų', 'µ', 'у', 'ဉ', 'ု', 'ူ', 'ǔ', 'ǖ', 'ǘ', 'ǚ', 'ǜ', 'უ', 'उ'),
            'v'    => array('в', 'ვ', 'ϐ'),
            'w'    => array('ŵ', 'ω', 'ώ', 'ဝ', 'ွ'),
            'x'    => array('χ', 'ξ'),
            'y'    => array('ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'ÿ', 'ŷ', 'й', 'ы', 'υ', 'ϋ', 'ύ', 'ΰ', 'ي', 'ယ'),
            'z'    => array('ź', 'ž', 'ż', 'з', 'ζ', 'ز', 'ဇ', 'ზ'),
            'aa'   => array('ع', 'आ', 'آ'),
            'ae'   => array('ä', 'æ', 'ǽ'),
            'ai'   => array('ऐ'),
            'at'   => array('@'),
            'ch'   => array('ч', 'ჩ', 'ჭ', 'چ'),
            'dj'   => array('ђ', 'đ'),
            'dz'   => array('џ', 'ძ'),
            'ei'   => array('ऍ'),
            'gh'   => array('غ', 'ღ'),
            'ii'   => array('ई'),
            'ij'   => array('ĳ'),
            'kh'   => array('х', 'خ', 'ხ'),
            'lj'   => array('љ'),
            'nj'   => array('њ'),
            'oe'   => array('ö', 'œ', 'ؤ'),
            'oi'   => array('ऑ'),
            'oii'  => array('ऒ'),
            'ps'   => array('ψ'),
            'sh'   => array('ш', 'შ', 'ش'),
            'shch' => array('щ'),
            'ss'   => array('ß'),
            'sx'   => array('ŝ'),
            'th'   => array('þ', 'ϑ', 'ث', 'ذ', 'ظ'),
            'ts'   => array('ц', 'ც', 'წ'),
            'ue'   => array('ü'),
            'uu'   => array('ऊ'),
            'ya'   => array('я'),
            'yu'   => array('ю'),
            'zh'   => array('ж', 'ჟ', 'ژ'),
            '(c)'  => array('©'),
            'A'    => array('Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'Å', 'Ā', 'Ą', 'Α', 'Ά', 'Ἀ', 'Ἁ', 'Ἂ', 'Ἃ', 'Ἄ', 'Ἅ', 'Ἆ', 'Ἇ', 'ᾈ', 'ᾉ', 'ᾊ', 'ᾋ', 'ᾌ', 'ᾍ', 'ᾎ', 'ᾏ', 'Ᾰ', 'Ᾱ', 'Ὰ', 'Ά', 'ᾼ', 'А', 'Ǻ', 'Ǎ'),
            'B'    => array('Б', 'Β', 'ब'),
            'C'    => array('Ç', 'Ć', 'Č', 'Ĉ', 'Ċ'),
            'D'    => array('Ď', 'Ð', 'Đ', 'Ɖ', 'Ɗ', 'Ƌ', 'ᴅ', 'ᴆ', 'Д', 'Δ'),
            'E'    => array('É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Ë', 'Ē', 'Ę', 'Ě', 'Ĕ', 'Ė', 'Ε', 'Έ', 'Ἐ', 'Ἑ', 'Ἒ', 'Ἓ', 'Ἔ', 'Ἕ', 'Έ', 'Ὲ', 'Е', 'Ё', 'Э', 'Є', 'Ə'),
            'F'    => array('Ф', 'Φ'),
            'G'    => array('Ğ', 'Ġ', 'Ģ', 'Г', 'Ґ', 'Γ'),
            'H'    => array('Η', 'Ή', 'Ħ'),
            'I'    => array('Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Î', 'Ï', 'Ī', 'Ĭ', 'Į', 'İ', 'Ι', 'Ί', 'Ϊ', 'Ἰ', 'Ἱ', 'Ἳ', 'Ἴ', 'Ἵ', 'Ἶ', 'Ἷ', 'Ῐ', 'Ῑ', 'Ὶ', 'Ί', 'И', 'І', 'Ї', 'Ǐ', 'ϒ'),
            'K'    => array('К', 'Κ'),
            'L'    => array('Ĺ', 'Ł', 'Л', 'Λ', 'Ļ', 'Ľ', 'Ŀ', 'ल'),
            'M'    => array('М', 'Μ'),
            'N'    => array('Ń', 'Ñ', 'Ň', 'Ņ', 'Ŋ', 'Н', 'Ν'),
            'O'    => array('Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ø', 'Ō', 'Ő', 'Ŏ', 'Ο', 'Ό', 'Ὀ', 'Ὁ', 'Ὂ', 'Ὃ', 'Ὄ', 'Ὅ', 'Ὸ', 'Ό', 'О', 'Θ', 'Ө', 'Ǒ', 'Ǿ'),
            'P'    => array('П', 'Π'),
            'R'    => array('Ř', 'Ŕ', 'Р', 'Ρ', 'Ŗ'),
            'S'    => array('Ş', 'Ŝ', 'Ș', 'Š', 'Ś', 'С', 'Σ'),
            'T'    => array('Ť', 'Ţ', 'Ŧ', 'Ț', 'Т', 'Τ'),
            'U'    => array('Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Û', 'Ū', 'Ů', 'Ű', 'Ŭ', 'Ų', 'У', 'Ǔ', 'Ǖ', 'Ǘ', 'Ǚ', 'Ǜ'),
            'V'    => array('В'),
            'W'    => array('Ω', 'Ώ', 'Ŵ'),
            'X'    => array('Χ', 'Ξ'),
            'Y'    => array('Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Ÿ', 'Ῠ', 'Ῡ', 'Ὺ', 'Ύ', 'Ы', 'Й', 'Υ', 'Ϋ', 'Ŷ'),
            'Z'    => array('Ź', 'Ž', 'Ż', 'З', 'Ζ'),
            'AE'   => array('Ä', 'Æ', 'Ǽ'),
            'CH'   => array('Ч'),
            'DJ'   => array('Ђ'),
            'DZ'   => array('Џ'),
            'GX'   => array('Ĝ'),
            'HX'   => array('Ĥ'),
            'IJ'   => array('Ĳ'),
            'JX'   => array('Ĵ'),
            'KH'   => array('Х'),
            'LJ'   => array('Љ'),
            'NJ'   => array('Њ'),
            'OE'   => array('Ö', 'Œ'),
            'PS'   => array('Ψ'),
            'SH'   => array('Ш'),
            'SHCH' => array('Щ'),
            'SS'   => array('ẞ'),
            'TH'   => array('Þ'),
            'TS'   => array('Ц'),
            'UE'   => array('Ü'),
            'YA'   => array('Я'),
            'YU'   => array('Ю'),
            'ZH'   => array('Ж'),
            ' '    => array("\xC2\xA0", "\xE2\x80\x80", "\xE2\x80\x81", "\xE2\x80\x82", "\xE2\x80\x83", "\xE2\x80\x84", "\xE2\x80\x85", "\xE2\x80\x86", "\xE2\x80\x87", "\xE2\x80\x88", "\xE2\x80\x89", "\xE2\x80\x8A", "\xE2\x80\xAF", "\xE2\x81\x9F", "\xE3\x80\x80"),
        );
        $string = trim($string);
        foreach($unicode as $key => $val){
            $string = str_replace($val, $key, $string);
        }
        $special = array('+','”','“',',', '.',':',';',"'",'"','/','!','@','$','%','^','&','*','(',')','=','\\','[',']','?','>','<','{','}');
        $string = str_replace($special, '', $string);

        $string = strtolower($string);
        $string = str_replace("ß", "ss", $string);
        $string = preg_replace("/[^_a-zA-Z0-9 -]/", "", $string);
        $string = str_replace(array('%20', ' '), $space, $string);
        $string = str_replace($space . $space . $space . $space, $space, $string);
        $string = str_replace($space . $space . $space, $space, $string);
        $string = str_replace($space . $space, $space, $string);
        return $string;
    }
    function sanitizeTitleBackup($string, $space = '-'){
        if (!$string) return false;
        $utf8 = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($utf8 as $ascii => $uni) {
            if (preg_match('/[' . $uni . ']/', $string)) {
                $string = preg_replace('/($uni)/i', $ascii, $string);
            }
        }
        $string = strtolower($string);
        $string = str_replace("ß", "ss", $string);
        $string = str_replace("%", "", $string);
        $string = preg_replace("/[^_a-zA-Z0-9 -]/", "", $string);
        $string = str_replace(array('%20', ' '), $space, $string);
        $string = str_replace($space . $space . $space . $space, $space, $string);
        $string = str_replace($space . $space . $space, $space, $string);
        $string = str_replace($space . $space, $space, $string);
        return $string;
    }
}
if(!function_exists('logE')){
    function logE($msg){
        error_log(date('[Y:m:d H:i:s] ') . print_r($msg, true) . "\n", 3, APPPATH.'logs'.DIRECTORY_SEPARATOR.'system-'.date('Y-m-d').'.log');
    }
}
if(!function_exists('vcc_paging')){
    function vcc_paging($total_page, $path='', $param_page='page', $config=array()){
        $config['first_text'] = isset($config['first_text']) ? $config['first_text'] : '<i class="fa fa-angle-double-left"></i>';
        $config['prev_text'] = isset($config['prev_text']) ? $config['prev_text'] : '<i class="fa fa-angle-left"></i>';
        $config['next_text'] = isset($config['next_text']) ? $config['next_text'] : '<i class="fa fa-angle-right"></i>';
        $config['last_text'] = isset($config['last_text']) ? $config['last_text'] : '<i class="fa fa-angle-double-right"></i>';

        $config['first_show'] = isset($config['first_show']) ? $config['first_show'] : true;
        $config['last_show'] = isset($config['last_show']) ? $config['last_show'] : true;
        ?>
        <div class="col-sm-12 col-md-12">
            <div class="dataTables_paginate paging_simple_numbers">
                <ul class="pagination" id="<?php echo isset($config['paging_id']) ? $config['paging_id'] : '';?>">
                    <?php
                    if($total_page>1) {
                        if(isset($config['paged']) && $config['paged']){
                            $page = $config['paged'];
                        }else{
                            $page = isset($_GET[$param_page]) ? $_GET[$param_page] : 1;
                        }
                        $params = '';
                        if($_GET){
                            foreach($_GET as $key=>$val){
                                if($key==$param_page)continue;
                                $params .= ($params ? '&':'?').$key.'='.$val;
                            }
                        }
                        $pre_page = $params ? '&' : '?';

                        if($page<=3){
                            $start = 1;
                            $end = $total_page>=5 ? 5 : $total_page;
                        }else if($page>=($total_page-2) && $page<=$total_page){
                            $start = ($total_page-5)<=1 ? 1 : $total_page-5;
                            $end = $total_page;
                        }else{
                            $start = ($page-2)<=1 ? 1 : ($page-2);
                            $end = ($page+2)>=$total_page ? $total_page : ($page+2);
                        }?>

                        <?php if($page>1){?>
                            <?php if($config['first_show']){?>
                            <li class="paginate_button previous">
                                <a href="<?php
                                echo base_url($path.$params) ?>"><?php echo $config['first_text'];?></a>
                            </li>
                            <?php }?>
                            <li class="paginate_button previous">
                                <a href="<?php
                                $page_prev = $page>2 ? $pre_page.$param_page.'='.($page-1) : '';
                                echo base_url($path.$params.$page_prev) ?>"><?php echo $config['prev_text'];?></a>
                            </li>
                        <?php }?>

                        <?php for ($i = $start; $i <= $end; $i++) {
                            $page_url = $i>1 ? $pre_page.$param_page.'='.$i : '';
                            ?>
                            <li class="paginate_button<?php if ($page == $i){echo ' active';} ?>"><a href="<?php
                                echo base_url($path.$params.$page_url) ?>"><?php echo $i;?></a></li>
                        <?php }?>

                        <?php if($page<$total_page){?>
                            <li class="paginate_button next">
                                <a href="<?php
                                $page_next = $page<$total_page ? $param_page.'='.($page+1) : '';
                                echo base_url($path.$params.$pre_page.$page_next)
                                ?>"><?php echo $config['next_text'];?></a>
                            </li>
                            <?php if($config['last_show']){?>
                            <li class="paginate_button previous">
                                <a href="<?php
                                echo base_url($path.$params.$pre_page.$param_page.'='.$total_page) ?>"><?php echo $config['last_text'];?></a>
                            </li>
                            <?php }?>
                        <?php }?>
                    <?php }?>
                </ul>
            </div>
        </div>
    <?php }
}
if(!function_exists('post_data')){
    function post_data($name, $data=null, $def=null){
        if(isset($_POST[$name])){
            $CI =& get_instance();
            $val = $CI->input->post($name);
            return is_string($val) ? htmlentities($val) : $val;
        }else{
            if($data && isset($data->$name)){
                return is_string($data->$name) ? htmlentities($data->$name) : $data->$name;
            }else{
                return $def;
            }
        }
    }
}
if(!function_exists('get_data')){
    function get_data($name, $data, $def=null){
        if(isset($_GET[$name])){
            $CI =& get_instance();
            $val = $CI->input->get($name);
            return is_string($val) ? htmlentities($val) : $val;
        }else{
            if(isset($data)&&!empty($data)){
                return is_string($data->$name) ? htmlentities($data->$name) : $data->$name;
            }else{
                return $def;
            }
        }
    }
}
if(!function_exists('is_mobile')) {
    function is_mobile(){
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}
if(!function_exists('get_meta_robot')){
    function get_meta_robot(){
        return array(
            'index, follow',
            'index, nofollow',
            'noindex, follow',
            'noindex, follow',
            'noindex, nofollow'
        );
    }
}

if(!function_exists('get_current_url')){
    function get_current_url(){
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}

if(!function_exists('get_time_ago')){
    function get_time_ago($datetime, $full = false){
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'năm',
            'm' => 'tháng',
            'w' => 'tuần',
            'd' => 'ngày',
            'h' => 'giờ',
            'i' => 'phút',
            's' => 'giây',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' trước' : 'just now';
    }
}

if(!function_exists('get_thumbnail_url')){
    function get_thumbnail_url($path, $w=0, $h=0, $more_param=''){
        if(!$path) return '';
        if(strpos($path, 'http')!==false){
            return $path.$more_param;
        }
        if(substr($path, 0, 1)==='/'){
            $path = substr($path, 1);
        }
        $full_url = base_url($path);
        //$full_path = str_replace( base_url('/'), FCPATH, $full_url);
        //if(file_exists($full_path)===false) return '';
        if($w && $h){
            $info = pathinfo($path);
            $new_name = $info['filename'].'-'.$w.'x'.$h.'.'.$info['extension'];
            $new_path = str_replace($info['basename'], $new_name, $path);
            if(file_exists(FCPATH.$new_path)===false){
                return $full_url.$more_param;
            }
            return base_url($new_path.$more_param);
        }else{
            return $full_url.$more_param;
        }
    }
}
if(!function_exists('get_label_source_type')){
    function get_label_source_type($type){
        $arg = array(
            'ali' => 'Aliexpress',
            'amazon' => 'Amazon',
            'dhgate' => 'DH Gate',
            'ebay' => 'Ebay'
        );
        return isset($arg[$type]) ? $arg[$type] : '';
    }
}
if(!function_exists('get_ebay_sites')){
    function get_ebay_sites(){
        $arg = array(
            0 => 'ebay.com',
            2 => 'ebay.ca',
            3 => 'ebay.co.uk',
            71 => 'ebay.fr',
            77 => 'ebay.de',
            101 => 'ebay.it',
            186 => 'ebay.es',
            203 => 'ebay.in'
        );
        return $arg;
    }
}


if(!function_exists('get_countries')){
    function get_countries(){
        return array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua And Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia And Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros',
            'CG' => 'Congo',
            'CD' => 'Congo, Democratic Republic',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote D\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FK' => 'Falkland Islands (Malvinas)',
            'FO' => 'Faroe Islands',
            'FJ' => 'Fiji',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island & Mcdonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran, Islamic Republic Of',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle Of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyzstan',
            'LA' => 'Lao People\'s Democratic Republic',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia, Federated States Of',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Netherlands',
            'AN' => 'Netherlands Antilles',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory, Occupied',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts And Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre And Miquelon',
            'VC' => 'Saint Vincent And Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome And Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia And Sandwich Isl.',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard And Jan Mayen',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad And Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks And Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'UM' => 'United States Outlying Islands',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Viet Nam',
            'VG' => 'Virgin Islands, British',
            'VI' => 'Virgin Islands, U.S.',
            'WF' => 'Wallis And Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe',
        );
    }
}
if(!function_exists('get_shipping_service_code')){
    function get_shipping_service_code(){
        return array(
            "NotSelected"=>"-",
            'Economy services' => array(
                "USPSParcel"=>"USPS Parcel Select Ground (2 to 9 business days)", "USPSMedia"=>"USPS Media Mail (2 to 8 business days)", "FedExSmartPost"=>"FedEx SmartPost (2 to 8 business days)", "USPSStandardPost"=>"USPS Retail Ground (2 to 9 business days)", "Other"=>"Economy Shipping (1 to 10 business days)", "US_UPSSurePost"=>"UPS Surepost (1 to 6 business days)", "US_DGMSmartMailGround"=>"DGM SmartMail Ground (3 to 8 business days)"
            ),
            'Standard services' => array(
                "USPSFirstClass"=>"USPS First Class Package (2 to 3 business days)", "FedExHomeDelivery"=>"FedEx Ground or FedEx Home Delivery (1 to 5 business days)", "UPSGround"=>"UPS Ground (1 to 5 business days)", "ShippingMethodStandard"=>"Standard Shipping (1 to 5 business days)", "US_DGMSmartMailExpedited"=>"DGM SmartMail Expedited (2 to 5 business days)"
            ),
            'Expedited services' => array(
                "USPSPriority"=>"USPS Priority Mail (1 to 3 business days)", "ShippingMethodExpress"=>"Expedited Shipping (1 to 3 business days)", "USPSPriorityFlatRateEnvelope"=>"USPS Priority Mail Flat Rate Envelope (1 to 3 business days)", "USPSPriorityMailSmallFlatRateBox"=>"USPS Priority Mail Small Flat Rate Box (1 to 3 business days)", "USPSPriorityFlatRateBox"=>"USPS Priority Mail Medium Flat Rate Box (1 to 3 business days)", "USPSPriorityMailLargeFlatRateBox"=>"USPS Priority Mail Large Flat Rate Box (1 to 3 business days)", "USPSPriorityMailPaddedFlatRateEnvelope"=>"USPS Priority Mail Padded Flat Rate Envelope (1 to 3 business days)", "USPSPriorityMailLegalFlatRateEnvelope"=>"USPS Priority Mail Legal Flat Rate Envelope (1 to 3 business days)", "USPSExpressMail"=>"USPS Priority Mail Express (1 business day)", "USPSExpressFlatRateEnvelope"=>"USPS Priority Mail Express Flat Rate Envelope (1 business day)", "USPSExpressMailLegalFlatRateEnvelope"=>"USPS Priority Mail Express Legal Flat Rate Envelope (1 business day)", "UPS3rdDay"=>"UPS 3 Day Select (3 business days)", "UPS2ndDay"=>"UPS 2nd Day Air (2 business days)", "FedExExpressSaver"=>"FedEx Express Saver (1 to 3 business days)", "FedEx2Day"=>"FedEx 2Day (1 to 2 business days)"
            ),
            'One-day services' => array(
                "ShippingMethodOvernight"=>"One-day Shipping (1 business day)", "UPSNextDay"=>"UPS Next Day Air Saver (1 business day)", "UPSNextDayAir"=>"UPS Next Day Air (1 business day)", "FedExPriorityOvernight"=>"FedEx Priority Overnight (1 business day)", "FedExStandardOvernight"=>"FedEx Standard Overnight (1 business day)"
            ),
            'Economy services from outside US' => array(
                "EconomyShippingFromOutsideUS"=>"Economy Shipping from outside US (11 to 23 business days)", "US_EconomyShippingFromGC"=>"Economy SpeedPAK from China/Hong Kong/Taiwan (10 to 15 business days)", "US_EconomyShippingFromIN"=>"Economy Shipping from India (8 to 13 business days)", "US_MailServiceFromIndia"=>"Mail Service from India (14 to 27 business days)"
            ),
            'Standard services from outside US' => array(
                "StandardShippingFromOutsideUS"=>"Standard Shipping from outside US (5 to 10 business days)", "US_StandardShippingFromGC"=>"Standard SpeedPAK from China/Hong Kong/Taiwan (8 to 12 business days)", "US_StandardShippingFromIN"=>"Standard Shipping from India (5 to 12 business days)"
            ),
            'Expedited services from outside US' => array(
                "ExpeditedShippingFromOutsideUS"=>"Expedited Shipping from outside US (1 to 4 business days)", "US_FedExIntlEconomy"=>"FedEx International Economy (2 to 4 business days)", "US_ExpeditedShippingFromGC"=>"Expedited SpeedPAK from China/Hong Kong/Taiwan (5 to 9 business days)", "US_ExpeditedShippingFromIN"=>"Expedited Shipping from India (3 to 9 business days)"
            ),
            'Freight' => array(
                "FlatRateFreight"=>"Flat Rate Freight"
            )
        );
    };
}
if(!function_exists('get_handling_time_data')){
    function get_handling_time_data(){
        return array(
            '0' => 'Same business day',
            '1' => '1 business day',
            '2' => '2 business days',
            '3' => '3 business days',
            '4' => '4 business days',
            '5' => '5 business days',
            '10' => '10 business days',
            '15' => '15 business days',
            '20' => '20 business days',
            '30' => '30 business days'
        );
    }
}
if(!function_exists('get_duration_data')){
    function get_duration_data(){
        return array(
            'Days_3' => '3 days',
            'Days_5' => '5 days',
            'Days_7' => '7 days',
            'Days_10' => '10 days',
            'Days_30' => '30 days',
            'GTC' => 'Good Til Cancelled'
        );
    }
}
if(!function_exists('get_price_sell')){
    function get_price_sell($price, $profit=2){
        $price_sell = ( 0.3 + floatval($price) + $profit ) / 0.861;
        return number_format($price_sell, 2);
    }
}

