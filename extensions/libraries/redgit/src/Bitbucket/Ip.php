<?php
/**
 * @package     Redgit.Library
 * @subpackage  Bitbucket
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Bitbucket;

defined('_JEXEC') or die;

/**
 * Abstract module
 *
 * @since  1.0.0
 */
class Ip
{
	/**
	 * Ip address
	 *
	 * @var  string
	 */
	protected $ip;

	/**
	 * Valid IP ranges for bitbucket
	 *
	 * @var  array
	 */
	protected $validIpRanges = array(
		'131.103.20.160/27',
		'165.254.145.0/26',
		'104.192.143.0/24',
		/**
		 * Since 15/12/2015
		 * https://blog.bitbucket.org/2015/12/03/making-bitbuckets-network-better-faster-and-ready-to-grow/
		 */
		'104.192.143.192/28',
		'104.192.143.208/28'
	);

	/**
	 * Constructor
	 *
	 * @param   string  $ip  Ip
	 */
	public function __construct($ip)
	{
		$this->ip = trim($ip);
	}

	/**
	 * Get the array of valid IP ranges
	 *
	 * @return  array
	 */
	public function getValidRanges()
	{
		return $this->validIpRanges;
	}

	/**
	 * Check if this ip is valid
	 *
	 * @return  boolean
	 */
	public function isValid()
	{
		if (!$this->hasValidFormat())
		{
			return false;
		}

		$validIpRanges = $this->getValidRanges();

		foreach ($validIpRanges as $range)
		{
			if ($this->inRange($range))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if current ip has the right format
	 *
	 * @return  boolean
	 */
	public function hasValidFormat()
	{
		if (!$this->ip)
		{
			return false;
		}

		if (filter_var($this->ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * Check if this ip is in a range
	 *
	 * @param   string  $range  Range in format '131.103.20.160/27'
	 *
	 * @return  boolean
	 */
	public function inRange($range)
	{
		if (strpos($range, '/') == false )
		{
			$range .= '/32';
		}

		// $range is in IP/CIDR format eg 127.0.0.1/24
		list($range, $netmask) = explode('/', $range, 2);

		$rangeDecimal = ip2long($range);

		$ipDecimal = ip2long($this->ip);

		$wildcardDecimal = pow(2, (32 - $netmask)) - 1;

		$netmaskDecimal = ~ $wildcardDecimal;

		return (($ipDecimal & $netmaskDecimal) == ($rangeDecimal & $netmaskDecimal));
	}

	/**
	 * Set the list of valid ip ranges
	 *
	 * @param   array  $ranges  Ranges in format: array('131.103.20.160/27', '165.254.145.0/26');
	 *
	 * @return  self
	 */
	public function setValidIpRanges(array $ranges)
	{
		$this->validIpRanges  = $ranges;

		return $this;
	}
}
