<?php

define("SIS_XML_URL_TEST", "https://sis-t.redsys.es:25443/sis/operaciones");
define("SIS_XML_URL_REAL", "https://sis.redsys.es/sis/operaciones");

define("SIS_POST_URL_TEST", "https://sis-t.redsys.es:25443/sis/realizarPago");
define("SIS_POST_URL_REAL", "https://sis.redsys.es/sis/realizarPago");

class fwTpv {
	
	/*private $fuc;
	private $terminal;
	private $key;
	private $url_ipn;
	private $test_mode;

	public function fwTpvSIS($fuc, $terminal, $key, $url_ipn, $test_mode) {
		$this->fuc = $fuc;
		$this->terminal = $terminal;
		$this->key = $key;
		$this->url_ipn = $url_ipn;
		$this->test_mode = $test_mode;
	}

	public function generateAuthorizationForm($order_id, $order_description, $amount, $locale, $currency, $url_ok, $url_ko) {
		$order_id = $this->stringToOrderId($order_id);
		$amount = fwTpvSIS::doubleToAmount($amount);
		$language = $this->localeToConsumeLanguage($locale);

		$transaction_type = "0";
		$merchant_identifier = "REQUIRED";
		$signature = $this->generateSignatureAuthorizationForm($amount, $order_id, $this->fuc, $currency, $transaction_type, $this->url_ipn, $merchant_identifier, $this->key);

		return "
            <form id=\"tpvsismpi\" name=\"tpvsismpi\" action=\"" . ($this->test_mode ? SIS_POST_URL_TEST : SIS_POST_URL_REAL) . "\" method=\"post\" target=\"_top\">
            <input type=\"hidden\" name=\"Ds_Merchant_Amount\" value=\"$amount\" />
            <input type=\"hidden\" name=\"Ds_Merchant_Currency\" value=\"$currency\" />
            <input type=\"hidden\" name=\"Ds_Merchant_Order\" value=\"$order_id\" />
            <input type=\"hidden\" name=\"Ds_Merchant_ProductDescription\" value=\"$order_description\" />
            <input type=\"hidden\" name=\"Ds_Merchant_MerchantCode\" value=\"$this->fuc\" />
            <input type=\"hidden\" name=\"Ds_Merchant_Identifier\" value=\"$merchant_identifier\" />
            <input type=\"hidden\" name=\"Ds_Merchant_ConsumerLanguage\" value=\"$language\" />
            <input type=\"hidden\" name=\"Ds_Merchant_MerchantSignature\" value=\"$signature\" />
            <input type=\"hidden\" name=\"Ds_Merchant_Terminal\" value=\"$this->terminal\" />
            <input type=\"hidden\" name=\"Ds_Merchant_TransactionType\" value=\"$transaction_type\" />
            <input type=\"hidden\" name=\"Ds_Merchant_MerchantURL\" value=\"$this->url_ipn\" />
            <input type=\"hidden\" name=\"Ds_Merchant_UrlOK\" value=\"$url_ok\" />
            <input type=\"hidden\" name=\"Ds_Merchant_UrlKO\" value=\"$url_ko\" />";
	}

	public function validateAuthorizationForm($post_vars) {
		$signature = $this->generateSignatureAuthorizationFormResponse($post_vars["Ds_Amount"], $post_vars["Ds_Order"], $post_vars["Ds_MerchantCode"], $post_vars["Ds_Currency"], $post_vars["Ds_Response"], $this->key);

		if ($signature == $post_vars["Ds_Signature"]) {
			if ($this->responseCodeToSuccess($post_vars["Ds_Response"]) && $post_vars["Ds_Merchant_Identifier"]) {
				return array(
					"success"		=> true,
					"order_id"		=> $post_vars["Ds_Order"],
					"card_expiry"	=> date("Y/m/d", mktime(0, 0, 0, substr($post_vars["Ds_ExpiryDate"], 2, 2), 1, substr($post_vars["Ds_ExpiryDate"], 0, 2))),
					"card_country"	=> $post_vars["Ds_Card_Country"],
					"card_token"	=> $post_vars["Ds_Merchant_Identifier"],
				);
			}
		}

		return array(
			"success" => false,
		);
	}

	public function generatePaymentFormSHA256($order_id, $order_description, $amount, $locale, $currency, $url_ok, $url_ko) {
		$order_id = $this->stringToOrderId($order_id);
		$amount = fwTpvSIS::doubleToAmount($amount);
		$language = $this->localeToConsumeLanguage($locale);

		$transaction_type = "0";
		$merchant_identifier = "REQUIRED";

		$Ds_MerchantParameters = base64_encode(json_encode(array(
            "Ds_Merchant_Amount"				=> $amount,
            "Ds_Merchant_Currency"				=> $currency,
            "Ds_Merchant_Order"					=> $order_id,
            "Ds_Merchant_ProductDescription"	=> $order_description,
            "Ds_Merchant_MerchantCode"			=> $this->fuc,
            "Ds_Merchant_ConsumerLanguage"		=> $language,
            "Ds_Merchant_Terminal"				=> $this->terminal,
            "Ds_Merchant_TransactionType"		=> $transaction_type,
            "Ds_Merchant_MerchantURL"			=> $this->url_ipn,
            "Ds_Merchant_UrlOK"					=> $url_ok,
            "Ds_Merchant_UrlKO"					=> $url_ko,
		)));

		$key = base64_decode($this->key);
		$key = $this->encrypt_3DES($order_id, $key);
		$signature = base64_encode($this->mac256($Ds_MerchantParameters, $key));

		return "
            <form id=\"tpvsismpi\" name=\"tpvsismpi\" action=\"" . ($this->test_mode ? SIS_POST_URL_TEST : SIS_POST_URL_REAL) . "\" method=\"post\" target=\"_top\">
            <input type=\"hidden\" name=\"Ds_SignatureVersion\" value=\"HMAC_SHA256_V1\" />
            <input type=\"hidden\" name=\"Ds_MerchantParameters\" value=\"$Ds_MerchantParameters\" />
            <input type=\"hidden\" name=\"Ds_Signature\" value=\"$signature\" />";
	}

	public function validatePaymentForm($post_vars) {
		$Ds_MerchantParametersJSON = base64_decode(strtr($post_vars["Ds_MerchantParameters"], '-_', '+/'));
		$Ds_MerchantParameters = json_decode($Ds_MerchantParametersJSON, true);

		if ($this->responseCodeToSuccess($Ds_MerchantParameters["Ds_Response"]) && $Ds_MerchantParameters["Ds_AuthorisationCode"]) {
			return array(
				"success"				=> true,
				"order_id"				=> $Ds_MerchantParameters["Ds_Order"],
				"Ds_AuthorisationCode"	=> $Ds_MerchantParameters["Ds_AuthorisationCode"],
				"Ds_MerchantParameters"	=> $Ds_MerchantParameters,
			);
		}

		return array(
			"success" 				=> false,
			"Ds_MerchantParameters"	=> $Ds_MerchantParameters,
		);
	}

	public function sendPaymentRequestXML($order_id, $order_description, $amount, $currency, $card_token) {
		$order_id = $this->idToMerchantOrder($order_id);
		$amount = fwTpvSIS::doubleToAmount($amount);
		$transaction_type = "A";
		$merchant_direct_payment = "true";

		$signature = $this->generateSignaturePaymentRequestXML($amount, $order_id, $this->fuc, $currency, $transaction_type, $card_token, $merchant_direct_payment, $this->key);

		$xml = "entrada=
		<DATOSENTRADA>
			<DS_Version>0.1</DS_Version>
			<DS_MERCHANT_CURRENCY>$currency</DS_MERCHANT_CURRENCY>
			<DS_MERCHANT_AMOUNT>$amount</DS_MERCHANT_AMOUNT>
			<DS_MERCHANT_ORDER>$order_id</DS_MERCHANT_ORDER>
			<DS_MERCHANT_MERCHANTCODE>$this->fuc</DS_MERCHANT_MERCHANTCODE>
			<DS_MERCHANT_TERMINAL>$this->terminal</DS_MERCHANT_TERMINAL>
			<DS_MERCHANT_MERCHANTURL>$this->url_ipn</DS_MERCHANT_MERCHANTURL>
			<DS_MERCHANT_MERCHANTSIGNATURE>$signature</DS_MERCHANT_MERCHANTSIGNATURE>
			<DS_MERCHANT_TRANSACTIONTYPE>$transaction_type</DS_MERCHANT_TRANSACTIONTYPE>
			<DS_MERCHANT_MERCHANTDATA>$order_description</DS_MERCHANT_MERCHANTDATA>
			<DS_MERCHANT_IDENTIFIER>$card_token</DS_MERCHANT_IDENTIFIER>
			<DS_MERCHANT_DIRECTPAYMENT>$merchant_direct_payment</DS_MERCHANT_DIRECTPAYMENT>
		</DATOSENTRADA>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, ($this->test_mode ? SIS_XML_URL_TEST : SIS_XML_URL_REAL));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		$tmp = curl_exec($ch);
		curl_close ($ch);

		if ($response = $this->xmlResponseToArray($tmp)) {
			if ($response["CODIGO"] == "0" && $this->responseCodeToSuccess($response["DS_RESPONSE"]) && $response["DS_AUTHORISATIONCODE"]) {
				return $response["DS_AUTHORISATIONCODE"];
			}
		}

		return false;
	}

	private function generateSignatureAuthorizationForm($amount, $order_id, $fuc, $currency, $transaction_type, $url_ipn, $merchant_identifier, $key) {
		return $this->generateSignature($amount . $order_id . $fuc . $currency . $transaction_type . $url_ipn . $merchant_identifier . $key);
	}

	private function generateSignatureAuthorizationFormResponse($amount, $order_id, $fuc, $currency, $response, $key) {
		return $this->generateSignature($amount . $order_id . $fuc . $currency . $response . $key);
	}

	private function generateSignaturePaymentRequestXML($amount, $order_id, $fuc, $currency, $transaction_type, $merchant_identifier, $merchant_direct_payment, $key) {
		return $this->generateSignature($amount . $order_id . $fuc . $currency . $transaction_type . $merchant_identifier . $merchant_direct_payment . $key);
	}

	private function generateSignature($string) {
		return strtoupper(sha1($string));
	}

	private function stringToOrderId($str) {
		return substr($str, 0, 12);
	}

	private function responseCodeToSuccess($response_code) {
		if ($response_code) {
			$response_code = intval($response_code);

			if ($response_code >= 0 && $response_code <= 99) {
				return true;
			}
		}

		return false;
	}

	private function localeToConsumeLanguage($locale) {
		$ttable = array(
			"es"	=> "001",
			"en"	=> "002",
			"ca"	=> "003",
			"fr"	=> "004",
			"de"	=> "005",
			"nl"	=> "006",
			"it"	=> "007",
			"pt"	=> "009",
			"pl"	=> "011",
			"gl"	=> "012",
			"eu"	=> "013",
		);

		return ($ttable[$locale] ? $ttable[$locale] : "001");
	}

	public function xmlResponseToArray($xml) {
		if ($xml) {
			$tmp = array();
			$data = array();

			$parser = xml_parser_create();
			xml_parse_into_struct($parser, $xml, $tmp);
			xml_parser_free($parser);

			foreach ($tmp as $t) {
			    $data[$t["tag"]] = urldecode($t["value"]);
			}

			return $data;
		}

		return false;
	}

	public static function doubleToAmount($dbl) {
		return round($dbl * 100);
	}

	public static function idToMerchantOrder($id) {
		return substr(str_pad($id, 4, "0", STR_PAD_LEFT) . "Z" . md5(microtime()), 0, 12);
		//return substr(rand(11111, 99999) . "-" . $id . "-" . md5(microtime()), 0, 12);
	}*/

