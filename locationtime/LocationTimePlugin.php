<?php

namespace Craft;

/**
 * LocationTime plugin
 * returns the time for any given location
 *
 * 
 **/

Class LocationTimePlugin extends BasePlugin
{
	public function getName()
	{
		return Craft::t('Location Time');
	}

	public function getVersion()
	{
		return '0.1';
	}

	public function getDeveloper()
	{
		return 'Steven Vandemoortele';
	}

	public function getDeveloperUrl()
	{
		return 'http://www.decoders.be';
	}

	public function addTwigExtension()
	{
		Craft::import('plugins.locationtime.twigextensions.LocationtimeTwigExtension');
		return new LocationtimeTwigExtension();
	}

}