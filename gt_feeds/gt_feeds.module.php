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

  // Note: The HTTP URLs have character length limitations.
  // As an alternative, terms could be loaded via a regular GET argument,
  // with the caviat that the native auto-loader argument functionality would
  // not be available for the terms. In the meantime, this should suffice as
  // a "basic" XML feed implementation.
  $items['feed/%gt_feeds_bundle/%gt_feeds_vocabulary/%gt_feeds_term'] = array(
    'page callback' => 'gt_feeds_xml_print',
    'access arguments' => array('access greatist feeds'),
    'page arguments' => array(1, 2, 3), # %mymodule_abc -> mymodule_abc_load()
    'type' => MENU_CALLBACK,
  );
  return $items;

/**
 * Validates bundle parameter for %gt_feeds_bundle page argument.
 */
function gt_feeds_bundle_load($bundle_name = '', $map = array(), $index = null) {

  // Exit if bundle parameter is not present.
  if (empty($bundle_name)) {
    gt_feeds_exit_error_parameter('entity bundle');
  }

  // Exit if bundle parameter is not valid.
  $node_types = node_type_get_names();
  if (!array_key_exists($bundle_name, $node_types)) {
    gt_feeds_exit_invalid_parameter('entity bundle', $bundle_name);
  }

  // Otherwise, pass the now-validated bundle name to the menu callback.
  return $bundle_name;
}

/**
 * Validates taxonomy vocabulary for %gt_feeds_vocabulary page argument.
 */
function gt_feeds_vocabulary_load($vocab_name = '', $map = array(), $index = null) {

  // Exit if vocabulary parameter is not present.
  if (empty($vocab_name)) {
    gt_feeds_exit_error_parameter('taxonomy vocabulary');
  }

  $vocabs = taxonomy_vocabulary_get_names();

  // Exit if vocabulary does not exist.
  if (!array_key_exists($vocab_name, $vocabs)) {
    gt_feeds_exit_invalid_parameter('taxonomy vocabulary', $vocab_name);
  }

  // Otherwise, pass the now-validated vocabulary to the menu callback as an
  // object - see taxonomy_vocabulary_get_names() for object format.
  return $vocabs[$vocab_name];
}

/**
 * Loads taxonomy terms from %gt_feeds_term page argument.
 */
function gt_feeds_term_load($url_terms = '', $map = array(), $index = null) {

  // Exit if terms parameter is empty.
  if (empty($terms)) {
    gt_feeds_exit_error_parameter('taxonomy term');
  }
  // NOTE: WORK IN PROGRESS
  // Load terms for menu callback.
  $term_names = explode("|", $url_terms);
  $loaded_terms = array();
  $vocabulary = NULL; // @todo get vocabulary using drupal_static() implementation.
  foreach($term_names as $term_name) {

    $loaded_term = taxonomy_get_term_by_name($name, $vocabulary);
    if(!empty($loaded_term)) {
      $loaded_terms[$term_name] = $loaded_term;
    }
  }


  // taxonomy_term_load_multiple();
}

/**
 * Menu callback for feed/%/%/% menu item.
 *
 * Returns a list of node entitites in XML format.
 */
function gt_feeds_xml_print($bundle, $vocabulary, $terms) {

  // @TODO Decide on native PHP XML modules versus Drupal feeds module.
  // The former is a much faster/easier implementation for the sake of a code exam,
  // but the latter more extensible out of the box.

  // @TODO Native PHP XML implementation.
  // @TODO Prefer using EntityFieldQuery and EntityMetadataWrappers whenever we need to load any entity over direct queries.

}

/**
 * Error callback for feed/%/%/% argument auto-load functions.
 *
 * Logs error into Drupal's Watchdog then displays error message in order to
 * help the user correct the URL request.
 */
function gt_feeds_exit_error_parameter($param = '') {

  // Log error message to watchdog.
  watchdog('gt_feeds', 'Feed missing %parameter parameter.', array('%parameter' => $param), WATCHDOG_ERROR, NULL);
  drupal_set_message(t('The %parameter parameter is missing from the URL, please provide it in order to render the feed.'), 'error');

  // Interrupt request and provide error message.
  $destination = NULL;
  drupal_exit($destination);
}

/**
 * Error callback for feed/%/%/% argument auto-load functions.
 *
 * Logs error into Drupal's Watchdog then displays error message in order to
 * help the user correct the URL request.
 */
function gt_feeds_exit_invalid_parameter($param_name = '', $param_value = '') {

  // Log error message to watchdog.
  watchdog('gt_feeds', 'Value @value for parameter @parameter is invalid.', array('@parameter' => $param_name, '@value' => $param_value), WATCHDOG_ERROR, NULL);
  drupal_set_message(t('The value provided for the %parameter parameter in the URL is invalid.', array('%parameter' => $param_name)), 'error');

  // Interrupt request and provide error message.
  $destination = NULL;
  drupal_exit($destination);
}
