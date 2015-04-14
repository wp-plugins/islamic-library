<?php
/* 
 * Array and functions
 * Author: IslamHouse.com
 * Since: 1.0
*/

$language_code = array("af","ak","az","bm","lr","kd","bs","ca","cj","da","de","en","es","fr","ha","rw","id","it","jo","sw","cd","lg","hu","mg","md","ms","mos","nl","sj","or","pl","pt","aa","ro","sq","sk","sl","sx","so","sv","tl","tz","tk","tr","vi","wo","yo","ny","xh","zu","lv","lt","ff","sg","tm","cs","el","uz","bg","inh","ky","mk","ce","ru","sr","tt","tg","uk","av","hy","he","is","nk","et","ug","ur","bh","ba","ka","sd","ci","ar","gh","gm","fa","fl","ir","fi","kk","cm","ks","ku","mn","ps","dv","ne","mr","hi","as","bn","gu","ta","te","kn","ml","si","th","my","ti","am","km","zh","ja","ko");
$language_section = array("showall", "books", "articles", "fatwa", "videos", "quran", "poster", "cards", "programsv", "favorites", "news", "apps");

function islamic_library_words($k=''){

if ( get_option( 'WPLANG' ) == 'ar'){
$word['title'] = 'المكتبة الإسلامية';
$word['home'] = 'الرئيسية';
$word['error'] = 'خطأ';
$word['copy'] = 'انسخ الكود وضعه في المقال او الصفحة';
$word['select'] = 'اختر اللغة:';
$word['Languages'] = 'اللغات:';
$word['Language'] = 'اللغة:';
$word['if_empty'] = 'إذا كان الحقل فارغا فسيتم كتابة اسم الإذاعة تلقائيا.';
$word['options'] = 'الخيارات:';
$word['player_height'] = 'إرتفاع المشغل.';
$word['video_view'] = 'عرض الفيديو بالمشغل';
$word['view_breadcrumb'] = 'عرض المسار الكامل للمادة';
$word['section'] = 'الأقسام:';
$word['update_options'] = 'تحديث';
$word['description'] = 'الوصف:';
$word['source'] = 'المصدر:';
$word['translated'] = 'اللغة مترجمة:';
$word['prepared'] = 'الإعداد:';
$word['attachments'] = 'المرفقات:';
$word['this_page_translated'] = 'الصفحة مترجمة إلى:';
$word['author'] = 'المؤلف:';
$word['page'] = 'الصفحة:';
$word['from'] = 'من';
$word['size'] = 'الحجم:';
$word['section_name'] = 'القسم:';
$word['items'] = 'عدد المواد:';
$word['shortcode'] = 'الكود:';
}else{
$word['title'] = 'Islamic Library';
$word['home'] = 'Home';
$word['error'] = 'Error ID!';
$word['copy'] = 'Copy shortcode and past in post or page';
$word['select'] = 'Select language:';
$word['Languages'] = 'Languages:';
$word['Language'] = 'Language:';
$word['if_empty'] = 'if empty will write title.';
$word['options'] = 'Options:';
$word['player_height'] = 'Player height.';
$word['video_view'] = 'Allow video player';
$word['view_breadcrumb'] = 'Allow breadcrumb';
$word['section'] = 'Sections:';
$word['update_options'] = 'Update options';
$word['description'] = 'Description:';
$word['source'] = 'Source:';
$word['translated'] = 'Translated language:';
$word['prepared'] = 'Prepared by:';
$word['attachments'] = 'Attachments:';
$word['this_page_translated'] = 'This page translated into:';
$word['author'] = 'Author:';
$word['page'] = 'Page:';
$word['from'] = 'From';
$word['size'] = 'Size:';
$word['section_name'] = 'Section:';
$word['items'] = 'Items count:';
$word['shortcode'] = 'Shortcode:';
}
return $word[$k];
}

function islamic_library_get_content($url=""){
$json_url = file_get_contents($url);
return $json_url;
}

function islamic_library_get_json_decode($url=""){
$json_url = islamic_library_get_content($url);
$json_data = json_decode($json_url);
return $json_data;
}

