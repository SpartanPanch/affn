<?php

/**
 * Alter theme suggestions for all pages.
 *
 * @param array $suggestions
 * @param array $variables
 *
 * @return void
 */
function affn_theme_suggestions_page_alter(array &$suggestions, array $variables) {
  $route_name = \Drupal::routeMatch()->getRouteName();

  $http_error_suggestions = [
    'system.401' => 'page__system',
    'system.403' => 'page__system',
    'system.404' => 'page__system',
  ];

  if (isset($http_error_suggestions[$route_name])) {
    $suggestions[] = $http_error_suggestions[$route_name];
  }

  $current_path = \Drupal::service('path.current')->getPath();
//  $result = \Drupal::service('path.alias_manager')
  $result = \Drupal::service('path_alias.manager')
    ->getAliasByPath($current_path);

  $path_alias = trim($result, '/');
  $path_alias = str_replace('/', '-', $path_alias);

  $suggestions[] = 'page__' . $path_alias;

  //  Page Suggestion by Content Type
  $route = \Drupal::routeMatch();

  //  Check if route name "Node" canonical
  if ($route->getRouteName() == 'entity.node.canonical') {
    if ($node = $route->getParameter('node')) {
      $suggestions[] = 'page__node__' . $node->bundle();
    }
  }
}



// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for all pages.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_page(&$variables) {
  $request = \Drupal::request();
  $variables['language'] = \Drupal::languageManager()
    ->getCurrentLanguage()
    ->getId();
  $variables['page_title'] = (isset($variables['node'])) ? $variables['node']->label() : '';

  $variables['page_type'] = 'default';

  $variables['is_front_page'] = \Drupal::service('path.matcher')->isFrontPage();
 //  check use is admin
  $variables['user_is_logged_in'] = \Drupal::currentUser()->id() ? 1 : 0;
}

/**
 * Implements hook_page_attachments_alter()
 *
 * @param array $attachments
 */
function affn_page_attachments_alter(array &$attachments) {
  foreach ($attachments['#attached']['html_head'] as $key => $attachment) {
    if ($attachment[1] == 'system_meta_generator') {
      unset($attachments['#attached']['html_head'][$key]);
    }
  }
}
// -------------------------------------------------------------------------- //
