<?php
include_once 'log.class.php';
include_once 'SDKConfig.php';
// ³õÊ¼»¯ÈÕÖ¾
$log = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
/**
 * Êý×é ÅÅÐòºó×ª»¯Îª×ÖÌå´®
 *
 * @param array $params        	
 * @return string
 */
function coverParamsToString($params) {
	$sign_str = '';
	// ÅÅÐò
	ksort ( $params );
	foreach ( $params as $key => $val ) {
		if ($key == 'signature') {
			continue;
		}
		$sign_str .= sprintf ( "%s=%s&", $key, $val );
		// $sign_str .= $key . '=' . $val . '&';
	}
	return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
}
/**
 * ×Ö·û´®×ª»»Îª Êý×é
 *
 * @param unknown_type $str        	
 * @return multitype:unknown
 */
function coverStringToArray($str) {
	$result = array ();

	if (! empty ( $str )) {
		$temp = preg_split ( '/&/', $str );
		if (! empty ( $temp )) {
			foreach ( $temp as $key => $val ) {
				$arr = preg_split ( '/=/', $val, 2 );
				if (! empty ( $arr )) {
					$k = $arr ['0'];
					$v = $arr ['1'];
					$result [$k] = $v;
				}
			}
		}
	}
	return $result;
}
/**
 * ´¦Àí·µ»Ø±¨ÎÄ ½âÂë¿Í»§ÐÅÏ¢ , Èç¹û±àÂëÎªGBK Ôò×ªÎªutf-8
 *
 * @param unknown_type $params        	
 */
function deal_params(&$params) {
	/**
	 * ½âÂë customerInfo
	 */
	if (! empty ( $params ['customerInfo'] )) {
		$params ['customerInfo'] = base64_decode ( $params ['customerInfo'] );
	}
	
	if (! empty ( $params ['encoding'] ) && strtoupper ( $params ['encoding'] ) == 'GBK') {
		foreach ( $params as $key => $val ) {
			$params [$key] = iconv ( 'GBK', 'UTF-8', $val );
		}
	}
}

/**
 * Ñ¹ËõÎÄ¼þ ¶ÔÓ¦java deflate
 *
 * @param unknown_type $params        	
 */
function deflate_file(&$params) {
	global $log;
	foreach ( $_FILES as $file ) {
		$log->LogInfo ( "---------´¦ÀíÎÄ¼þ---------" );
		if (file_exists ( $file ['tmp_name'] )) {
			$params ['fileName'] = $file ['name'];
			
			$file_content = file_get_contents ( $file ['tmp_name'] );
			$file_content_deflate = gzcompress ( $file_content );
			
			$params ['fileContent'] = base64_encode ( $file_content_deflate );
			$log->LogInfo ( "Ñ¹ËõºóÎÄ¼þÄÚÈÝÎª>" . base64_encode ( $file_content_deflate ) );
		} else {
			$log->LogInfo ( ">>>>ÎÄ¼þÉÏ´«Ê§°Ü<<<<<" );
		}
	}
}

/**
 * ´¦Àí±¨ÎÄÖÐµÄÎÄ¼þ
 *
 * @param unknown_type $params        	
 */
function deal_file($params) {
	global $log;
	if (isset ( $params ['fileContent'] )) {
		$log->LogInfo ( "---------´¦ÀíºóÌ¨±¨ÎÄ·µ»ØµÄÎÄ¼þ---------" );
		$fileContent = $params ['fileContent'];
		
		if (empty ( $fileContent )) {
			$log->LogInfo ( 'ÎÄ¼þÄÚÈÝÎª¿Õ' );
		} else {
			// ÎÄ¼þÄÚÈÝ ½âÑ¹Ëõ
			$content = gzuncompress ( base64_decode ( $fileContent ) );
			$root = SDK_FILE_DOWN_PATH;
			$filePath = null;
			if (empty ( $params ['fileName'] )) {
				$log->LogInfo ( "ÎÄ¼þÃûÎª¿Õ" );
				$filePath = $root . $params ['merId'] . '_' . $params ['batchNo'] . '_' . $params ['txnTime'] . 'txt';
			} else {
				$filePath = $root . $params ['fileName'];
			}
			$handle = fopen ( $filePath, "w+" );
			if (! is_writable ( $filePath )) {
				$log->LogInfo ( "ÎÄ¼þ:" . $filePath . "²»¿ÉÐ´£¬Çë¼ì²é£¡" );
			} else {
				file_put_contents ( $filePath, $content );
				$log->LogInfo ( "ÎÄ¼þÎ»ÖÃ >:" . $filePath );
			}
			fclose ( $handle );
		}
	}
}

/**
 * ¹¹Ôì×Ô¶¯Ìá½»±íµ¥
 *
 * @param unknown_type $params        	
 * @param unknown_type $action        	
 * @return string
 */
function create_html($params, $action) {
	$encodeType = isset ( $params ['encoding'] ) ? $params ['encoding'] : 'UTF-8';
	$html = <<<eot
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset={$encodeType}" />
</head>
<body  onload="javascript:document.pay_form.submit();">
    <form id="pay_form" name="pay_form" action="{$action}" method="post">
	
eot;
	foreach ( $params as $key => $value ) {
		$html .= "    <input type=\"hidden\" name=\"{$key}\" id=\"{$key}\" value=\"{$value}\" />\n";
	}
	$html .= <<<eot
    <input type="submit" type="hidden">
    </form>
</body>
</html>
eot;
	return $html;
}

?>