function islamic_library_json_view($url=""){
global $post, $language_section;
$ID = $post->ID;
$permalink = post_permalink( $ID );

$language_info = islamic_library_language_info();

if(isset($_GET['type']) && $_GET['type'] != ""){
$type_data = $_GET['type'];
}else{
$type_data = '';
}

if (in_array($type_data, $language_section)){
$section = strip_tags($type_data);
}else{
$section = 'showall';
}

$item = islamic_library_get_json_decode($url);
$postinfo = $item;
$source_id = intval($postinfo->source_id);
$add_date = $postinfo->add_date;

if($section == $postinfo->type){
	$output = '<ol class="breadcrumb">
	  <li><a href="'.home_url().'">'.islamic_library_words('home').'</a></li>
	  <li><a href="'.$permalink.'">'.ucfirst($section).'</a></li>
	  <li class="active">'.htmlEntities($postinfo->title).'</li>
	</ol>';
	
	if($postinfo->image == ""){
		$image = trailingslashit(plugins_url(null,__FILE__)).'/icons/'.$section.'.png';
	}else{
		$image = htmlEntities($postinfo->image);
	}
	
	//$source = 'http://islamhouse.com/'.htmlEntities($postinfo->source_language).'/'.$postinfo->type.'/'.$source_id.'/';
	//$main_source = 'http://islamhouse.com/'.htmlEntities($postinfo->source_language).'/main/';
	
	$source = 'http://plaintruth.org/'.htmlEntities($postinfo->source_language).'/'.$postinfo->type.'/'.$source_id.'/';
	$main_source = 'http://plaintruth.org/'.htmlEntities($postinfo->source_language).'/main/';

	$output .= '<div class="media">';
	$output .= '<div class="media-body">';
	$output .= '<h4 class="media-heading"><a target="_blank" href="'.$source.'">'.htmlEntities($postinfo->title).'</a></h4>';
	$output .= '<ul>';
	if($postinfo->description != ""){
	$output .= '<li><span>'.islamic_library_words('description').'</span> '.htmlEntities($postinfo->description).'</li>';
	}
	$output .= '<li><span>'.islamic_library_words('language').'</span> <a target="_blank" href="'.$main_source.'">'.$language_info[$postinfo->source_language][1].'</a></li>';
	if($postinfo->translated_language != ""){
	$output .= '<li><span>'.islamic_library_words('translated').'</span> '.htmlEntities($postinfo->translated_language).'</li>';
	}

	/*
    if (is_array($postinfo->prepared_by)){
    $output .= '<li>'.islamic_library_words('prepared').'';
	    $output .= '<ul>';
		    foreach ($postinfo->prepared_by as $postinfox1) {
			    $output .= '<li>ID: '.$postinfox1->id.'</li>';
			    $output .= '<li>Source id: '.$postinfox1->source_id.'</li>';
			    $output .= '<li>Title: '.htmlEntities($postinfox1->title).'</li>';
			    $output .= '<li>Type: '.htmlEntities($postinfox1->type).'</li>';
			    $output .= '<li>Kind: '.htmlEntities($postinfox1->kind).'</li>';
			    $output .= '<li>Description: '.htmlEntities($postinfox1->description).'</li>';
		    }
		$output .= '</ul>';
	$output .= '</li>';
	}else{
	$output .= '';
	}
	*/
	
	if (is_array($postinfo->attachments)){
    $output .= '<li><span>'.islamic_library_words('attachments').'</span>';
	    $output .= '<ul>';
		    foreach ($postinfo->attachments as $postinfo2) {
			    $order = $postinfo2->order;
			    $size = $postinfo2->size;
			    $extension_type = $postinfo2->extension_type;
			    $file_url = htmlEntities($postinfo2->url);
			    
			    if($extension_type == "MP3"){
			    $icon = 'mp3.png';
			    $file_view = '';
				}elseif($extension_type == "PDF"){
				$icon = 'pdf.png';
				$file_view = '';
				}elseif($extension_type == "DOCX"){
				$icon = 'doc.png';
				$file_view = '';
				}elseif($extension_type == "DOC"){
				$icon = 'doc.png';	
				$file_view = '';
				}elseif($extension_type == "MP4"){
				$icon = 'mp4.png';
				if(get_option('islamic_library_video_view') == 'on'){ 
				$file_view = '<video style="width:100%;" controls>
				  <source src="'.$file_url.'" type="video/mp4">
				Your browser does not support the video tag.
				</video>';
				}else{
				$file_view = '';
				}
				}elseif($extension_type == "YOUTUBE"){
				$icon = 'youtube.png';
				if(get_option('islamic_library_video_view') == 'on'){ 
				$file_view = '<iframe style="width:100%;" src="'.$file_url.'" frameborder="0" allowfullscreen></iframe>';
				}else{
				$file_view = '';
				}
				}elseif($extension_type == "LINK"){
				$icon = 'link.png';
				$file_view = '';
				}elseif($extension_type == "JPG"){
				$icon = 'image.png';
				$file_view = '';
				}elseif($extension_type == "PNG"){
				$icon = 'image.png';
				$file_view = '';
				}elseif($extension_type == "PPTX"){
				$icon = 'ppt.png';
				$file_view = '';
				}elseif($extension_type == "PPT"){
				$icon = 'ppt.png';
				$file_view = '';
				}elseif($extension_type == "PPS"){
				$icon = 'pps.png';
				$file_view = '';
				}elseif($extension_type == "RAR"){
				$icon = 'rar.png';
				$file_view = '';
				}elseif($extension_type == "ZIP"){
				$icon = 'zip.png';
				$file_view = '';
				}elseif($extension_type == "EPUB"){
				$icon = 'zip.png';
				$file_view = '';
				}else{
				$icon = 'other.png';
				$file_view = '';
				}
			    $output .= '<li>'.$order.'- <a target="_blank" href="'.$file_url.'" title="'.htmlEntities($postinfo2->description).' '.islamic_library_words('size').' '.$size.'"><img src="'.trailingslashit(plugins_url(null,__FILE__)).'/icons/'.$icon.'" alt="'.$file_url.'" /> ...'.substr($file_url, -50).'</a>'.$file_view.'</li>';
		    }
		$output .= '</ul>';
	$output .= '</li>';
	}else{
	$output .= '';
	}
	
	$output .= '<li><span>'.islamic_library_words('source').'</span> <a target="_blank" href="'.$source.'">'.$source.'</a></li>';
	$output .= '</ul>';
	
	if($postinfo->full_description == ""){
	$output .= '';
	}else{	
	$output .= '<p>'.$postinfo->full_description.'</p>';
	}
	
    $output .= '<p>'.islamic_library_words('this_page_translated').' ';
    			$view_locales = '';
		    foreach ($postinfo->locales as $postinfo3 => $v) {
		    	$params = array( 'item_id' => $source_id, 'language_code' => $v, 'type' => htmlEntities($postinfo->type) );
				$postlink = add_query_arg( $params, $permalink );
			    $view_locales .= '<a href="'.$postlink.'">'.$language_info[$v][1].'</a>, ';
		    }
		    $output .= rtrim($view_locales,', ');
	$output .= '</p>';
	
	$output .= '</div>';
	//$output .= '<div class="media-right media-middle"><a href="#"><img class="media-object" src="'.$image.'" alt="'.htmlEntities($postinfo->title).'" /></a></div>';
	$output .= '</div>';

}else{
$output = 'Error';
}
return $output;
}

