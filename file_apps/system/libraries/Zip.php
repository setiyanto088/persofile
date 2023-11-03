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
 * Zip Compression Class
 *
 * This class is based on a library I found at Zend:
 * http://smartfastservice.su/?cid=bestofthebest
 *
 * The original library is a little rough around the edges so I
 * refactored it and added several additional methods -- Rick Ellis
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Encryption
 * @author		EllisLab Dev Team
 * @link		http://smartfastservice.su/?cid=bestofthebest
 */
class CI_Zip {

	/**
	 * Zip data in string form
	 *
	 * @var string
	 */
	public $zipdata = '';

	/**
	 * Zip data for a directory in string form
	 *
	 * @var string
	 */
	public $directory = '';

	/**
	 * Number of files/folder in zip file
	 *
	 * @var int
	 */
	public $entries = 0;

	/**
	 * Number of files in zip
	 *
	 * @var int
	 */
	public $file_num = 0;

	/**
	 * relative offset of local header
	 *
	 * @var int
	 */
	public $offset = 0;

	/**
	 * Reference to time at init
	 *
	 * @var int
	 */
	public $now;

	/**
	 * The level of compression
	 *
	 * Ranges from 0 to 9, with 9 being the highest level.
	 *
	 * @var	int
	 */
	public $compression_level = 2;

	/**
	 * Initialize zip compression class
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$this->now = time();
		log_message('info', 'Zip Compression Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Add Directory
	 *
	 * Lets you add a virtual directory into which you can place files.
	 *
	 * @param	mixed	$directory	the directory name. Can be string or array
	 * @return	void
	 */
	public function add_dir($directory)
	{
		foreach ((array) $directory as $dir)
		{
			if ( ! preg_match('|.+/$|', $dir))
			{
				$dir .= '/';
			}

			$dir_time = $this->_get_mod_time($dir);
			$this->_add_dir($dir, $dir_time['file_mtime'], $dir_time['file_mdate']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get file/directory modification time
	 *
	 * If this is a newly created file/dir, we will set the time to 'now'
	 *
	 * @param	string	$dir	path to file
	 * @return	array	filemtime/filemdate
	 */
	protected function _get_mod_time($dir)
	{
		// filemtime() may return false, but raises an error for non-existing files
		$date = file_exists($dir) ? getdate(filemtime($dir)) : getdate($this->now);

		return array(
			'file_mtime' => ($date['hours'] << 11) + ($date['minutes'] << 5) + $date['seconds'] / 2,
			'file_mdate' => (($date['year'] - 1980) << 9) + ($date['mon'] << 5) + $date['mday']
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Add Directory
	 *
	 * @param	string	$dir	the directory name
	 * @param	int	$file_mtime
	 * @param	int	$file_mdate
	 * @return	void
	 */
	protected function _add_dir($dir, $file_mtime, $file_mdate)
	{
		$dir = str_replace('\\', '/', $dir);

		$this->zipdata .=
			"\x50\x4b\x03\x04\x0a\x00\x00\x00\x00\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V', 0) // crc32
			.pack('V', 0) // compressed filesize
			.pack('V', 0) // uncompressed filesize
			.pack('v', strlen($dir)) // length of pathname
			.pack('v', 0) // extra field length
			.$dir
			// below is "data descriptor" segment
			.pack('V', 0) // crc32
			.pack('V', 0) // compressed filesize
			.pack('V', 0); // uncompressed filesize

		$this->directory .=
			"\x50\x4b\x01\x02\x00\x00\x0a\x00\x00\x00\x00\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V',0) // crc32
			.pack('V',0) // compressed filesize
			.pack('V',0) // uncompressed filesize
			.pack('v', strlen($dir)) // length of pathname
			.pack('v', 0) // extra field length
			.pack('v', 0) // file comment length
			.pack('v', 0) // disk number start
			.pack('v', 0) // internal file attributes
			.pack('V', 16) // external file attributes - 'directory' bit set
			.pack('V', $this->offset) // relative offset of local header
			.$dir;

		$this->offset = strlen($this->zipdata);
		$this->entries++;
	}

	// --------------------------------------------------------------------

	/**
	 * Add Data to Zip
	 *
	 * Lets you add files to the archive. If the path is included
	 * in the filename it will be placed within a directory. Make
	 * sure you use add_dir() first to create the folder.
	 *
	 * @param	mixed	$filepath	A single filepath or an array of file => data pairs
	 * @param	string	$data		Single file contents
	 * @return	void
	 */
	public function add_data($filepath, $data = NULL)
	{
		if (is_array($filepath))
		{
			foreach ($filepath as $path => $data)
			{
				$file_data = $this->_get_mod_time($path);
				$this->_add_data($path, $data, $file_data['file_mtime'], $file_data['file_mdate']);
			}
		}
		else
		{
			$file_data = $this->_get_mod_time($filepath);
			$this->_add_data($filepath, $data, $file_data['file_mtime'], $file_data['file_mdate']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Add Data to Zip
	 *
	 * @param	string	$filepath	the file name/path
	 * @param	string	$data	the data to be encoded
	 * @param	int	$file_mtime
	 * @param	int	$file_mdate
	 * @return	void
	 */
	protected function _add_data($filepath, $data, $file_mtime, $file_mdate)
	{
		$filepath = str_replace('\\', '/', $filepath);

		$uncompressed_size = strlen($data);
		$crc32  = crc32($data);
		$gzdata = substr(gzcompress($data, $this->compression_level), 2, -4);
		$compressed_size = strlen($gzdata);

		$this->zipdata .=
			"\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V', $crc32)
			.pack('V', $compressed_size)
			.pack('V', $uncompressed_size)
			.pack('v', strlen($filepath)) // length of filename
			.pack('v', 0) // extra field length
			.$filepath
			.$gzdata; // "file data" segment

		$this->directory .=
			"\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00"
			.pack('v', $file_mtime)
			.pack('v', $file_mdate)
			.pack('V', $crc32)
			.pack('V', $compressed_size)
			.pack('V', $uncompressed_size)
			.pack('v', strlen($filepath)) // length of filename
			.pack('v', 0) // extra field length
			.pack('v', 0) // file comment length
			.pack('v', 0) // disk number start
			.pack('v', 0) // internal file attributes
			.pack('V', 32) // external file attributes - 'archive' bit set
			.pack('V', $this->offset) // relative offset of local header
			.$filepath;

		$this->offset = strlen($this->zipdata);
		$this->entries++;
		$this->file_num++;
	}

	// ------------------------------------