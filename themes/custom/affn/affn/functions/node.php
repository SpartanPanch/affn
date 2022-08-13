<?php
use Drupal\Core\Datetime\DrupalDateTime; 
 
/**
 * Alter theme suggestions for all nodes.
 *
 * @param array $suggestions
 * @param array $variables
 *
 * @return void
 */
function affn_theme_suggestions_node_alter(array &$suggestions, array $variables) {
  $isFrontPage = \Drupal::service('path.matcher')->isFrontPage();

  if (!empty($variables['content']['type'])) {
    $suggestions[] = 'node__' . $variables['content']['type'];
  }

  if ($isFrontPage) {
    $suggestions[] = 'node__front';
  }

}



// -------------------------------------------------------------------------- //

/**
 * Preprocess variables for all nodes.
 *
 * @param array $variables
 *
 * @return void
 */



function affn_preprocess_node(&$variables) {
  $node_id_current = \Drupal::routeMatch()->getParameter('node');
  $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
  $node = $variables['node'];
  $type = $variables['node']->type;
  $type1 = $variables['node']->getType();
  ///    there are load image only for content types = members,  article, page
  //start 
      if($type1 == 'article' || $type1 == 'members' || $type1 == 'page' ){
        $nid1 = $node_id_current->id();
        $node1 = \Drupal\node\Entity\Node::load($nid1);
          if($node1->field_media->target_id){
            $file_fid1 = getMedia($node1->field_media->target_id);
            $atricle_image['img'] =  $file_fid1['image'];           
            $variables['atricle_image'] = $atricle_image;
          }
      }
      ////end
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
        // $eventlist[$key]['url']= \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$nid);
        $eventlist[$key]['url']= \Drupal::service('path_alias.manager')->getAliasByPath('/node/'.$nid);
        $eventlist[$key]['date'] = $events->field_event_date->value; 
        $eventlist[$key]['time'] = $events->field_event_time->value; 
        $eventlist[$key]['currentdate']  = Date("d/m/Y");    
        $eventlist[$key]['termname'] = $eventcat->name->value;      
        $eventlist[$key]['imguri']  = $file_fid['image'];

      }
    }  

  $variables['events'] = $eventlist;  


  //   // members page deta
  //   $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
  //   $node = $variables['node'];
  //   $type = $variables['node']->type;
  //   $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
  //   $nids = $query->condition('type', 'members') ->condition('status', 1)->sort('created', 'DESC')->execute();
  //   $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);  
  //    $metchkey = array();
  //     $alldata1 = array();
  //   foreach ($nodes as $key => $events) { 
  //       $title = $events->title->value;       
  //       $nid = $events->nid->value;   
  //       $file_fid = getMedia($events->field_media->target_id);
  //         if( $events->field_category->target_id){
  //         $event_tid = $events->field_category->target_id;
  //         }
  //       $alldata1[$key]['nid'] = $nid = $events->nid->value;    
  //       $alldata1[$key]['title']  =  $title;  
  //       $metchkey[] = $title[0];    
  //       $alldata1[$key]['image'] = $eventlist[$key]['imguri']  = $file_fid['image'];
        
  //   } 
  //   $uniqmetchkey = array_unique($metchkey);
  //   $arr = array();
  //   foreach($uniqmetchkey as $key){
  //       $arr[] = $key;
  //   }
  //   sort($arr);   
  //   $mainarray = array();
  //     for ($i=0; $i < count($arr) ; $i++) { 
  //        $keyy = $arr[$i];
  //         $subarray = array();
  //         foreach ($alldata1 as $key => $value) { 
  //           if($value['title']){         
  //              $mainval = $value['title'];   
  //             if($mainval['title'] == $arr[$i]){            
  //                 $subarray[] = $value;
  //             }
  //           }
  //         }
     
  //         $mainarray[$keyy] = $subarray;
  //     }
  //     $members1 = array();
  //     foreach ($mainarray as  $value) {
  //       $members1[] = $value;  
  //     }

  // //  die(); 
  //    $variables['members'] = $mainarray;  
  //   echo "<pre>";
  //   print_r($variables['members']);
  //  die();
  if ($node->bundle() == 'page') {
    $variables = array_merge($variables, getFields($variables['node'], [
      'title',
      'label',
      'sub_title',
      'industry',
      'body',
      'media',
      'mobile_media',
      'paragraphs',
      'link',  
    ]));

  }
if ($node->bundle() == 'article') {
    $variables = array_merge($variables, getFields($variables['node'], [
    'title',
    'label',
    'sub_title',
    'body',
     'media' => [
        'style' => 'large',
      ], 
    'link',
    'industry',
    'website',
    'email',
    'phonee',
  ]));
  }
}


/**
 * Preprocess variables for "Basic page" node.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_node__page(&$variables) {

  $variables = array_merge($variables, getFields($variables['node'], [
    'title',
    'label',
    'sub_title',
    'body',
     'media' => [
        'style' => 'large',
      ], 
    'link',
  ]));
}

/**
 * Preprocess variables for "Basic page" node.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_preprocess_node__article(&$variables) {

  $variables = array_merge($variables, getFields($variables['node'], [
    'title',
    'label',
    'sub_title',
    'body',
     'media' => [
        'style' => 'large',
      ], 
    'link',
    'industry',
    'website',
    'email',
    'phonee',
  ]));
}


/**
 * Get Categories List
 *
 * @param $industry_tid
 *
 * @return array
 */
function getCategoriesList($industry_tid, $field_content_type = 'article', $lang = NULL) {
  $lang = $lang == NULL ? \Drupal::languageManager()
    ->getCurrentLanguage()
    ->getId() : $lang;
  $categories_terms_ids = getCategoriesByIndustry($industry_tid);

  $category_list[] = [
    'value' => 'none',
    'name' => t('None')
  ];
//  $categories_terms_ids = getAvailableCategories($field_content_type, $lang, $categories_terms_ids);

  if (!empty($categories_terms_ids)) {
    $categories_terms = \Drupal\taxonomy\Entity\Term::loadMultiple($categories_terms_ids);

    foreach ($categories_terms as $k => $term) {
      //  @todo: quick hard
      if (in_array($term->id(), [262, 263])) {
        continue;
      } else {
        $category_list[] = [
          'value' => $term->id(),
          //      'value' => strtolower($term->name),
          'name' => $term->label(),
        ];
      }
    }
  }

  return $category_list;
}


/**
 * Get Content Type List
 *
 * @return array
 */
function getContentTypeList() {
  $vid = 'content_type';
  $content_type_terms = \Drupal::service('entity_type.manager')
    ->getStorage("taxonomy_term")
    ->loadTree($vid, 0, NULL, FALSE);

  $content_types[] = [
    'value' => 'none',
    'name' => t('None')
  ];

  foreach ($content_type_terms as $k => $term) {
    $content_types[] = [
      'value' => $term->tid,
      //      'value' => strtolower($term->name),
      'name' => $term->name,
    ];
  }
  return $content_types;
}


/**
 * Preprocess variables for all nodes.
 *
 * @param array $variables
 *
 * @return void
 */
function affn_theme_preprocess(&$variables, $hook) {
    $variables['base_path'] = base_path();
}