function islamic_library_json_content($code_type=""){
global $post, $language_code, $language_section;

$ID = $post->ID;
$permalink = post_permalink( $ID );

if(isset($_GET['item_id']) && $_GET['item_id'] != 0 && isset($_GET['language_code']) && $_GET['language_code'] != "" ){
	if (in_array($_GET['language_code'], $language_code)){
	$lang = strip_tags($_GET['language_code']);
	}else{
	$lang = 'en';
	}
	
$output = islamic_library_json_view('http://api.plaintruth.org/v1/nWjV8rPMoKcbqkw9/main/get-item/'.intval($_GET['item_id']).'/'.$lang.'/json');	
//$output = islamic_library_json_view('http://api.islamhouse.com/v1/paV29H2gm56kvLPy/main/get-item/'.intval($_GET['item_id']).'/'.$lang.'/json');	
}else{
	
$type = explode(":", $code_type);
$type_language = $type[0];
$type_data = $type[1];

if (in_array($type_language, $language_code)){
$lang = strip_tags($type_language);
}else{
$lang = 'en';
}

if (in_array($type_data, $language_section)){
$section = strip_tags($type_data);
}else{
$section = 'showall';
}

$url = 'http://api.plaintruth.org/v1/nWjV8rPMoKcbqkw9/main/'.$section.'/'.$lang.'/'.$lang.'/1/25/json';
//$url = 'http://api.islamhouse.com/v1/paV29H2gm56kvLPy/main/'.$section.'/'.$lang.'/'.$lang.'/1/25/json';

$language_info = islamic_library_language_info();

$item = islamic_library_get_json_decode($url);
$pagination = islamic_library_json_info($url, $lang);

$output = $pagination;
$x=0;

foreach ($item->data as $postinfo) {
	++$x;
	if($postinfo->image == ""){
		$image = trailingslashit(plugins_url(null,__FILE__)).'/icons/'.$section.'.png';
	}else{
		$image = htmlEntities($postinfo->image);
	}
	
	//$source = 'http://islamhouse.com/'.htmlEntities($postinfo->source_language).'/'.$postinfo->type.'/'.$postinfo->id.'/';
	$source = 'http://plaintruth.org/'.htmlEntities($postinfo->source_language).'/'.$postinfo->type.'/'.$postinfo->id.'/';
	
	$params = array( 'item_id' => $postinfo->id, 'language_code' => htmlEntities($postinfo->source_language), 'type' => htmlEntities($postinfo->type) );
	$postlink = add_query_arg( $params, $permalink );
	
	if($postinfo->title == ""){
	$output .= '';
	}else{
	$output .= '<div class="media">';
	
	$output .= '<div class="media-body">';
	$output .= '<h4 class="media-heading"><a href="'.$postlink.'">'.htmlEntities($postinfo->title).'</a></h4>';
	$output .= '<ul>';
	$output .= '<li><span>'.islamic_library_words('description').'</span> '.htmlEntities($postinfo->description).'</li>';
	$output .= '<li><span>'.islamic_library_words('language').'</span> '.$language_info[$lang][1].'</li>';
	//$output .= '<li><span>'.islamic_library_words('translated').'</span> '.htmlEntities($postinfo->translated_language).'</li>';
    if (is_array($postinfo->prepared_by)){
	    		$authors = '';
		    foreach ($postinfo->prepared_by as $postinfox1) {
			    $Prepared_id = $postinfox1->id;
			    $Prepared_source_id = $postinfox1->source_id;
			    $Prepared_title = htmlEntities($postinfox1->title);
			    $Prepared_type = htmlEntities($postinfox1->type);
			    $Prepared_kind = htmlEntities($postinfox1->kind);
			    $Prepared_description = htmlEntities($postinfox1->description);
			    if($Prepared_description == ""){
			    $Prepared_desc = $Prepared_title;
			    }else{
			    $Prepared_desc = $Prepared_description;
			    }
				if($Prepared_title == ""){
				$authors .= '';
				}else{
			    //$authors .= '<a target="_blank" title="'.$Prepared_desc.'" href="http://islamhouse.com/'.$lang.'/author/'.$Prepared_id.'/">'.$Prepared_title.'</a>, ';
			    $authors .= '<a target="_blank" title="'.$Prepared_desc.'" href="http://plaintruth.org/'.$lang.'/author/'.$Prepared_id.'/">'.$Prepared_title.'</a>, ';
			    }
		    }
	if($authors != ""){
	$output .= '<li><span>'.islamic_library_words('author').'</span> '.rtrim($authors,', ').'</li>';
	}
	}else{
	$output .= '';
	}
	$output .= '<li><span>'.islamic_library_words('source').'</span> <a target="_blank" href="'.$source.'">'.$source.'</a></li>';
	$output .= '</ul>';
	$output .= '</div>';
	if($postinfo->image != ""){
	$output .= '<div class="media-right media-middle"><a href="'.$postlink.'"><img class="media-object" src="'.$image.'" alt="'.htmlEntities($postinfo->title).'" /></a></div>';
	}
	$output .= '</div>';
	/*
	if (is_array($postinfo->attachments)){
    $output .= '<li>Attachments:';
	    $output .= '<ul>';
		    foreach ($postinfo->attachments as $postinfo2) {
			    $output .= '<li>Order: '.$postinfo2->order.'</li>';
			    $output .= '<li>Size: '.$postinfo2->size.'</li>';
			    $output .= '<li>Extension type: '.$postinfo2->extension_type.'</li>';
			    $output .= '<li>Description: '.htmlEntities($postinfo2->description).'</li>';
			    $output .= '<li>URL: '.htmlEntities($postinfo2->url).'</li>';
		    }
		$output .= '</ul>';
	$output .= '</li>';
	}else{
	$output .= '';
	}
    $output .= '<li>Locales:';
    			$view_locales = '';
		    foreach ($postinfo->locales as $postinfo3 => $v) {
			    $view_locales .= ''.$v.',';
		    }
		    $output .= rtrim($view_locales,',');
	$output .= '</li>';
    $output .= '</ul>';
    */
}
}
$output .= $pagination;
}
return $output;
}

