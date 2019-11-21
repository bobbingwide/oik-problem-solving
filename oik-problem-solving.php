<?php
/*
Plugin Name: oik-problem-solving
Plugin URI: https://www.oik-plugins.com/oik-plugins/oik-problem-solving
Description: Custom Post Types for Problem Solving
Depends: oik base plugin, oik-fields
Version: 0.0.1
Author: bobbingwide
Author URI: https://www.bobbingwide.com/about-bobbing-wide
License: GPL2

    Copyright 2019 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

/**
 * Implement "oik_fields_loaded" action for oik-sites
 */
function oik_problem_solving_init( ) {
	oik_register_questions();
	oik_register_problems();
}

/**
 * Register custom post type "question"
 *
 * Fields for the question are
 * _step_ref - noderef to zero or more _oik_presentation posts
 */
function oik_register_questions() {
	$post_type = 'question';
	$post_type_args = array();
	$post_type_args['label'] = 'Questions';
	$post_type_args['description'] = 'Problem Solving questions. e.g. Has it ever worked?';
	$post_type_args['hierarchical'] = true;
	$post_type_args['has_archive'] = true;
	$post_type_args['supports'] = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes', 'publicize', 'author', 'clone' );
	$post_type_args['show_in_rest'] = true;
    $post_type_args['template'] = oik_questions_CPT_template();
	//$post_type_args = oik_sites_capabilities( $post_type_args );
	bw_register_post_type( $post_type, $post_type_args );
	bw_register_field( "_step_ref", "noderef", "Reference",
		array( '#type' => 'oik_presentation', '#optional' => true, '#multiple' => 34 )  );
	bw_register_field_for_object_type( "_step_ref", $post_type );
	add_filter( "manage_edit-${post_type}_columns", "oik_problem_columns", 10, 1 );
}

function oik_questions_CPT_template() {
    $template = array();
    $template[] = ['core/heading', [ 'content' => "Response:" ] ];
    $template[] = ['core/paragraph', ['placeholder' => 'Type some responses to the question.' ]];
    $template[] = ['core/more' ];
    $template[] = ['core/heading', [ 'content' => "Reference:" ] ];
    $template[] = ['core/shortcode', [ 'text' => '[bw_field _step_ref]'] ];
    $template[] = ['core/heading', [ 'content' => 'Related questions:' ] ];
    $template[] = ['core/shortcode', [ 'text' => '[bw_related post_type=question meta_key=_step_ref meta_value=_step_ref]'] ];
    return $template;
}

/**
 * Register custom post type "problem"
 *
 * Fields for the problem are:
 * _step_ref - noderef to zero or more _oik_presentation posts
 *
 */
function oik_register_problems() {
	$post_type = 'problem';
	$post_type_args = array();
	$post_type_args['label'] = 'Problems';
	//$post_type_args['singular_label'] = 'Business';
	$post_type_args['description'] = 'Examples of Problems associated with a particular step i.e. question';
	$post_type_args['hierarchical'] = false;
	$post_type_args['has_archive'] = true;
	$post_type_args['supports'] = array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'publicize', 'author', 'clone' );
	$post_type_args['show_in_rest'] = true;
    $post_type_args['template'] = oik_problems_CPT_template();
	bw_register_post_type( $post_type, $post_type_args );
	bw_register_field_for_object_type( "_step_ref", $post_type );
	add_filter( "manage_edit-${post_type}_columns", "oik_problem_columns", 10, 1 );
}

function oik_problems_CPT_template() {
    $template = array();
    //$template[] = ['core/block', [ /* No ref! */ ] ];
    $template[] = ['core/paragraph', ['placeholder' => 'Type something about the problem. Insert a reusable block above ' ]];
    $template[] = ['core/more' ];
    $template[] = ['core/heading', [ 'content' => "Reference:" ] ];
    $template[] = ['core/shortcode', [ 'text' => '[bw_field _step_ref]'] ];
    $template[] = ['core/heading', [ 'content' => 'Related questions:' ] ];
    $template[] = ['core/shortcode', [ 'text' => '[bw_related post_type=question meta_key=_step_ref meta_value=_step_ref]'] ];
    return $template;
}



/**
 * Columns to display in the admin page
 */
function oik_problem_columns( $columns ) {
	$columns["_step_ref"] = __( "Step ref" );
	//bw_trace2();
	//bw_backtrace();
	return( $columns );
}

/**
 * Function to invoke when oik-sites plugin file is loaded
 */
function oik_problem_solving_loaded() {
	add_action( 'oik_fields_loaded', 'oik_problem_solving_init' );
}

oik_problem_solving_loaded();
