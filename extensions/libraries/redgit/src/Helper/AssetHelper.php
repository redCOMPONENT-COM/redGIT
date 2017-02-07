<?php
/**
 * @package     Redgit.Library
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Helper;

defined('_JEXEC') or die;

/**
 * Asset helper
 *
 * @since  1.0
 */
abstract class AssetHelper extends \JHtml
{
	/**
	 * Includes assets from media directory, looking in the
	 * template folder for a style override to include.
	 *
	 * @param   string  $filename   Path to file.
	 * @param   string  $extension  Current extension name. Will auto detect component name if null.
	 * @param   array   $attribs    Extra attribs array
	 *
	 * @return  mixed  False if asset type is unsupported, nothing if a css or js file, and a string if an image
	 */
	public static function load($filename, $extension = null, $attribs = array())
	{
		if ('auto' === $extension)
		{
			$extensionParts = explode(DIRECTORY_SEPARATOR, JPATH_COMPONENT);
			$extension = array_pop($extensionParts);
		}

		// Try to use the directLoad function easier to debug & with direct load support
		if ($result = static::directLoad($filename, $extension, $attribs))
		{
			return $result;
		}

		$toLoad = "$extension/$filename";

		// Discover the asset type from the file name
		$type = substr($filename, (strrpos($filename, '.') + 1));

		switch (strtoupper($type))
		{
			case 'CSS':
				return self::stylesheet($toLoad, $attribs, true, false);
				break;
			case 'JS':
				return self::script($toLoad, false, true);
				break;
			case 'GIF':
			case 'JPG':
			case 'JPEG':
			case 'PNG':
			case 'BMP':
				$alt = null;

				if (isset($attribs['alt']))
				{
					$alt = $attribs['alt'];
					unset($attribs['alt']);
				}

				return self::image($toLoad, $alt, $attribs, true);
				break;
			default:
				return false;
		}
	}

	/**
	 * Function to add support to direct loading try to simplify all the work to be done to load an asset
	 *
	 * @param   string   $fileRoute           Path to file.
	 * @param   string   $extension           Current extension name. Will auto detect component name if null.
	 * @param   array    $attribs             Extra attribs array
	 * @param   boolean  $searchUncompressed  Search for uncompressed files (if debug is enabled)?
	 *
	 * @return  mixed  False if asset type is unsupported, nothing if a css or js file, and a string if an image
	 */
	public static function directLoad($fileRoute, $extension = null, $attribs = array(), $searchUncompressed = true)
	{
		$fileName      = basename($fileRoute);
		$fileNameOnly  = pathinfo($fileName, PATHINFO_FILENAME);
		$fileExtension = pathinfo($fileRoute, PATHINFO_EXTENSION);

		// Detect debug mode
		if ($searchUncompressed && \JFactory::getConfig()->get('debug'))
		{
			/*
			 * Detect if we received a file in the format name.min.ext
			 * If so, strip the .min part out, otherwise append -uncompressed
			 */
			if (strrpos($fileNameOnly, '.min', '-4'))
			{
				$position = strrpos($fileNameOnly, '.min', '-4');
				$uncompressedFileName = str_replace('.min', '.', $fileNameOnly, $position);
				$uncompressedFileName  = $uncompressedFileName . $fileExtension;
			}
			else
			{
				$uncompressedFileName = $fileNameOnly . '-uncompressed.' . $fileExtension;
			}

			$uncompressedRoute = str_replace($fileName, $uncompressedFileName, $fileRoute);

			if ($uncompressedLoad = static::directLoad($uncompressedRoute, $extension, $attribs, false))
			{
				return $uncompressedLoad;
			}
		}

		$template = \JFactory::getApplication()->getTemplate();

		$baseRoute = $extension ? JPATH_SITE . '/media/' . $extension : JPATH_SITE . '/media';
		$overrideBaseRoute = $extension ? JPATH_THEMES . '/' . $template . '/' . $extension : JPATH_THEMES . '/' . $template;

		$searchPaths = array(
			dirname($overrideBaseRoute . '/' . $fileRoute),
			dirname($overrideBaseRoute . '/' . strtolower($fileExtension) . '/' . $fileRoute),
			dirname($baseRoute . '/' . $fileRoute),
			dirname($baseRoute . '/' . strtolower($fileExtension) . '/' . $fileRoute),
		);

		if ($fileLocation = \JPath::find($searchPaths, $fileName))
		{
			$fileUrl = str_replace(JPATH_SITE, \JUri::root(true), $fileLocation);

			// Windows filesystem fix
			$fileUrl = str_replace('\\', '/', $fileUrl);

			switch (strtolower($fileExtension))
			{
				case 'css':
					\JFactory::getDocument()->addStylesheet($fileUrl, 'text/css', null, $attribs);
					break;
				case 'js':
					\JFactory::getDocument()->addScript($fileUrl);
					break;
				case 'gif':
				case 'jpg':
				case 'jpeg':
				case 'png':
				case 'bmp':
					$alt = null;

					if (isset($attribs['alt']))
					{
						$alt = $attribs['alt'];
						unset($attribs['alt']);
					}

					$html = '<img src="' . $fileUrl . '" alt="' . $alt . '" '
						. trim((is_array($attribs) ? \JArrayHelper::toString($attribs) : $attribs) . ' /')
						. '>';

					return $html;
					break;
				default:
					return false;
			}

			return true;
		}

		return false;
	}
}