function islamic_library_json_info($url="", $language_code="", $options=0){
global $post, $language_section, $_GET;

$ID = $post->ID;
$permalink = post_permalink( $ID );

$item = islamic_library_get_json_decode($url);
$postinfo = $item->links;

$json_next = $postinfo->next;
$json_prev = $postinfo->prev;
$json_first = $postinfo->first;
$json_last = $postinfo->last;
$json_current_page = $postinfo->current_page;
$json_pages_number = $postinfo->pages_number;
$json_total_items = $postinfo->total_items;

if(isset($_GET['page_number']) &&  $_GET['page_number'] > $json_pages_number){
$json_pages_number = 1;
}
	
if($json_pages_number == 1){
$output = '';
}else{
$output = '<nav>';
$output .= '<ul class="pagination">';
$select = ''.islamic_library_words('page').' <select name="forma" onchange="location = this.options[this.selectedIndex].value;">';
for($i=1; $i <= $json_pages_number; ++$i){
$link_json = preg_replace('/\/[0-9]+\/25\/json$/' , '/'.$i.'/25/json', $url);
$params = array( 'page_number' => $i );
$postlink = add_query_arg( $params, $permalink );

if(isset($_GET['page_number']) &&  $_GET['page_number'] == $i){
$output .= '<li class="active"><a href="#">'.$i.' <span class="sr-only"></span></a></li>';
}else{
$output .= '<li><a href="'.$postlink.'">'.$i.'</a></li>';
}

if(isset($_GET['page_number']) &&  $_GET['page_number'] == $i){
$select .= '<option value="#" selected="selected">'.$i.'</option>';
}else{
$select .= '<option value="'.$postlink.'">'.$i.'</option>';
}
    
}
$output .= '</ul>';
$output .= '</nav>';
$select .= '</select> '.islamic_library_words('from').' '.$json_pages_number.'';
}

if($json_pages_number > 12){
return $select;
}else{
return $output;
}
}