	/*public static function merchantOrderToId($merchant_order) {*/
		//if (preg_match("/([^Z]+)Z?.*/", $merchant_order, $regs)) {
		//	return $regs[1];
		//}

		//if (preg_match("/\d{4}-(\d+)-.*/", $merchant_order, $regs)) {
		//	return $regs[1];
		//}

		/*return false;
	}

	public function generateAuthorizationFormSHA256($order_id, $order_description, $amount, $locale, $currency, $url_ok, $url_ko) {
		$order_id = $this->stringToOrderId($order_id);
		$amount = $this->doubleToAmount($amount);
		$language = $this->localeToConsumeLanguage($locale);

		$transaction_type = "0";
		$merchant_identifier = "REQUIRED";

		$Ds_MerchantParameters = base64_encode(json_encode(array(
            "Ds_Merchant_Amount"				=> $amount,
            "Ds_Merchant_Currency"				=> $currency,
            "Ds_Merchant_Order"					=> $order_id,
            "Ds_Merchant_ProductDescription"	=> $order_description,
            "Ds_Merchant_MerchantCode"			=> $this->fuc,
            "Ds_Merchant_Identifier"			=> $merchant_identifier,
            "Ds_Merchant_ConsumerLanguage"		=> $language,
            "Ds_Merchant_Terminal"				=> $this->terminal,
            "Ds_Merchant_TransactionType"		=> $transaction_type,
            "Ds_Merchant_MerchantURL"			=> $this->url_ipn,
            "Ds_Merchant_UrlOK"					=> $url_ok,
            "Ds_Merchant_UrlKO"					=> $url_ko,
		)));

		$key = base64_decode($this->key);
		$key = $this->encrypt_3DES($order_id, $key);
		$signature = base64_encode($this->mac256($Ds_MerchantParameters, $key));

		return "
            <form id=\"tpvsismpi\" name=\"tpvsismpi\" action=\"" . ($this->test_mode ? SIS_POST_URL_TEST : SIS_POST_URL_REAL) . "\" method=\"post\" target=\"_top\">
            <input type=\"hidden\" name=\"Ds_SignatureVersion\" value=\"HMAC_SHA256_V1\" />
            <input type=\"hidden\" name=\"Ds_MerchantParameters\" value=\"$Ds_MerchantParameters\" />
            <input type=\"hidden\" name=\"Ds_Signature\" value=\"$signature\" />";
	}

	public function validateAuthorizationFormSHA256($post_vars) {
		$Ds_MerchantParametersJSON = base64_decode(strtr($post_vars["Ds_MerchantParameters"], '-_', '+/'));
		$Ds_MerchantParameters = json_decode($Ds_MerchantParametersJSON, true);

		$key = base64_decode($this->key);
		$key = $this->encrypt_3DES($Ds_MerchantParameters["Ds_Order"], $key);
		$signature = strtr(base64_encode($this->mac256($post_vars["Ds_MerchantParameters"], $key)), '+/', '-_');

		//if ($signature == $post_vars["Ds_Signature"]) {
			if ($this->responseCodeToSuccess($Ds_MerchantParameters["Ds_Response"]) && $Ds_MerchantParameters["Ds_Merchant_Identifier"]) {
				return array(
					"success"		=> true,
					"order_id"		=> $Ds_MerchantParameters["Ds_Order"],
					"card_expiry"	=> date("Y/m/d", mktime(0, 0, 0, substr($Ds_MerchantParameters["Ds_ExpiryDate"], 2, 2), 1, substr($Ds_MerchantParameters["Ds_ExpiryDate"], 0, 2))),
					"card_country"	=> $Ds_MerchantParameters["Ds_Card_Country"],
					"card_token"	=> $Ds_MerchantParameters["Ds_Merchant_Identifier"],
				);
			}
		//}

		return array(
			"success" => false,
		);
	}

	public function sendPaymentRequestXMLSHA256($order_id, $order_description, $amount, $currency, $card_token) {
		$order_id = $this->idToMerchantOrder($order_id);
		$amount = fwTpvSIS::doubleToAmount($amount);
		$transaction_type = "A";
		$merchant_direct_payment = "true";

		$datos_entrada = "" .
			"<DATOSENTRADA>" .
				"<DS_Version>0.1</DS_Version>" .
				"<DS_MERCHANT_CURRENCY>$currency</DS_MERCHANT_CURRENCY>" .
				"<DS_MERCHANT_AMOUNT>$amount</DS_MERCHANT_AMOUNT>" .
				"<DS_MERCHANT_ORDER>$order_id</DS_MERCHANT_ORDER>" .
				"<DS_MERCHANT_MERCHANTCODE>$this->fuc</DS_MERCHANT_MERCHANTCODE>" .
				"<DS_MERCHANT_TERMINAL>$this->terminal</DS_MERCHANT_TERMINAL>" .
				"<DS_MERCHANT_MERCHANTURL>$this->url_ipn</DS_MERCHANT_MERCHANTURL>" .
				"<DS_MERCHANT_TRANSACTIONTYPE>$transaction_type</DS_MERCHANT_TRANSACTIONTYPE>" .
				"<DS_MERCHANT_MERCHANTDATA>$order_description</DS_MERCHANT_MERCHANTDATA>" .
				"<DS_MERCHANT_IDENTIFIER>$card_token</DS_MERCHANT_IDENTIFIER>" .
				"<DS_MERCHANT_DIRECTPAYMENT>$merchant_direct_payment</DS_MERCHANT_DIRECTPAYMENT>" .
			"</DATOSENTRADA>";

		$key = base64_decode($this->key);
		$key = $this->encrypt_3DES($order_id, $key);
		$signature = $this->safeBase64EncodePost($this->mac256($datos_entrada, $key));

		$xml = "entrada=
			<REQUEST>
				" . $datos_entrada . "
				<DS_SIGNATUREVERSION>HMAC_SHA256_V1</DS_SIGNATUREVERSION>
				<DS_SIGNATURE>$signature</DS_SIGNATURE>
			</REQUEST>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, ($this->test_mode ? SIS_XML_URL_TEST : SIS_XML_URL_REAL));
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded"));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
		$tmp = curl_exec($ch);
		curl_close ($ch);

		return $this->xmlResponseToArray($tmp);
	}

	public function validatePaymentRequestResponse($response) {
		if (is_array($response) && $response["CODIGO"] == "0" && $this->responseCodeToSuccess($response["DS_RESPONSE"]) && $response["DS_AUTHORISATIONCODE"]) {
			return $response["DS_AUTHORISATIONCODE"];
		}

		return false;
	}

	private function encrypt_3DES($message, $key){
		$bytes = array(0,0,0,0,0,0,0,0);
		$iv = implode(array_map("chr", $bytes));
		return mcrypt_encrypt(MCRYPT_3DES, $key, $message, MCRYPT_MODE_CBC, $iv);
	}

	private function mac256($ent, $key){
		$res = hash_hmac("sha256", $ent, $key, true);
		return $res;
	}

	private function safeBase64EncodePost($value) {
		return urlencode(base64_encode($value));
	}

	public function _2021_generateAuthorizationFormSHA256($order_id, $order_description, $amount, $locale, $currency, $url_ok, $url_ko) {
		$order_id = $this->stringToOrderId($order_id);
		$amount = $this->doubleToAmount($amount);
		$language = $this->localeToConsumeLanguage($locale);

		$transaction_type = "0";
		$merchant_identifier = "REQUIRED";

		$Ds_MerchantParameters = base64_encode(json_encode(array(
            "Ds_Merchant_Amount"				=> $amount,
            "Ds_Merchant_Currency"				=> $currency,
            "Ds_Merchant_Order"					=> $order_id,
            "Ds_Merchant_ProductDescription"	=> $order_description,
            "Ds_Merchant_MerchantCode"			=> $this->fuc,
            "Ds_Merchant_Identifier"			=> $merchant_identifier,
            "Ds_Merchant_ConsumerLanguage"		=> $language,
            "Ds_Merchant_Terminal"				=> $this->terminal,
            "Ds_Merchant_TransactionType"		=> $transaction_type,
            "Ds_Merchant_MerchantURL"			=> $this->url_ipn,
            "Ds_Merchant_UrlOK"					=> $url_ok,
            "Ds_Merchant_UrlKO"					=> $url_ko,
		)));

		$key = base64_decode($this->key);
		$key = $this->encrypt_3DES($order_id, $key);
		$signature = base64_encode($this->mac256($Ds_MerchantParameters, $key));

		return "
            <form id=\"tpvsismpi\" name=\"tpvsismpi\" action=\"" . ($this->test_mode ? SIS_POST_URL_TEST : SIS_POST_URL_REAL) . "\" method=\"post\" target=\"_top\">
            <input type=\"hidden\" name=\"Ds_SignatureVersion\" value=\"HMAC_SHA256_V1\" />
            <input type=\"hidden\" name=\"Ds_MerchantParameters\" value=\"$Ds_MerchantParameters\" />
            <input type=\"hidden\" name=\"Ds_Signature\" value=\"$signature\" />";
	}
*/


}