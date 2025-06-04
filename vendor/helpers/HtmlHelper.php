<?php
class HtmlHelper {
    const helperDirectory = "/helpers/";
    
    public static function processSQLString( $query = ''){
		$patterns = array();
		$patterns[0] = '/\"/';
		$patterns[1] = '/\'/';
		$patterns[2] = '/!/';
		$patterns[3] = '/\$/';
		$patterns[4] = '/%/';
		// $patterns[5] = '/(/';
		// $patterns[6] = '/)/';
		$patterns[5] = '/-/';
		// $patterns[6] = '/;/';
		$patterns[7] = '/=/';
		// $patterns[8] = '/@/';
		// $patterns[9] = '/>/';
		// $patterns[10] = '/</';
		$replacements = array();
		$replacements[0] = '&quot;';
		$replacements[1] = '&#39;';
		$replacements[2] = '&#33;';
		$replacements[3] = '&#36;';
		$replacements[4] = '&#37;';
		// $replacements[5] = '&#40;';
		// $replacements[6] = '&#41;';
		// $replacements[5] = '&#45;'; // - not replace because date has it
		$replacements[5] = '-'; // - not replace because date has it
		// $replacements[6] = '&#59;';
		$replacements[7] = '&#61;';
		// $replacements[8] = '&#64;';
		// $replacements[9] = '&#62;';
		// $replacements[10] = '&#60;';
		$query = preg_replace($patterns, $replacements, $query);
		return $query;
	}
}