function islamic_library_get_language_code(){
global $language_code;

if (in_array(get_option('islamic_library_language_code'), $language_code)){
$json_link = strip_tags(get_option('islamic_library_language_code'));
}else{
$json_link = 'en';
}
//$code = islamic_library_get_json_decode('http://api.islamhouse.com/v1/soF6Fs60IjX4C2EA/main/sitecontent/'.$json_link.'/'.$json_link.'/json');
$code = islamic_library_get_json_decode('http://api.plaintruth.org/v1/nWjV8rPMoKcbqkw9/main/sitecontent/'.$json_link.'/'.$json_link.'/json');
return $code;
}

function islamic_library_get_language_section(){
global $language_code;

$language_info = islamic_library_language_info();

$item = islamic_library_get_language_code();

if (in_array(get_option('islamic_library_language_code'), $language_code)){
$language_code = strip_tags(get_option('islamic_library_language_code'));
}else{
$language_code = 'en';
}

$output = '<div class="sections">
<h2>'.islamic_library_words('section').'</h2>
<p>'.islamic_library_words('Language').' '.$language_info[$language_code][1].'</p>
<ul>';
foreach ($item as $postinfo) {
$output .= '<li>';
$output .= '<strong>'.islamic_library_words('section_name').'</strong> <span>'.ucfirst($postinfo->block_name).'</span><br />';
$output .= '<strong>'.islamic_library_words('items').'</strong> '.$postinfo->items_count.'<br />';
$output .= '<strong>'.islamic_library_words('shortcode').'</strong> <span class="shortcode">[section]'.$language_code.':'.$postinfo->block_name.'[/section]</span>';
$output .= '</li>';//'.$postinfo->api_url.'
}
$output .= '</ul>
<div style="clear:both;"></div>
<p>'.islamic_library_words('copy').'</p>
</div>';
return $output;
}

function islamic_library_language_code(){
global $language_code;

$language_info = islamic_library_language_info();
$language_count = count($language_code);
						
$code = '<select name="islamic_library_language_code" id="islamic_library_language_code">';
for($i=0; $i < $language_count; ++$i){
if(get_option('islamic_library_language_code') == $language_code[$i]){
$code .= '<option value="'.$language_code[$i].'" title="'.$language_code[$i].'" selected="selected">'.$language_code[$i].': '.$language_info[$language_code[$i]][1].'</option>';
}else{
$code .= '<option value="'.$language_code[$i].'" title="'.$language_code[$i].'">'.$language_code[$i].': '.$language_info[$language_code[$i]][1].'</option>';
}
}
$code .= '</select>';
return $code;
}

