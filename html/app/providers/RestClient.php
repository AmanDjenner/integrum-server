<?php

class RestClient
{

    private static $hostRest;
    private static $hookup;
    private static $cookiesRest;
    private static $verbose;
    private static $verboseResponse;
    private static $localPort;
    private $content;

    public function __construct()
    {
        self::$hostRest        = Config::get('parameters.hostRest');
        self::$cookiesRest     = Config::get('parameters.cookiesRest');
        self::$localPort       = Config::get('parameters.localPort');
        self::$verbose         = Config::get('parameters.verboseLog');
        self::$verboseResponse = Config::get('parameters.verboseLogResponse');
    }

    public function get($methodName, $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE)
    {
        if (!$this->hasCacheToContent( $MemKeyNow, $expirationNow)) {
            return $this->cacheToContent( $this->curlAny(NULL, self::$hostRest, "GET", $methodName, $throwNullError), $MemKeyNow, $expirationNow);
        }
    }
    
    private function isCacheDisabled() {
        return true;//return App::environment(Config::get('parameters.localPort'))||!Config::get('parameters.useCache',true);
    }
    
    private function hasCacheToContent($MemKeyNow, $expirationNow = 0)
    {
        if ($this->isCacheDisabled()) {
            $expirationNow = 0;
        }

        if (0 != $expirationNow) {
            //Sprawdzamy czy mamy już coś w cache
            $this->content = Cache::get($MemKeyNow);
            if ($this->content) {
                $this->verbose('CacheGet: ' . $MemKeyNow);
                return TRUE;
            }
        }
        return FALSE;
    }
    
    private function cacheToContent($data, $MemKeyNow, $expirationNow = 0)
    {
        if ($this->isCacheDisabled()) {
            $expirationNow = 0;
        }

        $this->content = $data;
        if (0 != $expirationNow) {
            Cache::put($MemKeyNow, $this->content, $expirationNow);
            $this->verbose('CacheAdd: ' . $MemKeyNow);
        }

        return $this->content;
    }

    public function post(array $curlPostDataNow, $methodName,
            $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE) {
        return $this->postAny($curlPostDataNow, self::$hostRest, $methodName,
                         $MemKeyNow, $expirationNow, $throwNullError);
    }

    public function postAny(array $curlPostDataNow, $hostUrl, $methodName,
                         $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE) {
        if (!$this->hasCacheToContent( $MemKeyNow, $expirationNow)) {
            return $this->cacheToContent( $this->curlAny($curlPostDataNow, $hostUrl, "POST", $methodName, $throwNullError), $MemKeyNow, $expirationNow);
        }
        return TRUE;    
    }

    
    public function put(array $curlPostDataNow, $methodName,
            $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE)
    {
        if (!$this->hasCacheToContent( $MemKeyNow, $expirationNow)) {
            return $this->cacheToContent( $this->curlAny($curlPostDataNow, self::$hostRest, "PUT", $methodName, $throwNullError), $MemKeyNow, $expirationNow);
        }
        return TRUE;
    }
	
