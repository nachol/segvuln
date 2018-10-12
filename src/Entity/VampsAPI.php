<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Dotenv\Dotenv;
use Requests;

class VampsAPI
{

    private $api_key;

    private $host = "https://cybersecurity.telefonica.com";

    private $header = array('Accept' => 'application/json',
        "User-Agent" => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:62.0) Gecko/20100101 Firefox/62.0",
        "Accept-Language"=> "en-US,en;q=0.5",
        "Accept-Encoding" => "gzip, deflate"
    );


    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $this->setApi_key(getenv('VAMPS_API'));
    }

    public function setApi_key($value='')
    {
        $this->api_key = $value;

        return $this;
    }

    public function getVulns($state='active', $cvss_severity="high", $priority_level="critical")
    {
        $url= $this->host."/vulnerabilities/api/occurrences";

        $url = $url."?search[state][workflow_state]=".$state;

        $url = $url."&&search[cvss_severity]=".$cvss_severity;

        $url = $url."&&search[priority_level]=".$priority_level;

        $url = $url."&&api_key=".$this->api_key;


        $request = Requests::get($url, $this->header);

        dump($request->body);




// $headers = array('Accept' => 'application/json');
// $options = array('auth' => array('user', 'pass'));
// $request = Requests::get('https://api.github.com/gists', $headers, $options);

// var_dump($request->status_code);
// // int(200)

// var_dump($request->headers['content-type']);
// // string(31) "application/json; charset=utf-8"

// var_dump($request->body);
// // string(26891) "[...]"



    }

    
}