function islamic_library_language_info(){
$lang_info['af'] = array('395643', 'Afrikaans', 'af');
$lang_info['ak'] = array('727491', 'Akan', 'ak');
$lang_info['az'] = array('9357', 'Azəri', 'az');
$lang_info['bm'] = array('420189', 'Bamanankan', 'bm');
$lang_info['lr'] = array('415138', 'Bassa', 'lr');
$lang_info['kd'] = array('717397', 'Bi zimanê Kurdî', 'kd');
$lang_info['bs'] = array('9815', 'Bosanski', 'bs');
$lang_info['ca'] = array('10363', 'Català', 'ca');
$lang_info['cj'] = array('532135', 'Cham', 'cj');
$lang_info['da'] = array('10193', 'Dansk', 'da');
$lang_info['de'] = array('9508', 'Deutsch', 'de');
$lang_info['en'] = array('9661', 'English', 'en');
$lang_info['es'] = array('9584', 'Español', 'es');
$lang_info['fr'] = array('10283', 'Français', 'fr');
$lang_info['ha'] = array('10446', 'Hausa', 'ha');
$lang_info['rw'] = array('717231', 'Ikinyarwanda', 'rw');
$lang_info['id'] = array('10523', 'Indonesia', 'id');
$lang_info['it'] = array('9660', 'Italiano', 'it');
$lang_info['jo'] = array('717367', 'Jóola', 'jo');
$lang_info['sw'] = array('10273', 'Kiswahili', 'sw');
$lang_info['cd'] = array('415159', 'Lingala', 'cd');
$lang_info['lg'] = array('10603', 'Luganda', 'lg');
$lang_info['hu'] = array('10444', 'Magyar', 'hu');
$lang_info['mg'] = array('448881', 'Malagasy', 'mg');
$lang_info['md'] = array('448859', 'Mandinka', 'md');
$lang_info['ms'] = array('10369', 'Melayu', 'ms');
$lang_info['mos'] = array('795002', 'Mõõré', 'mos');
$lang_info['nl'] = array('156524', 'Nederlands', 'nl');
$lang_info['sj'] = array('260358', 'Norwegian', 'sj');
$lang_info['or'] = array('9583', 'Oromoo', 'or');
$lang_info['pl'] = array('9890', 'Polski', 'pl');
$lang_info['pt'] = array('9737', 'Português', 'pt');
$lang_info['aa'] = array('717188', 'Qafár af', 'aa');
$lang_info['ro'] = array('10269', 'Română', 'ro');
$lang_info['sq'] = array('9507', 'Shqip', 'sq');
$lang_info['sk'] = array('191571', 'Slovenčina', 'sk');
$lang_info['sl'] = array('174573', 'Slovenščina', 'sl');
$lang_info['sx'] = array('420298', 'Soninke', 'sx');
$lang_info['so'] = array('10277', 'Soomaaliga', 'so');
$lang_info['sv'] = array('10274', 'Svenska', 'sv');
$lang_info['tl'] = array('10044', 'Tagalog', 'tl');
$lang_info['tz'] = array('10599', 'Tamazight', 'tz');
$lang_info['tk'] = array('395824', 'Türkmen', 'tk');
$lang_info['tr'] = array('9969', 'Türkçe', 'tr');
$lang_info['vi'] = array('10360', 'Việt Nam', 'vi');
$lang_info['wo'] = array('450488', 'Wolof', 'wo');
$lang_info['yo'] = array('10521', 'Yorùbá', 'yo');
$lang_info['ny'] = array('727527', 'chiCheŵa', 'ny');
$lang_info['xh'] = array('734646', 'isiXhosa', 'xh');
$lang_info['zu'] = array('10270', 'isiZulu', 'zu');
$lang_info['lv'] = array('330666', 'latviešu', 'lv');
$lang_info['lt'] = array('420211', 'lietuvių', 'lt');
$lang_info['ff'] = array('10359', 'pulla', 'ff');
$lang_info['sg'] = array('450280', 'sängö', 'sg');
$lang_info['tm'] = array('378819', 'tamashaq', 'tm');
$lang_info['cs'] = array('193273', 'Česky', 'cs');
$lang_info['el'] = array('10522', 'Ελληνικά', 'el');
$lang_info['uz'] = array('9432', 'Ўзбек', 'uz');
$lang_info['bg'] = array('9738', 'Български', 'bg');
$lang_info['inh'] = array('799090', 'ГӀалгӀай', 'inh');
$lang_info['ky'] = array('10679', 'Кыргызча', 'ky');
$lang_info['mk'] = array('10368', 'Македонски', 'mk');
$lang_info['ce'] = array('10275', 'Нохчийн', 'ce');
$lang_info['ru'] = array('10194', 'Русский', 'ru');
$lang_info['sr'] = array('532111', 'Српски', 'sr');
$lang_info['tt'] = array('9967', 'Татарча', 'tt');
$lang_info['tg'] = array('10278', 'Тоҷикӣ', 'tg');
$lang_info['uk'] = array('193295', 'Українська', 'uk');
$lang_info['av'] = array('727575', 'авар мацӀ', 'av');
$lang_info['hy'] = array('391608', 'Հայերեն', 'hy');
$lang_info['he'] = array('10279', 'עברית', 'he');
$lang_info['is'] = array('371088', 'آيسلندي', 'is');
$lang_info['nk'] = array('10601', 'أنكو', 'nk');
$lang_info['et'] = array('193448', 'إستوني', 'et');
$lang_info['ug'] = array('10604', 'ئۇيغۇرچە', 'ug');
$lang_info['ur'] = array('9358', 'اردو', 'ur');
$lang_info['bh'] = array('9736', 'براهوئي', 'bh');
$lang_info['ba'] = array('322925', 'بلوشي', 'ba');
$lang_info['ka'] = array('371119', 'جورجي', 'ka');
$lang_info['sd'] = array('10271', 'سنڌي', 'sd');
$lang_info['ci'] = array('196559', 'شركسي', 'ci');
$lang_info['ar'] = array('9207', 'عربي', 'ar');
$lang_info['gh'] = array('10280', 'غجري', 'gh');
$lang_info['gm'] = array('10281', 'غموقي', 'gm');
$lang_info['fa'] = array('10282', 'فارسى', 'fa');
$lang_info['fl'] = array('10358', 'فلاتي', 'fl');
$lang_info['ir'] = array('9658', 'فلبيني مرناو', 'ir');
$lang_info['fi'] = array('193412', 'فنلندي', 'fi');
$lang_info['kk'] = array('10361', 'قازاقي', 'kk');
$lang_info['cm'] = array('10362', 'قمري', 'cm');
$lang_info['ks'] = array('10364', 'كاشُر', 'ks');
$lang_info['ku'] = array('90552', 'كوردی', 'ku');
$lang_info['mn'] = array('371065', 'منغولي', 'mn');
$lang_info['ps'] = array('10602', 'پښتو', 'ps');
$lang_info['dv'] = array('329606', 'ދިވެހި ބަސް', 'dv');
$lang_info['ne'] = array('10443', 'नेपाली', 'ne');
$lang_info['mr'] = array('734773', 'मराठी', 'mr');
$lang_info['hi'] = array('10445', 'हिन्दी', 'hi');
$lang_info['as'] = array('808888', 'অসমীয়া', 'as');
$lang_info['bn'] = array('9739', 'বাংলা', 'bn');
$lang_info['gu'] = array('734801', 'ગુજરાતી', 'gu');
$lang_info['ta'] = array('9891', 'தமிழ்', 'ta');
$lang_info['te'] = array('10118', 'తెలుగు', 'te');
$lang_info['kn'] = array('413848', 'ಕನ್ನಡ', 'kn');
$lang_info['ml'] = array('10370', 'മലയാളം', 'ml');
$lang_info['si'] = array('10272', 'සිංහල', 'si');
$lang_info['th'] = array('9892', 'ไทย', 'th');
$lang_info['my'] = array('9814', 'ဗမာစာ', 'my');
$lang_info['ti'] = array('9968', 'ትግረኛ', 'ti');
$lang_info['am'] = array('10600', 'አማርኛ', 'am');
$lang_info['km'] = array('408087', 'ភាសាខ្មែរ', 'km');
$lang_info['zh'] = array('9282', '中文', 'zh');
$lang_info['ja'] = array('10447', '日本語', 'ja');
$lang_info['ko'] = array('10365', '한국어', 'ko');
return $lang_info;
}
?>