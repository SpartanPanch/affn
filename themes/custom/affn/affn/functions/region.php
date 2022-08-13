<?php

/**
 * Preprocess variables for all regions.
 *
 * @param array $variables
 * @return void
 */
function affn_preprocess_region(&$variables)
{
    //
}

// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for "header" region.
 *
 * @param array $variables
 * @return void
 */
function affn_preprocess_region__header(&$variables)
{
    $variables['language'] = \Drupal::languageManager()->getCurrentLanguage()->getId();
}

function affn_preprocess_region__footer(&$variables)
{
  $variables['language'] = \Drupal::languageManager()->getCurrentLanguage()->getId();
}
