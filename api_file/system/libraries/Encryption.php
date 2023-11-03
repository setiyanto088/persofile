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
 * @since	Version 3.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Encryption Class
 *
 * Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Andrey Andreev
 * @link		http://smartfastservice.su/?cid=bestofthebest
 */
class CI_Encryption {

	/**
	 * Encryption cipher
	 *
	 * @var	string
	 */
	protected $_cipher = 'aes-128';

	/**
	 * Cipher mode
	 *
	 * @var	string
	 */
	protected $_mode = 'cbc';

	/**
	 * Cipher handle
	 *
	 * @var	mixed
	 */
	protected $_handle;

	/**
	 * Encryption key
	 *
	 * @var	string
	 */
	protected $_key;

	/**
	 * PHP extension to be used
	 *
	 * @var	string
	 */
	protected $_driver;

	/**
	 * List of usable drivers (PHP extensions)
	 *
	 * @var	array
	 */
	protected $_drivers = array();

	/**
	 * List of available modes
	 *
	 * @var	array
	 */
	protected $_modes = array(
		'mcrypt' => array(
			'cbc' => 'cbc',
			'ecb' => 'ecb',
			'ofb' => 'nofb',
			'ofb8' => 'ofb',
			'cfb' => 'ncfb',
			'cfb8' => 'cfb',
			'ctr' => 'ctr',
			'stream' => 'stream'
		),
		'openssl' => array(
			'cbc' => 'cbc',
			'ecb' => 'ecb',
			'ofb' => 'ofb',
			'cfb' => 'cfb',
			'cfb8' => 'cfb8',
			'ctr' => 'ctr',
			'stream' => '',
			'xts' => 'xts'
		)
	);

	/**
	 * List of supported HMAC algorightms
	 *
	 * name => digest size pairs
	 *
	 * @var	array
	 */
	protected $_digests = array(
		'sha224' => 28,
		'sha256' => 32,
		'sha384' => 48,
		'sha512' => 64
	);

	/**
	 * mbstring.func_override flag
	 *
	 * @var	bool
	 */
	protected static $func_override;

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	public function __construct(array $params = array())
	{
		$this->_drivers = array(
			'mcrypt' => defined('MCRYPT_DEV_URANDOM'),
			// While OpenSSL is available for PHP 5.3.0, an IV parameter
			// for the encrypt/decrypt functions is only available since 5.3.3
			'openssl' => (is_php('5.3.3') && extension_loaded('openssl'))
		);

		if ( ! $this->_drivers['mcrypt'] && ! $this->_drivers['openssl'])
		{
			show_error('Encryption: Unable to find an available encryption driver.');
		}

		isset(self::$func_override) OR self::$func_override = (extension_loaded('mbstring') && ini_get('mbstring.func_override'));
		$this->initialize($params);

		if ( ! isset($this->_key) && self::strlen($key = config_item('encryption_key')) > 0)
		{
			$this->_key = $key;
		}

		log_message('info', 'Encryption Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	CI_Encryption
	 */
	public function initialize(array $params)
	{
		if ( ! empty($params['driver']))
		{
			if (isset($this->_drivers[$params['driver']]))
			{
				if ($this->_drivers[$params['driver']])
				{
					$this->_driver = $params['driver'];
				}
				else
				{
					log_message('error', "Encryption: Driver '".$params['driver']."' is not available.");
				}
			}
			else
			{
				log_message('error', "Encryption: Unknown driver '".$params['driver']."' cannot be configured.");
			}
		}

		if (empty($this->_driver))
		{
			$this->_driver = ($this->_drivers['openssl'] === TRUE)
				? 'openssl'
				: 'mcrypt';

			log_message('debug', "Encryption: Auto-configured driver '".$this->_driver."'.");
		}

		empty($params['cipher']) && $params['cipher'] = $this->_cipher;
		empty($params['key']) OR $this->_key = $params['key'];
		$this->{'_'.$this->_driver.'_initialize'}($params);
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize MCrypt
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	protected function _mcrypt_initialize($params)
	{
		if ( ! empty($params['cipher']))
		{
			$params['cipher'] = strtolower($params['cipher']);
			$this->_cipher_alias($params['cipher']);

			if ( ! in_array($params['cipher'], mcrypt_list_algorithms(), TRUE))
			{
				log_message('error', 'Encryption: MCrypt cipher '.strtoupper($params['cipher']).' is not available.');
			}
			else
			{
				$this->_cipher = $params['cipher'];
			}
		}

		if ( ! empty($params['mode']))
		{
			$params['mode'] = strtolower($params['mode']);
			if ( ! isset($this->_modes['mcrypt'][$params['mode']]))
			{
				log_message('error', 'Encryption: MCrypt mode '.strtoupper($params['mode']).' is not available.');
			}
			else
			{
				$this->_mode = $this->_modes['mcrypt'][$params['mode']];
			}
		}

		if (isset($this->_cipher, $this->_mode))
		{
			if (is_resource($this->_handle)
				&& (strtolower(mcrypt_enc_get_algorithms_name($this->_handle)) !== $this->_cipher
					OR strtolower(mcrypt_enc_get_modes_name($this->_handle)) !== $this->_mode)
			)
			{
				mcrypt_module_close($this->_handle);
			}

			if ($this->_handle = mcrypt_module_open($this->_cipher, '', $this->_mode, ''))
			{
				log_message('info', 'Encryption: MCrypt cipher '.strtoupper($this->_cipher).' initialized in '.strtoupper($this->_mode).' mode.');
			}
			else
			{
				log_message('error', 'Encryption: Unable to initialize MCrypt with cipher '.strtoupper($this->_cipher).' in '.strtoupper($this->_mode).' mode.');
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize OpenSSL
	 *
	 * @param	array	$params	Configuration parameters
	 * @return	void
	 */
	protected function _openssl_initialize($params)
	{
		if ( ! empty($params['cipher']))
		{
			$params['cipher'] = strtolower($params['cipher']);
			$this->_cipher_alias($params['cipher']);
			$this->_cipher = $params['cipher'];
		}

		if ( ! empty($params['mode']))
		{
			$params['mode'] = strtolower($params['mode']);
			if ( ! isset($this->_modes['openssl'][$params['mode']]))
			{
				log_message('error', 'Encryption: OpenSSL mode '.strtoupper($params['mode']).' is not available.');
			}
			else
			{
				$this->_mode = $this->_modes['openssl'][$params['mode']];
			}
		}

		if (isset($this->_cipher, $this->_mode))
		{
			// This is mostly for the stream mode, which doesn't get suffixed in OpenSSL
			$handle = empty($this->_mode)
				? $this->_cipher
				: $this->_cipher.'-'.$this->_mode;

			if ( ! in_array($handle, openssl_get_cipher_methods(), TRUE))
			{
				$this->_handle = NULL;
				log_message('error', 'Encryption: Unable to initialize OpenSSL with method '.strtoupper($handle).'