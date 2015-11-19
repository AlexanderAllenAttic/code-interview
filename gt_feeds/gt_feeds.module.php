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

