<?php
	/********************************************
	* Custom FilChaud/FrenchFoam functions      *
	********************************************/

	function isLogged()
	{
		return (isset($_SESSION['id']) && $_SESSION['id'])? true : false;
	}

	function isAdmin()
	{
	    if (isset($_SESSION["key"]) and $_SESSION["key"] == ADMIN_KEY) 
	        return true;
	    else 
	        return false;
		//return ($_SESSION["key"] == ADMIN_KEY);
	}

	function getLang()
	{
	    if (isset($_GET['lang']) and ($_GET['lang'] == 'en' || $_GET['lang'] == 'fr')) 
	        return  $_GET['lang'];
	    else
	        return $_SESSION['lang'];
		//return ($_GET['lang'] == 'en' || $_GET['lang'] == 'fr')? $_GET['lang'] : $_SESSION['lang'];
	}

 	// Thanks to Stephan Schmitz (eyecatchup@gmail.com) for this function!
	function parse_yturl($url)
	{
	    $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
	    preg_match($pattern, $url, $matches);
	    return (isset($matches[1]))? $matches[1] : false;
	}

	/********************************************
	* Common and Template related functions     *
	********************************************/
	function debug($var, $die = true)
	{
		echo '<pre>';
		print_r($var);
		echo '</pre>';
		if ($die)
			die();
	}

	function render($page, $vars = null)
	{
		global $categories;
		global $cmsPages;
		if ($vars) {
			extract($vars);
		}
		include('tpl-'.getLang().'/head.php');
		include('tpl-'.getLang().'/header.php');
		include('tpl-'.getLang().'/'.$page.'.php');
		include('tpl-'.getLang().'/foot.php');
		die();
	}

	function getVar($varName, $noHtml = true)
	{
	    if (isset($_POST[$varName])) 
	       $retour = $_POST[$varName];
	    elseif (isset($_GET[$varName]))
	       $retour = $_GET[$varName];
	    else 
	       $retour = false;
	    
		if ($noHtml)
		    return htmlentities(strip_tags($retour));
			//return htmlentities(strip_tags((isset($_POST[$varName]))?$_POST[$varName]:$_GET[$varName]));
		else
		    return $retour;
			//return (isset($_POST[$varName]))?$_POST[$varName]:$_GET[$varName];
	}

	/********************************************
	* Folders/files related functions           *
	********************************************/

	function delDir($dir)
	{
		$files = array_diff(scandir($dir), array('.','..'));
		foreach ($files as $file)
			(is_dir($dir.'/'.$file))? delDir($dir.'/'.$file) : unlink($dir.'/'.$file);
		return rmdir($dir);
	}

	/********************************************
	* Crypt/Password related functions          *
	********************************************/
	function genPassword($length = 9)
	{
		$password = '';
		$possible = '012346789abcdfghjkmnpqrtvwxyzABCDFGHJKLMNPQRTVWXYZ!@#$^&*()+=[]{}|.,';
		for ($i = 0;$i < $length;$i++)
		{
		  $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
		  $password .= $char;
		}
		return $password;
	}

	function passwordHash($plain)
	{
		return hash('sha1', SALT.$plain);
	}

	// Thanks Derek Woods for this one
	function aesEncrypt($var)
	{
		return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, AES_KEY, str_pad($val, (16*(floor(strlen($val) / 16)+1)), chr(16-(strlen($var) % 16))),
			MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM));
	}

	function aesDecrypt($var)
	{
		return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, AES_KEY, $var, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,
			MCRYPT_MODE_ECB), MCRYPT_DEV_URANDOM)), "\0..\16");
	}

	/********************************************
	* Network related functions                 *
	********************************************/
	function getCurl($url)
	{
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $url);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  $data = curl_exec($ch);
	  curl_close($ch);
	  return $data;
	}

	/********************************************
	* Text/Date formating functions             *
	********************************************/
	// Thanks Zachary Johnson for this one
	function timeAgo($time)
	{
	    $timestamp = time()-$time;
	    if ($timestamp < 1)
	        return 'Now';
	    foreach (array(31104000 => 'year', 2592000 => 'month', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second') as $secs => $str)
	        if ($timestamp/$secs >= 1)
	            return round($timestamp/$secs).' '.$str.(($r > 1)?'s':'').' ago';
	}

	function formatSize($size)
	{
	    $units = array('o', 'Ko', 'Mo', 'Go', 'To', 'Po');
	    for ($i = 0; $size > 1024; $i++)
	        $size /= 1024;
	    return round($size, 2).' '.$units[$i];
	}
	
	function sendemail($from, $to, $sujet, $bodyhtml)
	{
	    // fonction mail();
	    $headers  = "MIME-Version: 1.0 \n";
	    $headers .= "Content-Type: text/html; charset=utf-8 \n";
	    $headers .= "From: $from  \n";
	    $CR_Mail = TRUE;
	    $CR_Mail = @mail ($to, $sujet, $bodyhtml, $headers);
	    
	    if ($CR_Mail === FALSE)
	        return "error $CR_Mail";
	    else
	        return "ok";
	}
?>
