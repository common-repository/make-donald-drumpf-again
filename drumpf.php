<?php

/**
* Plugin Name: Make Donald Drumpf Again
* Plugin URI: https://www.spokanewp.com/portfolio
* Description: Automatically replaces every instance of Donald Trump, Donald J. Trump and Mr. Trump with Donald Drumpf. We are not affiliated with HBO or Last Week Tonight.
* Author: Spokane WordPress Development
* Author URI: http://www.spokanewp.com
* Version: 1.1.0
* Text Domain: drumpf
*
* Copyright 2016 Spokane WordPress Development
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*
*/

namespace Drumpf;

class Controller {

	const VERSION = '1.1.0';
	const VERSION_JS = '1.1.0';
	const VERSION_CSS = '1.1.0';
	const DRUMPF = '<span class="drumpf" title="Make Donald Drumpf Again!">Donald Drumpf <a href="http://www.donaldjdrumpf.com/" target="_blank"><i class="fa fa-flag"></i></a></span>';

	public function init()
	{
		wp_enqueue_script( 'drumpf-js', plugin_dir_url( __FILE__ ) . 'drumpf.js', array( 'jquery' ), (WP_DEBUG) ? time() : self::VERSION_JS, TRUE );
		wp_enqueue_style( 'drumpf-css', plugin_dir_url( __FILE__ ) . 'drumpf.css', array(), (WP_DEBUG) ? time() : self::VERSION_CSS );
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css' );
	}

	public function replace_content( $content )
	{
		$content = str_replace( 'Donald Trump', self::DRUMPF, $content );
		$content = str_replace( 'Donald J. Trump', self::DRUMPF, $content );
		$content = str_replace( 'Mr. Trump', self::DRUMPF, $content );
		return $content;
	}
}

$controller = new Controller;

if ( ! is_admin() )
{
	/* enqueue js and css */
	add_action( 'init', array( $controller, 'init' ) );

	/* replace content */
	add_filter( 'the_content', array( $controller, 'replace_content' ) );
	add_filter( 'the_excerpt', array( $controller, 'replace_content' ) );
	add_filter( 'the_title', array( $controller, 'replace_content' ) );
	add_filter( 'widget_text', array( $controller, 'replace_content' ) );
	add_filter( 'widget_title', array( $controller, 'replace_content' ) );
	add_filter( 'comment_excerpt', array( $controller, 'replace_content' ) );
	add_filter( 'comment_text', array( $controller, 'replace_content' ) );
}