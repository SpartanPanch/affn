<?php

use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;
use Drupal\taxonomy\Entity\Term;

/**
 * Preprocess variables for all views.
 *
 * @param array $variables
 * @return void
 */
function affn_preprocess_views_view(&$variables)
{

}

// -------------------------------------------------------------------------- //


function affn_preprocess_views_view_unformatted(&$variables)
{

  
          // start get members deta form nodes ..
          $query = \Drupal::entityTypeManager()->getStorage('node')->getQuery();
          $nids = $query->condition('type', 'members') ->condition('status', 1)->sort('created', 'DESC')->execute();
          $nodes = \Drupal\node\Entity\Node::loadMultiple($nids);  
          $metchkey = array();
            $alldata1 = array();
            $normal_alpha=array();
            $special_char=array();
          foreach ($nodes as $key => $events) { 
              $title = $events->title->value;       
              $nid = $events->nid->value;   
              $file_fid = getMedia($events->field_media->target_id);
              $event_tid = $events->field_category->target_id;
              $alldata1[$key]['nid'] = $nid = $events->nid->value;    
              $alldata1[$key]['title']  =  $title;  
              $metchkey[] = $title[0];    
                if (preg_match("/^[a-z]$/", strtolower($title[0]))) {
                  array_push($normal_alpha, $title[0]);
                }
                else{
                  array_push($special_char, $title[0].$title[1]);
                }
              $alldata1[$key]['image'] = $eventlist[$key]['imguri']  = $file_fid['image'];
              } 


              $titlekeyy = array_unique($special_char);
              for ($i=0; $i < count($titlekeyy) ; $i++) { 
                if($titlekeyy[$i] == 'Æ' || $titlekeyy[$i] == 'æ' ){
                  $short_special_char_new_key_sort[] = $titlekeyy[$i];
                  }  
              }
              for ($j=0; $j < count($titlekeyy) ; $j++) { 
                if($titlekeyy[$j] == 'Ø' || $titlekeyy[$j] == 'ø'){
                  $short_special_char_new_key_sort[] = $titlekeyy[$j];
                  }  
              }
              for ($k=0; $k < count($titlekeyy) ; $k++) { 
                if($titlekeyy[$k] == 'Å' || $titlekeyy[$k] == 'å'){
                  $short_special_char_new_key_sort[] = $titlekeyy[$k];
                  }  
              }

              $arr=array_merge(array_unique($normal_alpha),$short_special_char_new_key_sort);
 
          $mainarray1 = array();
            for ($i=0; $i < count($arr) ; $i++) { 
              $keyy1 = $arr[$i];
                $subarray1 = array();
                foreach ($alldata1 as $key => $value) {    
                    $mainval1 = $value['title'];   
                    $mainval1 = ucwords($mainval1);
              if (preg_match("/^[a-z]$/", strtolower($mainval1[0]))) {
                  if($mainval1[0] == $arr[$i]){            
                  $subarray1[] = $value;
                  }
                }
                else{
                $new_key=$mainval1[0].$mainval1[1];
                if($new_key == $arr[$i]){            
                $subarray1[] = $value;
                }
              }               
                }        
                $mainarray1[$keyy1] = $subarray1;
            }
          $variables['members_keys'] = $mainarray1;          


  $view = $variables['view'];
//  $v = \Drupal\views\Entity\View::load(1);  
  $id = $view->storage->id();
  $display = $view->current_display;


  if ($id == 'members' || $id == 'members_for_mobile') {
      $view = $variables['view'];
      $id = $view->storage->id();
      $rows = $variables['rows'];    
      $members = array();
      foreach ($rows as $rowId => $row) {
        $deta = array();
        foreach ($view->field as $fieldId => $field) {
          $field_output = $view->style_plugin->getFieldValue($rowId, $fieldId);
          $deta[$fieldId] = $field_output;  
        }
          $members[$rowId] = $deta;
      }

      foreach ($members as $key => $value) {       
        $titlekey = $value['title'];     
        $titlekey = ucwords($titlekey);
            if (preg_match("/^[a-z]$/", strtolower($titlekey[0]))) {
            $titlekeyy1[] = $titlekey[0];
            }
            else{
            $titlekeyy[] = $titlekey[0].$titlekey[1];
            }
       }
       asort($titlekeyy1);   
       $members_normal_alphas = array_unique($titlekeyy1);
      // start resort key of array
            $i =0;
            foreach ($members_normal_alphas as $key ) {
              $members_normal_alpha_new_key[$i] = $key;
              $i++;
            }
      // end start resort key of array

          // start denish lattes sorting..
          $short_special_char_new_key_sort = array();
          for ($i=0; $i < count($titlekeyy) ; $i++) { 
            if($titlekeyy[$i] == 'Æ' || $titlekeyy[$i] == 'æ' ){
              $short_special_char_new_key_sort[] = $titlekeyy[$i];
              }  
          }
          for ($j=0; $j < count($titlekeyy) ; $j++) { 
            if($titlekeyy[$j] == 'Ø' || $titlekeyy[$j] == 'ø'){
              $short_special_char_new_key_sort[] = $titlekeyy[$j];
              }  
          }
          for ($k=0; $k < count($titlekeyy) ; $k++) { 
            if($titlekeyy[$k] == 'Å' || $titlekeyy[$k] == 'å'){
              $short_special_char_new_key_sort[] = $titlekeyy[$k];
              }  
          }
          // end denish lattes sorting..

         $uniqmetchkey=array_merge(array_unique($members_normal_alpha_new_key),array_unique($short_special_char_new_key_sort));

      $mainarray = array();
      $special_char_keyy = array();
      for ($i=0; $i < count($uniqmetchkey) ; $i++) { 
        $keyy = $uniqmetchkey[$i];
        $subarray = [];
        $rowId = 0;
       foreach ($members as $key => $value) {
        
          $mainval = $value['title']; 
          $mainval = ucwords($mainval);
              if (preg_match("/^[a-z]$/", strtolower($mainval[0]))) {
                $mainval = $mainval[0];   
              }
              else{
                $mainval = $mainval[0].$mainval[1];                  
              }                        
              if($mainval ==  $keyy ){  
                $target_id = $value['field_media'] ;                
                $value['field_media'] = getMedia($target_id);               
                $subarray[] = $value;
              }
              $rowId++;     
        }
         $mainarray[$keyy]['s'] =  $special_char_keyy;
         $mainarray[$keyy] = $subarray;
      }
      $variables['members_list'] = $mainarray;
  }
   $rows = $variables['rows'];
   foreach ($rows as $key => $row) {
     if (isset($row['content']['#node'])) {
       $node = $row['content']['#node'];

       $data = [
         'title' => $node->label(),
       ];

       $data = array_merge($data, getFields($node, [
         'body',
         'label',   
         'url',
       ]));  
       $variables['rows'][$key] = $data;
     }
   }
}
