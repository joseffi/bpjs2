<?php
namespace joseffi\Bpjs;

use GuzzleHttp\Client;
use LZCompressor\LZString;

class BpjsService{

    // Guzzle HTTP Client object
    private $client;

    // async configuration
    private $db;                    // f3 ORM object
    private $async_url;             // url to kickstart async calls
    private $async_timeout = 60;    // seconds, consider async thread dead after this
    private $site_id;

    private $base_url;
    private $headers;

    private $cons_id;
    private $timestamp;
    private $signature;
    private $authorization;
    private $secret_key;
    private $user_key;
    private $pcare_user;
    private $pcare_pass;
    private $kd_aplikasi = '095';

    /**
     * @var string
     */
    private $service_name;
    private $timeout = 0;

    // $db is f3 ORM object
    public function __construct($configurations)
    {
        $this->client = new Client([
            'verify' => false
        ]);

        foreach ($configurations as $key => $val){
            if (!empty($val) and property_exists($this, $key)) {
                $this->$key = $val;
            }
        }

        if (!empty($db))
            $this->db = $db;
    }

    protected function setHeaders()
    {
        $this->headers = [
            'X-cons-id' => $this->cons_id,
            'X-Timestamp' => $this->timestamp,
            'X-Signature' => $this->signature,
            'user_key' => $this->user_key
        ];
        
        // Pcare
        if (!empty($this->authorization))
            $this->headers['X-Authorization'] = $this->authorization;
        return $this;
    }

    protected function setAuthorization()
    {
        if (!empty($this->pcare_user) and !empty($this->pcare_pass) and !empty($this->kd_aplikasi)) {
            $authorization = $this->pcare_user.":".$this->pcare_pass.":".$this->kd_aplikasi;
            $this->authorization = 'Basic '.base64_encode($authorization);
        }
        return $this;
    }

    protected function setTimestamp()
    {
        $dateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $this->timestamp = (string)$dateTime->getTimestamp();
        return $this;
    }

    protected function setSignature()
    {
        $data = $this->cons_id . '&' . $this->timestamp;
        $signature = hash_hmac('sha256', $data, $this->secret_key, true);
        $encodedSignature = base64_encode($signature);
        $this->signature = $encodedSignature;
        return $this;
    }

    private function _getDecryptionKey()
    {
        return $this->cons_id.$this->secret_key.$this->timestamp;
    }

    protected function _requestAsync($method, $feature, $data=[], $headers=[])
    {
        // if async not configured, fall back to synchronous
        if (empty($this->db) or empty($this->async_url))
            return $this->_request($method, $feature, $data, $headers);

        // save to db
        $bsy = new \joseffi\Bpjs\models\Bpjs_Sync($this->db, 'bpjs_sync', $this->site_id);
        $bsy->add($method, $this->service_name, $feature, $data, $headers);

        // kickstart async
        $promises = [
            'req1' => $this->client->requestAsync('GET', $this->async_url, ['timeout' => 0.2])
        ];

        try {
            $results = \GuzzleHttp\Promise\Utils::unwrap($promises);
        }
        catch (\GuzzleHttp\Exception\ConnectException $e) {
//            error_log('caught timeout');
//            error_log($e->getMessage());
//            error_log($e->getTraceAsString());            
        }     
        catch (\Exception $e) {
            error_log('error kickstarting async');
            error_log($e->getMessage());
        }
        return true;
    }

    // kickstart async calls
    // async_url should call this method
    public function _kickstartAsync()
    {
        $bsy = new \joseffi\Bpjs\models\Bpjs_Sync($this->db, 'bpjs_sync', $this->site_id);

        // any running process?
        $bsy->load(['site_id=:site_id AND request_time > :t', 
                    [':site_id'=>$this->site_id, ':t'=>date("Y-m-d H:i:s", time() - $this->async_timeout)]]);
        if (!$bsy->dry())
            return false;
        
        // process each row
        $pending = $bsy->list_pending_by_site();

        if (count($pending)) {
            foreach ($pending as $row) {
                $bsy->flag_request_start($row['id']);
                $tmp = $this->_request($row['method'], $row['feature'], $row['post_data'], $row['headers']);

                if ($tmp === false) continue;
                $bsy->load(['id=:id', [':id'=>$row['id']]]);
                $bsy->response_code = $tmp['metaData']['code'];
                $bsy->response_body = json_encode($tmp);
                $bsy->save();
            }

            return $this->_kickstartAsync();
        }
        else 
            return true;
    }

    // returns response object or false
    private function _request($method, $feature, $data=[], $headers=[])
    {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE']))
            return false;

        //set X-Timestamp, X-Signature, X-Authorization if required, and finally the headers
        $this->setTimestamp()->setSignature()->setAuthorization()->setHeaders();

        if (in_array($method, ['POST', 'PUT', 'DELETE']))
            $this->headers['Content-Type'] = 'application/x-www-form-urlencoded';
        if (!empty($headers))
            $this->headers = array_merge($this->headers, $headers);

        $opts = ['headers' => $this->headers, 'timeout' => $this->timeout];
        if (!empty($data))
            $opts['json'] = $data;

        try {
            $response = json_decode(
                            $this->client->request(
                                $method,
                                $this->base_url . '/' . $this->service_name . '/' . $feature,
                                $opts
                            )->getBody()->getContents()
                        , true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $errmsg = $e->getResponse()->getBody()->getContents();
            if (!empty($errmsg))
                error_log($errmsg);

            if ($e->getCode() == 0) {
                $handlerContext = $e->getHandlerContext();
                $response = [
                                'metaData' => [
                                    'code' => $handlerContext['errno'],
                                    'message' => $handlerContext['error']
                                ]
                            ];
            }
            else {
                $response = [
                                'metaData' => [
                                    'code' => $e->getCode(),
                                    'message' => (string) $e->getResponse()->getBody()
                                ]
                            ];
            }
        }

        if ($response['metaData']['code'] ?? '' == 200 and !empty($response['response']) and is_string($response['response']))
            $response['response'] = json_decode($this->_decompress($response['response']), true);
        elseif ($response['metaData']['code'] == 204) {
            $response['response'] = [];
        }
        return $response;
    }

    private function _decompress($txt) {
        $key  = $this->_getDecryptionKey();
        $hash = hex2bin(hash('sha256', $key));
        $iv   = substr($hash, 0, 16);


        $tmp  = openssl_decrypt(base64_decode($txt), 'AES-256-CBC', $hash, OPENSSL_RAW_DATA, $iv);
        if ($tmp === false) return $txt;

        return LZString::decompressFromEncodedURIComponent($tmp);
    }

    protected function get($feature) {
        return $this->_request('GET', $feature);
    }

    protected function post($feature, $data=[], $headers=[]) {
        return $this->_request('POST', $feature, $data, $headers);
    }

    protected function postAsync($feature, $data=[], $headers=[]) {
        return $this->_requestAsync('POST', $feature, $data, $headers);
    }

    protected function put($feature, $data=[]) {
        return $this->_request('PUT', $feature, $data);
    }

    protected function delete($feature, $data=[]) {
        return $this->_request('DELETE', $feature, $data);
    }

}
