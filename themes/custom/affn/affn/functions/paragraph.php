<?php

use Drupal\paragraphs\Entity\Paragraph;

// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for all paragraphs.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph(&$variables) {
  //
}

// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for "Accordion Block" paragraph.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph__social_list_block(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title',
  ]));
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
        'media' => [
             'style' => 'original',
            ],
      'link', 
    ]);
  }
  $variables['paragraphs'] = $paragraphs ?? [];
}


/**
 * Preprocess variables for "Join Block" paragraph.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph__join_block(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'content',
    'link', 
    'title', 
    'sub_title',
    'links',
    'popup_title',
    'popup_content',
  ]));
   foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
        'download_file',
      'link', 
      'title', 
    ]); 
  }
  $variables['paragraphs'] = $paragraphs ?? [];

}

/**
 * Preprocess variables for "Join Block" paragraph.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph__events_block(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
    'sub_title'
  ]));
  $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
  $nids = $query->condition('type', 'events') ->condition('status', 1)->sort('field_event_date', 'ASC')->execute();
  $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);  
  $eventlist = [];
  foreach ($nodes as $key => $events) {
    $eventsdate = $events->field_event_date->value;
    $current_date = date('Y-m-d');
    $eventdata    = date('Y-m-d', strtotime($eventsdate));
    

    $strevent   = strtotime($eventdata);
    $strcurrent = strtotime($current_date);

      if($strevent >= $strcurrent){     
          $nid = $events->nid->value; 
          $file_fid = getMedia($events->field_media->target_id);
          $event_tid = $events->field_category->target_id; 
          $eventcat = \Drupal\taxonomy\Entity\Term::load($event_tid);
          $eventlist[$key]['title'] = $events->title->value;    
          $eventlist[$key]['body'] = $events->body->value;        
//          $eventlist[$key]['url']= \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
          $eventlist[$key]['url']= \Drupal::service('path_alias.manager')->getAliasByPath('/node/'.$nid);
          $eventlist[$key]['date'] = $events->field_event_date->value;    
          $eventlist[$key]['time'] = $events->field_event_time->value;    
          $eventlist[$key]['termname'] = $eventcat->name->value;      
          $eventlist[$key]['imguri']  = $file_fid['image'];
      }
  }  
   $variables['events'] = $eventlist;
}



// // paragraph--text_with_media_block.html.twig
function affn_preprocess_paragraph__text_with_media_block(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
  ]));
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
        'media' => [
             'style' => 'original',
            ],
      'sub_title',
      'content',
    ]);
  } 
  $variables['paragraphs'] = $paragraphs ?? [];
}




// // paragraph--text_slider_with_image.html.twig
function affn_preprocess_paragraph__text_slider_with_image(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
    'media' => [
      'style' => 'original',
    ],
    'mobile_media' => [
      'style' => 'original',
    ],
  ]));
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
      'title',
      'content',
    ]);
  } 
  $variables['paragraphs'] = $paragraphs ?? [];
}




// // paragraph--offerings_services_block.html.twig
function affn_preprocess_paragraph__offerings_services_block(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
  ]));
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
      'link', 
      'media' => [
        'style' => 'original',
      ],
    ]);
  } 
  $variables['paragraphs'] = $paragraphs ?? [];
}




// // paragraph--about_press.html.twig
function affn_preprocess_paragraph__about_press(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
    'content', 
    'media' => [
      'style' => 'original',
    ],
    'link',
  ]));
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
      'title',       
      'content', 
      'media' => [
        'style' => 'original',
      ],
      'link', 
    ]);
  } 
  $variables['paragraphs'] = $paragraphs ?? [];
}


// // paragraph--join_details.html.twig
function affn_preprocess_paragraph__join_details(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
    'content', 
    'links', 
    'sub_title', 
  ]));

  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
      'title',       
      'content', 
    ]);
  } 

  foreach ($variables['paragraph']->get('field_application_blocks') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs12[] = getFields($paragraph, [
      'download_file',
      'link', 
      'title', 
    ]);
  } 
  $variables['paragraphs12'] = $paragraphs12 ?? [];
  $variables['paragraphs'] = $paragraphs ?? [];
}


// // paragraph--join_details_with_video.html.twig
function affn_preprocess_paragraph__join_details_with_video(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
  ]));
  
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
      'title',       
      'content',   
      'link', 
      'sub_title', 
      'media' => [
        'style' => 'original',
      ],
      'video_poster' => [
        'style' => 'original',
      ],
      'video',
    ]);
  } 
  // print"<pre>";
  // print_r($paragraphs);
  $variables['paragraphs'] = $paragraphs ?? [];
}



// // paragraph--join_details_with_video.html.twig
function affn_preprocess_paragraph__press_sidebar_details(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
  ]));
  
  foreach ($variables['paragraph']->get('field_paragraphs') as $item) {
    $paragraph = Paragraph::load($item->target_id);
    $paragraphs[] = getFields($paragraph, [
     'title',       
    'link',     
    'media' => [
      'style' => 'original',
      ], 
    ]);
  } 
  // print"<pre>";
  // print_r($paragraphs);
  $variables['paragraphs'] = $paragraphs ?? [];
}

/* 15-march-2021*/

/**
 * Preprocess variables for "Banner Block" paragraph.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph__footer_banner_info(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'content',
    'title', 
     'media' => [
        'style' => 'original',
      ], 
  ]));
}

/**
 * Preprocess variables for "Banner Block" paragraph.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_paragraph__press_releases(&$variables) {
  $variables = array_merge($variables, getFields($variables['paragraph'], [
    'title', 
    'links',
  ]));
}

// delete paragraph by id programmetically working....
// $entity = \Drupal::entityTypeManager()->getStorage('paragraph')->load(100);
// if ($entity) {
// $entity->delete();
// }  
