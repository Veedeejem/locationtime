<?php

namespace Craft;

class LocationtimeTwigExtension extends \Twig_Extension
{
	protected $env;

	public function getName()
	{
		return 'Locationtime';
	}

	public function getFilters()
	{
		return array('locationtime' => new \Twig_Filter_Method($this, 'locationtime'));
	}
	
	public function getFunctions()
	{
		return array('locationtime' => new \Twig_Function_Method($this, 'locationtime'));
	}

	public function initRuntime(\Twig_Environment $env)
	{
		$this->env = $env;
	}

	public function locationtime($location, $format = "H:i")
	{
		
		$latlong = $this->get_latlong($location);

		if($latlong){
			$time = $this->fetch_timezone($latlong['lat'], $latlong['long'], $format);
		}else{
			$time = "";
		}
		return $time;
	}

	private function get_latlong($location)
	{
		$location = urlencode($location);
		
		//url
		$url =	$url = "http://maps.google.com/maps/api/geocode/json?address=$location&sensor=false";
		//create new cURL resource
		$ch= curl_init();
		//set URL and other options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		//grab url and decode result
		$res = json_decode(curl_exec($ch));
		curl_close($ch);

		if(isset($res->results[0])){
			$latlong['lat'] = $res->results[0]->geometry->location->lat;
			$latlong['long'] = $res->results[0]->geometry->location->lng;
			
			return $latlong;
		}else{
			return false;
		}		
	}

	private function fetch_timezone($lat, $long, $format)
	{
		$url = "http://api.geonames.org/timezoneJSON?formatted=true&lat=$lat&lng=$long&username=locationtime&style=full";
		//get & parse yahoo weather rss feed
		//create new cURL resource
		$ch= curl_init();
		//set URL and other options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$timezone_feed	= json_decode(curl_exec($ch));
		//close curl
		curl_close($ch);
		$time			= date($format ,strtotime($timezone_feed->time));
		return $time;
	}

}