    public function curlAny($data, $hostUrl, $method="POST", $methodName, $throwNullError = TRUE)
    {
        $serviceUrl   = $hostUrl.$methodName;
        self::$hookup = curl_init($serviceUrl);
        $this->verbose("\nREQ  " .$method . " " . $hostUrl . "\t" . $methodName);
        $start = microtime(true);
        if ($method=="POST"||$method=="PUT") {
            $dataJson     = json_encode($data);
            if (self::$verboseResponse) {
                $this->verbose($dataJson);
            }
        }
        curl_setopt(self::$hookup, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(self::$hookup, CURLOPT_HTTPHEADER,
                array('Content-Type: application/json', 'Expect:'));
        if ($method=="POST") {
            curl_setopt(self::$hookup, CURLOPT_POST, true);
            curl_setopt(self::$hookup, CURLOPT_POSTFIELDS, $dataJson);
        } else if ($method=="DELETE") {
            curl_setopt(self::$hookup, CURLOPT_CUSTOMREQUEST, "DELETE");
        } else if ($method=="PUT") {
            curl_setopt(self::$hookup, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt(self::$hookup, CURLOPT_POSTFIELDS, $dataJson);
        }
        curl_setopt(self::$hookup, CURLOPT_COOKIEJAR, self::$cookiesRest);
        curl_setopt(self::$hookup, CURLOPT_COOKIEFILE, self::$cookiesRest);
        curl_setopt(self::$hookup, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt(self::$hookup, CURLOPT_TIMEOUT, 60); //timeout in seconds
        $response     = curl_exec(self::$hookup);

        $httpCode = curl_getinfo(self::$hookup, CURLINFO_HTTP_CODE);
        $time_elapsed_secs = round(microtime(true) - $start,4);
        if (self::$verboseResponse) { 
            $this->verbose("RESP HTTP " . $httpCode . " - " .$method . " " . $hostUrl . "\t" . $methodName . "\n" .$response . "\ntime: " . $time_elapsed_secs );
        } else {
            $this->verbose("RESP HTTP " . $httpCode . " - " .$method . " " . $hostUrl . "\t" . $methodName . " time: " . $time_elapsed_secs );
        }

        if ($httpCode != 200 && $httpCode != 204) {
            throw new RestException((int) $httpCode);
        }

        if (null == $response && $throwNullError) {
            throw new RestException('The server returns NULL. methodName: ' . $methodName);
        }
        if (false === $response) {
            throw new RestException('error occured during curl exec. Additioanl info: ' . curl_errno(self::$hookup));
        }

        curl_close(self::$hookup);
        return $response;
    }

    public function remove($methodNameNow, $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE)
    {
        return $this->removeAny(self::$hostRest, $methodNameNow,
                         $MemKeyNow, $expirationNow, $throwNullError);
    }

    public function removeAny($hostUrl, $methodNameNow,
                         $MemKeyNow, $expirationNow = 0, $throwNullError = TRUE)
    {
        if ($this->isCacheDisabled()) {
            $expirationNow = 0;
        }

        $this->content = $this->curlAny(NULL, $hostUrl, "DELETE", $methodNameNow, $throwNullError);
        if (0 != $expirationNow) {
            //Sprawdzamy czy mamy już coś w cache
            Cache::forget($MemKeyNow);
        }
        return $this->content;
    }

    /*     * Aktualizuje Dane + Kasuje Cache */

    public function curlUpload($methodName, $imgRawData)
    {
        $serviceUrl   = self::$hostRest . $methodName;
        self::$hookup = curl_init($serviceUrl);
        $this->verbose("\n" .date("Y-m-d H:i:s") . " UPLOAD " . $methodName);
        $start = microtime(true);
        $headers      = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
        $postfields   = array("licenses" => "$imgRawData");
        $options      = array(
            CURLOPT_URL            => $serviceUrl,
            //CURLOPT_HEADER     => true,
            CURLOPT_POST           => 1,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_POSTFIELDS     => $postfields,
            CURLOPT_INFILESIZE     => strlen($imgRawData),
            CURLOPT_COOKIEJAR      => self::$cookiesRest,
            CURLOPT_COOKIEFILE     => self::$cookiesRest,
            CURLOPT_RETURNTRANSFER => true
        ); // cURL options
        curl_setopt_array(self::$hookup, $options);

// i get response from the server
        $response = curl_exec(self::$hookup);
        $httpCode = curl_getinfo(self::$hookup, CURLINFO_HTTP_CODE);
        $time_elapsed_secs = round(microtime(true) - $start,4);
        if (self::$verboseResponse) { 
			$this->verbose("HTTP " . $httpCode . "\n" . $response . "\ntime: " . $time_elapsed_secs);
		} else {
			$this->verbose("HTTP " . $httpCode . " time: " . $time_elapsed_secs );
		}
        curl_close(self::$hookup);
        return $response;
    }

    public function upPost(array $curlPostDataNow, $methodNameNow,
            $MemKeyNow, $throwNullError = TRUE)
    {

        $this->content = $this->curlAny($curlPostDataNow, self::$hostRest, 
                                 "POST", $methodNameNow, $throwNullError);

        if (!$this->isCacheDisabled()) {
            Cache::forget($MemKeyNow);
        }
        return TRUE;
    }

    public function clean($MemKeyNow)
    {
        /** kasujemy dane z cache */
        if (!$this->isCacheDisabled()) {
            Cache::forget($MemKeyNow);
        }
    }

    private function verbose($data)
    {
        if (App::environment(self::$localPort)) {
            error_log(print_r($data, 1) . "\n", 3, self::$verbose);
        }
    }

    public function getContent()
    {
        return $this->content;
    }

    public function result()
    {
        if (empty($this->content)) {
            return FALSE;
        }
        return TRUE;
    }

}
