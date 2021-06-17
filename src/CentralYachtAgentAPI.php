<?php

namespace RecycledBeans\CentralYachtAgent;

class CentralYachtAgentAPI
{
    protected $domain = 'http://www.centralyachtagent.com/snapins/';
    protected $key;
    protected $user;

    public function __construct($key = null, $user = null)
    {
        if (!$key) {
            $this->key = getenv('CENTRAL_YACHT_AGENT_API_KEY');
        }

        if (!$user) {
            $this->user = getenv('CENTRAL_YACHT_AGENT_USER');
        }
    }

    public function request($uri)
    {
        $url = "{$uri}?user={$this->user}&apicode={$this->key}";

        $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        return json_decode(json_encode($xml), true);
    }

    public function search()
    {
        $uri = 'snyachts-xml.php';

        return $this->request($uri);
    }
}