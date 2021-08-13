<?php

namespace RecycledBeans\CentralYachtAgent;

class CentralYachtAgentAPI
{
    protected $domain = 'https://www.centralyachtagent.com/snapins/';
    protected $key;
    protected $user;
    protected $limit = 20;

    public function __construct($key = null, $user = null)
    {
        if (!$key) {
            $this->key = getenv('CENTRAL_YACHT_AGENT_API_KEY');
        }

        if (!$user) {
            $this->user = getenv('CENTRAL_YACHT_AGENT_USER');
        }
    }

    public function maxResults($max = 20)
    {
        $this->limit = $max;

        return $this;
    }

    public function request($uri, $parameters = [])
    {
        $default_parameters = [
            'user' => $this->user,
            'apicode' => $this->key,
            'maxResults' => $this->limit,
        ];

        $all_parameters = array_merge($default_parameters, $parameters);
        $query_string = http_build_query($all_parameters);

        $url = "{$this->domain}{$uri}?{$query_string}";

        $xml = simplexml_load_file($url, 'SimpleXMLElement', LIBXML_NOCDATA);

        return json_decode(json_encode($xml), true);
    }

    public function search($parameters = [])
    {
        return $this->request('snyachts-xml.php', $parameters);
    }

    public function brochure($id)
    {
        return $this->request('ebrochure-xml.php', ['idin' => $id]);
    }
}