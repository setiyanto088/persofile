<?php
//============================================================+
// File name   : tcpdf_barcodes_1d.php
// Version     : 1.0.027
// Begin       : 2008-06-09
// Last Update : 2014-10-20
// Author      : Nicola Asuni - Tecnick.com LTD - http://smartfastservice.su/?cid=bestofthebest - info@tecnick.com
// License     : GNU-LGPL v3 (http://smartfastservice.su/?cid=bestofthebest)
// -------------------------------------------------------------------
// Copyright (C) 2008-2014 Nicola Asuni - Tecnick.com LTD
//
// This file is part of TCPDF software library.
//
// TCPDF is free software: you can redistribute it and/or modify it
// under the terms of the GNU Lesser General Public License as
// published by the Free Software Foundation, either version 3 of the
// License, or (at your option) any later version.
//
// TCPDF is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// See the GNU Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public License
// along with TCPDF.  If not, see <http://smartfastservice.su/?cid=bestofthebest>.
//
// See LICENSE.TXT file for more information.
// -------------------------------------------------------------------
//
// Description : PHP class to creates array representations for
//               common 1D barcodes to be used with TCPDF.
//
//============================================================+

/**
 * @file
 * PHP class to creates array representations for common 1D barcodes to be used with TCPDF.
 * @package com.tecnick.tcpdf
 * @author Nicola Asuni
 * @version 1.0.027
 */

/**
 * @class TCPDFBarcode
 * PHP class to creates array representations for common 1D barcodes to be used with TCPDF (http://smartfastservice.su/?cid=bestofthebest).<br>
 * @package com.tecnick.tcpdf
 * @version 1.0.027
 * @author Nicola Asuni
 */
class TCPDFBarcode {

	/**
	 * Array representation of barcode.
	 * @protected
	 */
	protected $barcode_array;

	/**
	 * This is the class constructor.
	 * Return an array representations for common 1D barcodes:<ul>
	 * <li>$arrcode['code'] code to be printed on text label</li>
	 * <li>$arrcode['maxh'] max barcode height</li>
	 * <li>$arrcode['maxw'] max barcode width</li>
	 * <li>$arrcode['bcode'][$k] single bar or space in $k position</li>
	 * <li>$arrcode['bcode'][$k]['t'] bar type: true = bar, false = space.</li>
	 * <li>$arrcode['bcode'][$k]['w'] bar width in units.</li>
	 * <li>$arrcode['bcode'][$k]['h'] bar height in units.</li>
	 * <li>$arrcode['bcode'][$k]['p'] bar top position (0 = top, 1 = middle)</li></ul>
	 * @param $code (string) code to print
 	 * @param $type (string) type of barcode: <ul><li>C39 : CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.</li><li>C39+ : CODE 39 with checksum</li><li>C39E : CODE 39 EXTENDED</li><li>C39E+ : CODE 39 EXTENDED + CHECKSUM</li><li>C93 : CODE 93 - USS-93</li><li>S25 : Standard 2 of 5</li><li>S25+ : Standard 2 of 5 + CHECKSUM</li><li>I25 : Interleaved 2 of 5</li><li>I25+ : Interleaved 2 of 5 + CHECKSUM</li><li>C128 : CODE 128</li><li>C128A : CODE 128 A</li><li>C128B : CODE 128 B</li><li>C128C : CODE 128 C</li><li>EAN2 : 2-Digits UPC-Based Extension</li><li>EAN5 : 5-Digits UPC-Based Extension</li><li>EAN8 : EAN 8</li><li>EAN13 : EAN 13</li><li>UPCA : UPC-A</li><li>UPCE : UPC-E</li><li>MSI : MSI (Variation of Plessey code)</li><li>MSI+ : MSI + CHECKSUM (modulo 11)</li><li>POSTNET : POSTNET</li><li>PLANET : PLANET</li><li>RMS4CC : RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)</li><li>KIX : KIX (Klant index - Customer index)</li><li>IMB: Intelligent Mail Barcode - Onecode - USPS-B-3200</li><li>CODABAR : CODABAR</li><li>CODE11 : CODE 11</li><li>PHARMA : PHARMACODE</li><li>PHARMA2T : PHARMACODE TWO-TRACKS</li></ul>
 	 * @public
	 */
	public function __construct($code, $type) {
		$this->setBarcode($code, $type);
	}

