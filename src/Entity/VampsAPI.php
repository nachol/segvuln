<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Dotenv\Dotenv;
use Requests;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

    public function getVulns($projects=null, $state='active', $cvss_severity="high", $priority_level="critical")
    {
        $url= $this->host."/vulnerabilities/api/occurrences";

        $url = $url."?search[state][workflow_state]=".$state;

        $url = $url."&&search[cvss_severity]=".$cvss_severity;

        $url = $url."&&search[priority_level]=".$priority_level;

        $url = $url."&&api_key=".$this->api_key;

        if($projects != null){

            $vulns=[];
            foreach ($projects as $p) {
                $url2 = $url."&&search[project_id]=".$p;

                $request = Requests::get($url2, $this->header);

                $data = json_decode($request->body, true);

                foreach ($data["occurrences"] as $o) {
                    $vulns[] = $o;
                }


            }

        }else{
            $request = Requests::get($url, $this->header);

            $data = json_decode($request->body, true);

            foreach ($data["occurrences"] as $o) {
              $vulns[] = $o;
            }
        }

        return $vulns;
    }

    public function getClients($value='')
    {
        $url= $this->host."/vulnerabilities/api/clients";

        $url = $url."?api_key=".$this->api_key;

        $request = Requests::get($url, $this->header);

        $data = json_decode($request->body, true);

        $clientes_productivos=[];
        foreach ($data["clients"] as $cliente) {
            if($cliente["client_type"]=="Producción"){
                $clientes_productivos[] = $cliente["id"];
            }

        }

        return $clientes_productivos;
    }

    public function getProyects($clientId)
    {
        $projects=[];

        foreach ($clientId as $id) {
            $url= $this->host."/vulnerabilities/api/projects";
            $url = $url."?api_key=".$this->api_key;
            $url = $url."&&client_id=".$id;

            $request = Requests::get($url, $this->header);

            $data = json_decode($request->body, true);

            foreach ($data["projects"] as $i) {
                $projects[] = $i["id"];
            }

        }
        return $projects;
    }
    
}
