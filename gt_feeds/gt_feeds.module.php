<?php
/**
 * @file
 * Greatist Feeds module.
 * 
 * Provides XML feeds.
 */

/**
 * Implements hook_permission().
 */
function gt_feeds_permission() {
  $items = array();
  $items['access greatist feeds'] = array(
    'title' => t('Access Greatist Feeds'),
    'description' => t('Allows access to XML feeds.'),
  );
  return $items;
}


/**
 * Implements hook_menu().
 */
function gt_feeds_menu() {
  $items = array();
  # /feed/<content_type>/<taxonomy_vocabulary_name>/<term_names>
  $items['feed/<content_type>/<taxonomy_vocabulary_name>/<term_names>'] = array(
    'page callback' => 'gt_feeds_xml_print',
    'access arguments' => array('access greatist feeds'),
    'page arguments' => array(1, '%gt_feeds_content_type', '%gt_feeds_vocabulary', '%gt_feeds_term'), # %mymodule_abc -> mymodule_abc_load()
    'type' => MENU_CALLBACK,
  );
  return $items;
}

