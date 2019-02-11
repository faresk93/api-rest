<?php
/**
 * Created by PhpStorm.
 * User: fkhiary
 * Date: 11/02/2019
 * Time: 16:30
 */

namespace AppBundle\Weather;


use GuzzleHttp\Client;
use JMS\Serializer\SerializerInterface;

class Weather
{
    private $weatherClient;

    private $apiKey;

    private $serializer;

    /**
     * Weather constructor.
     * @param $weatherClient
     * @param $apiKey
     * @param $serializer
     */
    public function __construct(Client $weatherClient, $apiKey, SerializerInterface $serializer)
    {
        $this->weatherClient = $weatherClient;
        $this->apiKey = $apiKey;
        $this->serializer = $serializer;
    }

    public function getCurrent()
    {
        $uri = '/data/2.5/weather?q=Tunis&APPID='.$this->apiKey;
        try {
            $response = $this->weatherClient->get($uri);
        } catch (\Exception $e) {
            return ['error' => 'informations indisponibles! Erreur: '.$e->getMessage()];
        }


        $data = $this->serializer->deserialize(
            $response->getBody()->getContents(),
            'array',
            'json'
        );

        return [
          'city' => $data['name'],
          'description' => $data['weather'][0]['main']
        ];
    }

}
