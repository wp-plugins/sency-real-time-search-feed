<?php
/*
Plugin Name: Sency - Real Time Search
Description: This plugin is no longer supported
Author: Abandoned Plugins
Version: 1.2

Copyright 2009  Abandoned Plugins

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

----------------------------------------------------------------------------

Sency Terms Of Use: http://sency.com/terms.php

*/

if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
      define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
      define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
if ( ! defined( 'SENCY_URL' ) )
      define( 'SENCY_URL', WP_CONTENT_URL . '/plugins/sency-real-time-search-feed' );

if (class_exists('WP_Widget')) {
	class TP_Sency extends WP_Widget {
	
	    /** constructor */
	    function TP_Sency() {
	        parent::WP_Widget( false, $name = 'Sency - Real Time Search', $widget_options = array('description' => 'Display a scrolling search feed in your sidebar.' ) );
	    }

	    /** @see WP_Widget::widget */
	    function widget( $args, $instance ) {		
	        extract( $args );
			echo $before_widget;
			echo $before_title;
			echo $instance['top_text'];
			echo $after_title;
			
			if ( $instance['show_links'] == 'yes') :
				echo '<div id="sency-tabs">';
					echo '<div id="news-tab" style="float: left;"><a href="#news" class="on">News</a></div>';
					echo '<div id="link-tab" style="float: left;"><a href="#link" class="off">Popular Links</a></div>';
				echo '</div>';
			endif;
			echo '<div id="news_scroller" class="on">';
			echo '<style type="text/css">';
			echo '	ul#uu li#ll { height: auto !important; width: !important; }';
			echo '	ul#uu li#ll div.news_item { height: auto !important; width: auto !important; }';
			echo '</style>';
			echo '<script src="http://www.sency.com/scroll.php?';
				echo 'toptextcolor=';//.	urlencode( $instance['top_text_color'] );	// default = black		(acceptable values: %23000000 or black)
				echo '&topbgcolor=';//.	urlencode( $instance['top_bg_color'] );		// default = bgcolor	(acceptable values: %23ffffff or white)
				echo '&toptext='.		$instance['top_text'];						// default = keyword	(acceptable values: %23ffffff or white)
				echo '&top=off';//.			$instance['show_top'];						// default = off		(acceptable values: %23ffffff or white)
				echo '&src='.			$instance['show_src'];						// default = no			(acceptable values: yes or no)
				echo '&title='.			$instance['show_title'];					// default = off		(acceptable values: off or on)
				echo '&time='.			$instance['show_time'];						// default = on			(acceptable values: off or on)
				echo '&q='.				urlencode($instance['search_string']);		// default = news		(acceptable values: string value)
				echo '&textcolor='.		urlencode( $instance['text_color'] );		// default = black		(acceptable values: %23ffffff or white)
				echo '&textsize='.		$instance['text_size'];						// default = 12			(acceptable values: int value)
				echo '&bgcolor='.		urlencode( $instance['bg_color'] );			// default = white		(acceptable values: %23ffffff or white)
				echo '&h='.				$instance['height'];						// default = 300		(acceptable values: int value)
				echo '&w='.				$instance['width'];							// default = 200		(acceptable values: int value)
				echo '&border='.		$instance['show_border'];					// default = yes		(acceptable values: yes or no)
				echo '&bordercolor='.	urlencode( $instance['border_color'] );		// default = black		(acceptable values: %23ffffff or white)
				echo '&urlcolor='.		urlencode( $instance['link_color'] );		// default = black		(acceptable values: %23ffffff or white)
			echo '"></script>';
			echo '</div>';
			if ( $instance['show_links'] == 'yes') :
				echo '<div id="popularlinks">';
				echo '<script src="http://www.sency.com/popularlinks.php?';
					echo 'results='.		$instance['num_links'];						// default = 10			(acceptable values: int value)
					echo '&q='.				urlencode($instance['search_string']);		// default = news		(acceptable values: string value)
					echo '&charcount='.		$instance['link_length'];					// default = 50			(acceptable values: int value)
					echo '&w='.				$instance['width'];							// default = 250		(acceptable values: int value)
					echo '&height='.		$instance['height'];						// default = 600		(acceptable values: int value)
				echo '"></script>';
				echo '</div>';
			endif;
			echo $after_widget;
	    }

	    /** @see WP_Widget::update */
	    function update( $new_instance, $old_instance ) {				
	        return $new_instance;
	    }
	
		/** @see WP_Widget::form */
	    function form( $instance ) {
			
			// Global
			$width 				=!empty( $instance['width'] )			? esc_attr( $instance['width'] )			: '200';
			$height 			=!empty( $instance['height'] )			? esc_attr( $instance['height'] )			: '300';
			$text_size 			=!empty( $instance['text_size'] )		? esc_attr( $instance['text_size'] )		: '12';
			$text_color 		=!empty( $instance['text_color'] )		? esc_attr( $instance['text_color'] )		: '#000000';
			$bg_color 			=!empty( $instance['bg_color'] )		? esc_attr( $instance['bg_color'] )			: '#ffffff';
			$show_border 		=!empty( $instance['show_border'] )		? esc_attr( $instance['show_border'] )		: 'yes';
			$border_color 		=!empty( $instance['border_color'] )	? esc_attr( $instance['border_color'] )		: '#000000';
			$link_color 		=!empty( $instance['link_color'] )		? esc_attr( $instance['link_color'] )		: '#000000';
			
			// Header
			// $show_top 			=!empty( $instance['show_top'] )		? esc_attr( $instance['show_top'] )			: 'off';
			$top_text 			=!empty( $instance['top_text'] )		? esc_attr( $instance['top_text'] )			: '';
			// $top_text_color 	=!empty( $instance['top_text_color'] )	? esc_attr( $instance['top_text_color'] ) 	: '#000000';
			// $top_bg_color 		=!empty( $instance['top_bg_color'] )	? esc_attr( $instance['top_bg_color'] ) 	: '#ffffff';
			
			// Result Specific
			$show_src 			=!empty( $instance['show_src'] )		? esc_attr( $instance['show_src'] )			: 'no';
			$show_title 		=!empty( $instance['show_title'] )		? esc_attr( $instance['show_title'] )		: 'off';
			$show_time 			=!empty( $instance['show_time'] )		? esc_attr( $instance['show_time'] )		: 'on';
			
			// Search Term
			$search_string 		=!empty( $instance['search_string'] )	? esc_attr( $instance['search_string'] )	: 'news';
			
			// Popular Links
			$show_links 		=!empty( $instance['show_links'] )		? esc_attr( $instance['show_links'] )	: 'no';
			$num_links	 		=!empty( $instance['num_links'] )		? esc_attr( $instance['num_links'] )	: '10';
			$link_length 		=!empty( $instance['link_length'] )		? esc_attr( $instance['link_length'] )	: '50';
?>
				<!-- Header Text (widgettitle) -->
				<p><label for="<?php echo $this->get_field_id('top_text'); ?>"><?php _e('Title:'); ?><br />
					<input id="<?php echo $this->get_field_id('top_text'); ?>" name="<?php echo $this->get_field_name('top_text'); ?>" type="text" style="width: 100%;" value="<?php echo ($top_text == '') ? $search_string : $top_text; ?>" />
				</label></p>
				
				<!-- KEYWORD (Search String) -->
				<p><label for="<?php echo $this->get_field_id('search_string'); ?>"><?php _e('Search Term:'); ?><br />
					<input id="<?php echo $this->get_field_id('search_string'); ?>" name="<?php echo $this->get_field_name('search_string'); ?>" type="text" style="width: 100%;" value="<?php echo $search_string; ?>" />
				</label></p>
				
				<!-- GLOBAL OPTIONS (Width/Height) -->
				<div class="s-option-header">
					<h3>Display Size</h3>
					<div class="s-option-body">
						<p><label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Width:'); ?><br />
							<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" style="width: 100%;" value="<?php echo $width; ?>" />
						</label></p>
						<p><label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Height:'); ?><br />
							<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" style="width: 100%;" value="<?php echo $height; ?>" />
						</label></p>
					</div>
				</div>
				
				<!-- GLOBAL OPTIONS (Text SIze/Text Color/Link Color) -->
				<div class="s-option-header">
					<h3>Text Options</h3>
					<div class="s-option-body">
						<p><label for="<?php echo $this->get_field_id('text_size'); ?>"><?php _e('Text Size:'); ?><br />
							<input id="<?php echo $this->get_field_id('text_size'); ?>" name="<?php echo $this->get_field_name('text_size'); ?>" type="text" style="width: 100%;" value="<?php echo $text_size; ?>" />
						</label></p>
						<p><label for="<?php echo $this->get_field_id('text_color'); ?>"><?php _e('Text Color:'); ?> <a href="javascript:return false;" onclick="toggleColorpicker (this, '<?php echo $this->get_field_id('text_color'); ?>', 'open', '<?php _e('show color picker'); ?>', '<?php _e('hide color picker'); ?>')"><?php _e('show color picker'); ?></a><br />
							<div id="<?php echo $this->get_field_id('text_color'); ?>_colorpicker" class="colorpicker_container"></div>
							<input id="<?php echo $this->get_field_id('text_color'); ?>" name="<?php echo $this->get_field_name('text_color'); ?>" type="text" style="width: 100%;" value="<?php echo $text_color; ?>" />
						</label></p>
						<p><label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Show Title:'); ?><br />
							<select id="<?php echo $this->get_field_id('show_title'); ?>" name="<?php echo $this->get_field_name('show_title'); ?>" style="width: 100%;">
								<option value="yes"<?php echo ($show_title == 'yes' ? ' selected' : '');?>>Yes</option>
								<option value="no"<?php echo ($show_title == 'no' ? ' selected' : '');?>>No</option>
							</select>
						</label></p>
						<p><label for="<?php echo $this->get_field_id('show_src'); ?>"><?php _e('Show Source:'); ?><br />
							<select id="<?php echo $this->get_field_id('show_src'); ?>" name="<?php echo $this->get_field_name('show_src'); ?>" style="width: 100%;">
								<option value="yes"<?php echo ($show_src == 'yes' ? ' selected' : '');?>>Yes</option>
								<option value="no"<?php echo ($show_src == 'no' ? ' selected' : '');?>>No</option>
							</select>
						</label></p>
						<p><label for="<?php echo $this->get_field_id('show_time'); ?>"><?php _e('Show Time:'); ?><br />
							<select id="<?php echo $this->get_field_id('show_time'); ?>" name="<?php echo $this->get_field_name('show_time'); ?>" style="width: 100%;">
								<option value="yes"<?php echo ($show_time == 'yes' ? ' selected' : '');?>>Yes</option>
								<option value="no"<?php echo ($show_time == 'no' ? ' selected' : '');?>>No</option>
							</select>
						</label></p>
						<p><label for="<?php echo $this->get_field_id('link_color'); ?>"><?php _e('Link Color:'); ?> <a href="javascript:return false;" onclick="toggleColorpicker (this, '<?php echo $this->get_field_id('link_color'); ?>', 'open', '<?php _e('show color picker'); ?>', '<?php _e('hide color picker'); ?>')"><?php _e('show color picker'); ?></a><br />
							<div id="<?php echo $this->get_field_id('link_color'); ?>_colorpicker" class="colorpicker_container"></div>
							<input id="<?php echo $this->get_field_id('link_color'); ?>" name="<?php echo $this->get_field_name('link_color'); ?>" type="text" style="width: 100%;" value="<?php echo $link_color; ?>" />
						</label></p>
					</div>
				</div>
				
				<!-- GLOBAL OPTIONS (BG Color) -->
				<div class="s-option-header">
					<h3>Background Color</h3>
					<div class="s-option-body">
					<p><label for="<?php echo $this->get_field_id('bg_color'); ?>"><?php _e('Background Color:'); ?> <a href="javascript:return false;" onclick="toggleColorpicker (this, '<?php echo $this->get_field_id('bg_color'); ?>', 'open', '<?php _e('show color picker'); ?>', '<?php _e('hide color picker'); ?>')"><?php _e('show color picker'); ?></a><br />
						<div id="<?php echo $this->get_field_id('bg_color'); ?>_colorpicker" class="colorpicker_container"></div>
						<input id="<?php echo $this->get_field_id('bg_color'); ?>" name="<?php echo $this->get_field_name('bg_color'); ?>" type="text" style="width: 100%;" value="<?php echo $bg_color; ?>" />
					</label></p>
					</div>
				</div>
				
				<!-- GLOBAL OPTIONS (Border/Border Color) -->
				<div class="s-option-header">
					<h3>Border</h3>
					<div class="s-option-body">
					<p><label for="<?php echo $this->get_field_id('show_border'); ?>"><?php _e('Show Border:'); ?><br />
						<select id="<?php echo $this->get_field_id('show_border'); ?>" name="<?php echo $this->get_field_name('show_border'); ?>" style="width: 100%;">
							<option value="yes"<?php echo ($show_border == 'yes' ? ' selected' : '');?>>Yes</option>
							<option value="no"<?php echo ($show_border == 'no' ? ' selected' : '');?>>No</option>
						</select>
					</label></p>
					<p><label for="<?php echo $this->get_field_id('border_color'); ?>"><?php _e('Border Color:'); ?> <a href="javascript:return false;" onclick="toggleColorpicker (this, '<?php echo $this->get_field_id('border_color'); ?>', 'open', '<?php _e('show color picker'); ?>', '<?php _e('hide color picker'); ?>')"><?php _e('show color picker'); ?></a><br />
						<div id="<?php echo $this->get_field_id('border_color'); ?>_colorpicker" class="colorpicker_container"></div>
						<input id="<?php echo $this->get_field_id('border_color'); ?>" name="<?php echo $this->get_field_name('border_color'); ?>" type="text" style="width: 100%;" value="<?php echo $border_color; ?>" />
					</label></p>
					</div>
				</div>
				
				<!-- GLOBAL OPTIONS (Show Links/Num Links/Link Length) -->
				<div class="s-option-header">
					<h3>Popular Link Options</h3>
					<div class="s-option-body">
						<p><label for="<?php echo $this->get_field_id('show_links'); ?>"><?php _e('Show Popular Links:'); ?><br />
							<select id="<?php echo $this->get_field_id('show_links'); ?>" name="<?php echo $this->get_field_name('show_links'); ?>" style="width: 100%;">
								<option value="yes"<?php echo ($show_links == 'yes' ? ' selected' : '');?>>Yes</option>
								<option value="no"<?php echo ($show_links == 'no' ? ' selected' : '');?>>No</option>
							</select>
						</label></p>
						<p><label for="<?php echo $this->get_field_id('num_links'); ?>"><?php _e('Number of Links:'); ?><br />
							<input id="<?php echo $this->get_field_id('num_links'); ?>" name="<?php echo $this->get_field_name('num_links'); ?>" type="text" style="width: 100%;" value="<?php echo $num_links; ?>" />
						</label></p>
						<p><label for="<?php echo $this->get_field_id('link_length'); ?>"><?php _e('Length of Links:'); ?><br />
							<input id="<?php echo $this->get_field_id('link_length'); ?>" name="<?php echo $this->get_field_name('link_length'); ?>" type="text" style="width: 100%;" value="<?php echo $link_length; ?>" />
						</label></p>
					</div>
				</div>
				<script type="text/javascript">
					jQuery(this).ready(function($) {
						$('div.s-option-body').hide();
					});
				</script>
		<?php
	    }

	} // class TP_Sency

	// register TP_Sency widget
	add_action('widgets_init', create_function('', 'return register_widget("TP_Sency");'));

	// add jquery and the color_picker
	add_action('init', 'install_jquery_scripts');
	function install_jquery_scripts() {
		
		// make sure we don't interfere with other plugins
		if (stripos($_SERVER['REQUEST_URI'],'widgets.php')!== false) {
			wp_enqueue_script('jquery');
			wp_enqueue_script('farbtastic');
			wp_enqueue_style('farbtastic');
		} else if (!is_admin()) {
			wp_enqueue_script('jquery');
		}
	}
	
	add_action('admin_head', 'admin_head_intercept');
	function admin_head_intercept () {
		
		if (stripos($_SERVER['REQUEST_URI'],'widgets.php')!== false) :
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				// hides as soon as the DOM is ready
				$('div.s-option-body').hide();
				
				// shows on clicking the noted link
				$('.s-option-header h3').live("click", function() {
					$(this).toggleClass("open");
					$(this).next("div").slideToggle();
					return false;
				});
			});

			function toggleColorpicker (link, id, toggledir, opentext, closetext) {
				jQuery('.colorpicker_container').hide();

				if (toggledir == "open") {
					jQuery('#'+id+'_colorpicker').farbtastic('#'+id);
					jQuery('#'+id+'_colorpicker').show();
					jQuery(link).replaceWith('<a href="javascript:return false;" onclick="toggleColorpicker (this, \''+id+'\', \'close\', \''+opentext+'\', \''+closetext+'\')">'+closetext+'</a>');
				} else {
					jQuery(link).replaceWith('<a href="javascript:return false;" onclick="toggleColorpicker (this, \''+id+'\', \'open\', \''+opentext+'\', \''+closetext+'\')">'+opentext+'</a>');
				}
			}
		</script>
		<style type="text/css">
			div.s-option-header h3 {
				border: 1px solid #e6e6e6;
				background: url(<?php echo SENCY_URL; ?>/toggle.gif) #f1f1f1 no-repeat scroll 3px 3px;
				-webkit-border-radius: 4px;
				-moz-border-radius: 4px;
				padding: 5px 5px 5px 30px;
				cursor: pointer;
			}
			div.s-option-header h3.open {
				background-position: 3px -37px;
			}
			div.s-option-body p label a {
				font-size: .8em;
				text-decoration: none;
				border-bottom: 1px dotted;
			}
		</style>
		<?php
		endif;
	}
	
	add_action('wp_head', 'wp_head_intercept');
	function wp_head_intercept() { ?>
		<meta name="generator" content="Think-Press, Sency - Real Time Search v1.2" />
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$('div#popularlinks').hide();
				
				// shows on clicking the noted link
				$('div#sency-tabs #news-tab').click(function() {
					$('div#popularlinks').hide();
					$('div#news_scroller').show();
					return false;
				});
				// shows on clicking the noted link
				$('div#sency-tabs #link-tab').click(function() {
					$('div#news_scroller').hide();
					$('div#popularlinks').show();
					return false;
				});
			});
		</script>
		<style type="text/css">
			div#sency-tabs {
				margin-top: 5px;
			}
			div#sency-tabs div#news-tab,
			div#sency-tabs div#link-tab {
				margin-right: 5px;
				padding: 2px 5px;
				background: #ddd;
			}
			div#sency-tabs div.clear {
				clear: both;
			}
		</style>
	<?php
	}
}
?>
