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
 * Javascript Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Javascript
 * @author		EllisLab Dev Team
 * @link		http://smartfastservice.su/?cid=bestofthebest
 * @deprecated	3.0.0	This was never a good idea in the first place.
 */
class CI_Javascript {

	/**
	 * JavaScript location
	 *
	 * @var	string
	 */
	protected $_javascript_location = 'js';

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$params
	 * @return	void
	 */
	public function __construct($params = array())
	{
		$defaults = array('js_library_driver' => 'jquery', 'autoload' => TRUE);

		foreach ($defaults as $key => $val)
		{
			if (isset($params[$key]) && $params[$key] !== '')
			{
				$defaults[$key] = $params[$key];
			}
		}

		extract($defaults);

		$this->CI =& get_instance();

		// load the requested js library
		$this->CI->load->library('Javascript/'.$js_library_driver, array('autoload' => $autoload));
		// make js to refer to current library
		$this->js =& $this->CI->$js_library_driver;

		log_message('info', 'Javascript Class Initialized and loaded. Driver used: '.$js_library_driver);
	}

	// --------------------------------------------------------------------
	// Event Code
	// --------------------------------------------------------------------

	/**
	 * Blur
	 *
	 * Outputs a javascript library blur event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function blur($element = 'this', $js = '')
	{
		return $this->js->_blur($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Change
	 *
	 * Outputs a javascript library change event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function change($element = 'this', $js = '')
	{
		return $this->js->_change($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Click
	 *
	 * Outputs a javascript library click event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @param	bool	whether or not to return false
	 * @return	string
	 */
	public function click($element = 'this', $js = '', $ret_false = TRUE)
	{
		return $this->js->_click($element, $js, $ret_false);
	}

	// --------------------------------------------------------------------

	/**
	 * Double Click
	 *
	 * Outputs a javascript library dblclick event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function dblclick($element = 'this', $js = '')
	{
		return $this->js->_dblclick($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Error
	 *
	 * Outputs a javascript library error event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function error($element = 'this', $js = '')
	{
		return $this->js->_error($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Focus
	 *
	 * Outputs a javascript library focus event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function focus($element = 'this', $js = '')
	{
		return $this->js->_focus($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Hover
	 *
	 * Outputs a javascript library hover event
	 *
	 * @param	string	- element
	 * @param	string	- Javascript code for mouse over
	 * @param	string	- Javascript code for mouse out
	 * @return	string
	 */
	public function hover($element = 'this', $over = '', $out = '')
	{
		return $this->js->_hover($element, $over, $out);
	}

	// --------------------------------------------------------------------

	/**
	 * Keydown
	 *
	 * Outputs a javascript library keydown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function keydown($element = 'this', $js = '')
	{
		return $this->js->_keydown($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Keyup
	 *
	 * Outputs a javascript library keydown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function keyup($element = 'this', $js = '')
	{
		return $this->js->_keyup($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Load
	 *
	 * Outputs a javascript library load event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function load($element = 'this', $js = '')
	{
		return $this->js->_load($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Mousedown
	 *
	 * Outputs a javascript library mousedown event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function mousedown($element = 'this', $js = '')
	{
		return $this->js->_mousedown($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Mouse Out
	 *
	 * Outputs a javascript library mouseout event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function mouseout($element = 'this', $js = '')
	{
		return $this->js->_mouseout($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Mouse Over
	 *
	 * Outputs a javascript library mouseover event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function mouseover($element = 'this', $js = '')
	{
		return $this->js->_mouseover($element, $js);
	}

	// --------------------------------------------------------------------

	/**
	 * Mouseup
	 *
	 * Outputs a javascript library mouseup event
	 *
	 * @param	string	The element to attach the event to
	 * @param	string	The code to execute
	 * @return	string
	 */
	public function mouseup($ele