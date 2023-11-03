<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2015, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://smartfastservice.su/?cid=bestofthebest)
 * @copyright	Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://smartfastservice.su/?cid=bestofthebest)
 * @license	http://smartfastservice.su/?cid=bestofthebest	MIT License
 * @link	http://smartfastservice.su/?cid=bestofthebest
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Text Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://smartfastservice.su/?cid=bestofthebest
 */

// ------------------------------------------------------------------------

if ( ! function_exists('word_limiter'))
{
	/**
	 * Word Limiter
	 *
	 * Limits a string to X number of words.
	 *
	 * @param	string
	 * @param	int
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	function word_limiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) === '')
		{
			return $str;
		}

		preg_match('/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/', $str, $matches);

		if (strlen($str) === strlen($matches[0]))
		{
			$end_char = '';
		}

		return rtrim($matches[0]).$end_char;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('character_limiter'))
{
	/**
	 * Character Limiter
	 *
	 * Limits the string based on the character count.  Preserves complete words
	 * so the character count may not be exactly as specified.
	 *
	 * @param	string
	 * @param	int
	 * @param	string	the end character. Usually an ellipsis
	 * @return	string
	 */
	function character_limiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (mb_strlen($str) < $n)
		{
			return $str;
		}

		// a bit complicated, but faster than preg_replace with \s+
		$str = preg_replace('/ {2,}/', ' ', str_replace(array("\r", "\n", "\t", "\x0B", "\x0C"), ' ', $str));

		if (mb_strlen($str) <= $n)
		{
			return $str;
		}

		$out = '';
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';

			if (mb_strlen($out) >= $n)
			{
				$out = trim($out);
				return (mb_strlen($out) === mb_strlen($str)) ? $out : $out.$end_char;
			}
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ascii_to_entities'))
{
	/**
	 * High ASCII to Entities
	 *
	 * Converts high ASCII text and MS Word special characters to character entities
	 *
	 * @param	string	$str
	 * @return	string
	 */
	function ascii_to_entities($str)
	{
		$out = '';
		for ($i = 0, $s = strlen($str) - 1, $count = 1, $temp = array(); $i <= $s; $i++)
		{
			$ordinal = ord($str[$i]);

			if ($ordinal < 128)
			{
				/*
					If the $temp array has a value but we have moved on, then it seems only
					fair that we output that entity and restart $temp before continuing. -Paul
				*/
				if (count($temp) === 1)
				{
					$out .= '&#'.array_shift($temp).';';
					$count = 1;
				}

				$out .= $str[$i];
			}
			else
			{
				if (count($temp) === 0)
				{
					$count = ($ordinal < 224) ? 2 : 3;
				}

				$temp[] = $ordinal;

				if (count($temp) === $count)
				{
					$number = ($count === 3)
						? (($temp[0] % 16) * 4096) + (($temp[1] % 64) * 64) + ($temp[2] % 64)
						: (($temp[0] % 32) * 64) + ($temp[1] % 64);

					$out .= '&#'.$number.';';
					$count = 1;
					$temp = array();
				}
				// If this is the last iteration, just output whatever we have
				elseif ($i === $s)
				{
					$out .= '&#'.implode(';', $temp).';';
				}
			}
		}

		return $out;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('entities_to_ascii'))
{
	/**
	 * Entities to ASCII
	 *
	 * Converts character entities back to ASCII
	 *
	 * @param	string
	 * @param	bool
	 * @return	string
	 */
	function entities_to_ascii($str, $all = TRUE)
	{
		if (preg_match_all('/\&#(\d+)\;/', $str, $matches))
		{
			for ($i = 0, $s = count($matches[0]); $i < $s; $i++)
			{
				$digits = $matches[1][$i];
				$out = '';

				if ($digits < 128)
				{
					$out .= chr($digits);

				}
				elseif ($digits < 2048)
				{
					$out .= chr(192 + (($digits - ($digits % 64)) / 64)).chr(128 + ($digits % 64));
				}
				else
				{
					$out .= chr(224 + (($digits - ($digits % 4096)) / 4096))
						.chr(128 + ((($digits % 4096) - ($digits % 64)) / 64))
						.chr(128 + ($digits % 64));
				}

				$str = str_replace($matches[0][$i], $out, $str);
			}
		}

		if ($all)
		{
			return str_replace(
				array('&amp;', '&lt;', '&gt;', '&quot;', '&apos;', '&#45;'),
				array('&', '<', '>', '"', "'", '-'),
				$str
			);
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('word_censor'))
{
	/**
	 * Word Censoring Function
	 *
	 * Supply a string and an array of disallowed words and any
	 * matched words will be converted to #### or to the replacement
	 * word you've submitted.
	 *
	 * @param	string	the text string
	 * @param	string	the array of censoered words
	 * @param	string	the optional replacement value
	 * @return	string
	 */
	function word_censor($str, $censored, $replacement = '')
	{
		if ( ! is_array($censored))
		{
			return $str;
		}

		$str = ' '.$str.' ';

		// \w, \b and a few others do not match on a unicode character
		// set for performance reasons. As a result words like über
		// will not match on a word boundary. Instead, we'll assume that
		// a bad word will be bookeneded by any of these characters.
		$delim = '[-_\'\"`(){}<>\[\]|!?@#%&,.:;^~*+=\/ 0-9\n\r\t]';

		foreach ($censored as $badword)
		{
			if ($replacement !== '')
			{
				$str = preg_replace("/({$delim})(".str_replace('\*', '\w*?', preg_quote($badword, '/')).")({$delim})/i", "\\1{$replacement}\\3", $str);
			}
			else
			{
				$str = preg_replace("/({$delim})(".str_replace('\*', '\w*?', preg_quote($badword, '/')).")({$delim})/ie", "'\\1'.str_repeat('#', strlen('\\2')).'\\3'", $str);
			}
		}

		return trim($str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('highlight_code'))
{
	/**
	 * Code Highlighter
	 *
	 * Colorizes code strings
	 *
	 * @param	string	the text string
	 * @return	string
	 */
	function highlight_code($str)
	{
		/* The highlight string function encodes and highlights
		 * brackets so we need them to start raw.
		 *
		 * Also replace any existing PHP tags to temporary markers
		 * so they don't accidentally break the string out of PHP,
		 * and thus, thwart the highlighting.
		 */
		$str = str_replace(
			array('&lt;', '&gt;', '<?', '?>', '<%', '%>', '\\', '</script>'),
			array('<', '>', 'phptagopen', 'phptagclose', 'asptagopen', 'asptagclose', 'backslashtmp', 'scriptclose'),
			$str
		);

		// The highlight_string function requires that the text b