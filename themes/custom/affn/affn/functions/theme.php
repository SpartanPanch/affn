<?php

/**
 * Alter theme suggestions for the theme.
 *
 * @param array $suggestions
 * @param array $variables
 * @return void
 */
// function affn_theme_suggestions_alter(&$suggestions, $variables)
// {
   

  
// }


// function affn_preprocess_block(&$variables) {
//     echo "<pre>";
//     print_r($variables);
//     // $variables['address'] = $node->get('field_address')->value;        
// }

/**
 * Implementation hook_theme()
 */
// function affn_theme($existing, $type, $theme, $path) {
 
// }


// sustom block types name suggestions
/**
 * Implements hook_theme_suggestions_HOOK_alter().
 */
function affn_theme_suggestions_block_alter(array &$suggestions, array $variables) 
{
    $block = $variables['elements'];
    $blockType = $block['#configuration']['provider'];
    if ($blockType == "block_content") {
        $bundle = $block['content']['#block_content']->bundle();
        $blockUuid = $block['content']['#block_content']->uuid();
        $blockId = $block['#id'];
        $suggestions[] = 'block__' . $blockType . '__' . $bundle;
        $suggestions[] = 'block__' . $blockType . '__' . $bundle . '__' . $blockId;
        $suggestions[] = 'block__' . $blockType . '__' . $bundle . '__' . $blockUuid;
    }
}




$last_run_per_minut = \Drupal::state()->get('hello.last_run', 0);   
  if ((REQUEST_TIME - $last_run_per_minut) > 6*60*60 ) {
      \Drupal::logger('hello')->info('Runnning Cron every 1 minut log');
      // Update last run.
      \Drupal::state()->set('hello.last_run', REQUEST_TIME);
        drupal_flush_all_caches(); 
    // drupal_set_message(t('Successful Message'.$last_run_per_minut), 'status');
  } 