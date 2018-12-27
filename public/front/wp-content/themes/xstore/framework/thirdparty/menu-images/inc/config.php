<?php
/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit;

function et_get_menu_fields() {
	global $wp_registered_sidebars;
	$sidebar_option = array(''=>'Select widget area');
	foreach ($wp_registered_sidebars as $key => $sidebar) {
		$sidebar_option[$key] = $sidebar['name'];
	}

    $blocks = array();
    $blocks[''] = "";  

    $posts = get_posts( array(
        'post_type' => 'staticblocks',
        'numberposts' => -1,
    ) );

    if ( $posts ) {
        foreach ( $posts as $post ) {
			$blocks[$post->ID] = $post->post_title;
        }
    }

	return array(
		array(
			'id' => 'disable_titles',
			'type' => 'checkbox',
			'title' => 'Disable navigation label',
			'width' => 'wide',
			'value' => 1,
			'levels' => array(0,1,2)
		),
		array(
			'id' => 'anchor',
			'type' => 'text',
			'title' => 'Anchor',
			'width' => 'wide'
		),
		array(
			'id' => 'design',
			'type' => 'select',
			'title' => 'Design',
			'width' => 'wide',
			'options' => array(
				'' => 'Select design option',
				'dropdown' => 'Dropdown',
				'mega-menu' => 'Mega menu',
				'posts-subcategories' => 'Subcategories + Posts',
				//'image-column' => 'Image column',
				//'image-no-space' => 'Image column no space',
			),
			'levels' => 0
		),
		array(
			'id' => 'columns',
			'type' => 'select',
			'title' => 'Columns',
			'width' => 'wide',
			'options' => array(
				2 => 2,
				3 => 3,
				4 => 4,
				5 => 5,
				6 => 6,
			),
			'levels' => 0
		),
		array(
			'id' => 'column_width',
			'type' => 'text',
			'title' => 'Column width (for ex.: 100%)',
			'width' => 'wide',
			'input_type' => 'number',
			'attributes' => array(
				'min' => 1,
				'max' => 300
			),
			'levels' => array(1)
		),
		array(
			'id' => 'column_height',
			'type' => 'text',
			'title' => 'Mega menu height (for ex.: 100px)',
			'width' => 'wide',
			'input_type' => 'number',
			'attributes' => array(
				'min' => 1,
				'max' => 1000
			),
			'levels' => array(0)
		),
		array(
			'id' => 'sublist_width',
			'type' => 'text',
			'title' => 'Mega menu container width (for ex.: 1000px)',
			'width' => 'wide',
			'input_type' => 'number',
			'attributes' => array(
				'min' => 1,
			),
			'levels' => array(0)
		),
		array(
			'id' => 'design2',
			'type' => 'select',
			'title' => 'Design',
			'width' => 'wide',
			'options' => array(
				'' => 'Select design option',
				'image' => 'Image',
				'image-no-borders' => 'Image without spacing',
				//'image-column' => 'Image column',
				//'image-no-space' => 'Image column no space',
			),
			'levels' => array(1,2)
		),
		/*array(
			'id' => 'block',
			'type' => 'select',
			'title' => 'Static block',
			'width' => 'wide',
			'options' => $blocks,
			'levels' => array(1)
		),*/
		array(
			'id' => 'static_block',
			'type' => 'select',
			'title' => 'Static block',
			'desc' => 'Don\'t create subitems if you use static block!',
			'width' => 'wide',
			'options' => $blocks,
			'levels' => array(0)
		),
		array(
			'id' => 'widget_area',
			'type' => 'select',
			'title' => 'Widget area',
			'width' => 'wide',
			'options' => $sidebar_option,
			'levels' => array(1,2)
		),
		array (
			'id' => 'open_by_click',
			'type' => 'checkbox',
			'title' => 'Open submenu by click',
			'width' => 'wide',
			'value' => 1,
			'levels' => array(0)
		),
		array(
			'id' => 'icon_type',
			'type' => 'select',
			'title' => 'Icons library',
			'width' => 'wide',
			'options' => array(
				'fontawesome' => 'FontAwesome',
				'xstore-icons' => 'XStore icons',
			),
		),
		array(
			'id' => 'icon',
			'type' => 'text',
			'title' => 'Icon name',
			'desc' => 'If you use FontAwesome icons library then FontAwesome support should be enabled in 8Theme Options -> General -> Optimization',
			'width' => 'wide',
		),
		array(
			'id' => 'label',
			'type' => 'select',
			'title' => 'Label',
			'width' => 'wide',
			'options' => array(
				'' => 'Select label',
				'hot' => 'Hot',
				'sale' => 'Sale',
				'new' => 'New',
			)
		),
		array(
			'id' => 'use_img',
			'type' => 'select',
			'title' => 'Use img like',
			'width' => 'thin',
			'options' => array(
				'background' => 'Background',
				'img' => 'Image',
			),
			'levels' => 0
		),
		array(
			'id' => 'background_repeat',
			'type' => 'select',
			'title' => 'Background Repeat',
			'width' => 'thin',
			'options' => array(
				'' => 'Background-repeat',
				'no-repeat' => 'No Repeat',
				'repeat' => 'Repeat All',
				'repeat-x' => 'Repeat Horizontally',
				'repeat-y' => 'Repeat Vertically',
				'inherit' => 'Inherit',
			),
			'levels' => array(0,1,2)
		),
		array(
			'id' => 'background_position',
			'type' => 'select',
			'title' => 'Background Position',
			'width' => 'thin',
			'options' => array(
				'' => 'Background-position',
				'left top' => 'Left Top',
				'left center' => 'Left Center',
				'left bottom' => 'Left Bottom',
				'center center' => 'Center Center',
				'center bottom' => 'Center Bottom',
				'right top' => 'Right Top',
				'right center' => 'Right Center',
				'right bottom' => 'Right Bottom',
			),
			'levels' => array(0,1,2)
		),

		array(
			'id' => 'item_visibility',
			'type' => 'select_default',
			'title' => 'Menu item is shown only for:',
			'width' => 'wide',
			'options' => array(
				'all' => 'All users',
				'logged' => 'Logged in users',
				'unlogged' => 'Unlogged users'
			),
		),
	);
}