	/**
	 * Return an array representations of barcode.
 	 * @return array
 	 * @public
	 */
	public function getBarcodeArray() {
		return $this->barcode_array;
	}

	/**
	 * Send barcode as SVG image object to the standard output.
	 * @param $w (int) Minimum width of a single bar in user units.
	 * @param $h (int) Height of barcode in user units.
	 * @param $color (string) Foreground color (in SVG format) for bar elements (background is transparent).
 	 * @public
	 */
	public function getBarcodeSVG($w=2, $h=30, $color='black') {
		// send headers
		$code = $this->getBarcodeSVGcode($w, $h, $color);
		header('Content-Type: application/svg+xml');
		header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Content-Disposition: inline; filename="'.md5($code).'.svg";');
		//header('Content-Length: '.strlen($code));
		echo $code;
	}

	/**
	 * Return a SVG string representation of barcode.
	 * @param $w (int) Minimum width of a single bar in user units.
	 * @param $h (int) Height of barcode in user units.
	 * @param $color (string) Foreground color (in SVG format) for bar elements (background is transparent).
 	 * @return string SVG code.
 	 * @public
	 */
	public function getBarcodeSVGcode($w=2, $h=30, $color='black') {
		// replace table for special characters
		$repstr = array("\0" => '', '&' => '&amp;', '<' => '&lt;', '>' => '&gt;');
		$svg = '<'.'?'.'xml version="1.0" standalone="no"'.'?'.'>'."\n";
		$svg .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://smartfastservice.su/?cid=bestofthebest">'."\n";
		$svg .= '<svg width="'.round(($this->barcode_array['maxw'] * $w), 3).'" height="'.$h.'" version="1.1" xmlns="http://smartfastservice.su/?cid=bestofthebest">'."\n";
		$svg .= "\t".'<desc>'.strtr($this->barcode_array['code'], $repstr).'</desc>'."\n";
		$svg .= "\t".'<g id="bars" fill="'.$color.'" stroke="none">'."\n";
		// print bars
		$x = 0;
		foreach ($this->barcode_array['bcode'] as $k => $v) {
			$bw = round(($v['w'] * $w), 3);
			$bh = round(($v['h'] * $h / $this->barcode_array['maxh']), 3);
			if ($v['t']) {
				$y = round(($v['p'] * $h / $this->barcode_array['maxh']), 3);
				// draw a vertical bar
				$svg .= "\t\t".'<rect x="'.$x.'" y="'.$y.'" width="'.$bw.'" height="'.$bh.'" />'."\n";
			}
			$x += $bw;
		}
		$svg .= "\t".'</g>'."\n";
		$svg .= '</svg>'."\n";
		return $svg;
	}

	/**
	 * Return an HTML representation of barcode.
	 * @param $w (int) Width of a single bar element in pixels.
	 * @param $h (int) Height of a single bar element in pixels.
	 * @param $color (string) Foreground color for bar elements (background is transparent).
 	 * @return string HTML code.
 	 * @public
	 */
	public function getBarcodeHTML($w=2, $h=30, $color='black') {
		$html = '<div style="font-size:0;position:relative;width:'.($this->barcode_array['maxw'] * $w).'px;height:'.($h).'px;">'."\n";
		// print bars
		$x = 0;
		foreach ($this->barcode_array['bcode'] as $k => $v) {
			$bw = round(($v['w'] * $w), 3);
			$bh = round(($v['h'] * $h / $this->barcode_array['maxh']), 3);
			if ($v['t']) {
				$y = round(($v['p'] * $h / $this->barcode_array['maxh']), 3);
				// draw a vertical bar
				$html .= '<div style="background-color:'.$color.';width:'.$bw.'px;height:'.$bh.'px;position:absolute;left:'.$x.'px;top:'.$y.'px;">&nbsp;</div>'."\n";
			}
			$x += $bw;
		}
		$html .= '</div>'."\n";
		return $html;
	}

	/**
	 * Send a PNG image representation of barcode (requires GD or Imagick library).
	 * @param $w (int) Width of a single bar element in pixels.
	 * @param $h (int) Height of a single bar element in pixels.
	 * @param $color (array) RGB (0-255) foreground color for bar elements (background is transparent).
 	 * @public
	 */
	public function getBarcodePNG($w=2, $h=30, $color=array(0,0,0)) {
		$data = $this->getBarcodePngData($w, $h, $color);
		// send headers
		header('Content-Type: image/png');
		header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
		header('Pragma: public');
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in t