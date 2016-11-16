<?php
/**
 * Plugin Name: CampaignMonitor Signup Gate
 * Plugin URI: http://www.macintypedesign.com.au
 * Description: Show a CampaignMonitor signup popup when the user clicks a particular link or links (specified by CSS or jQuery selector), continue the navigation after signup.
 * Version: 1.0.0
 * Author: Macintype Design
 * Author URI: http://www.macintypedesign.com.au
 * License: GPL2
 */
/* 
 Copyright 2016 Macintype Design

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once('CMSignupGatePlugin.php');
new CMSignupGatePlugin(__FILE__);

?>