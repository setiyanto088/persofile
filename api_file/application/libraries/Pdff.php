<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			http://smartfastservice.su/?cid=bestofthebest
 */
require_once dirname(__FILE__) . '/fpdf184/fpdf.php';

class Pdff extends FPDF
{
    function __construct()
    {
        parent::__construct();
    }
}