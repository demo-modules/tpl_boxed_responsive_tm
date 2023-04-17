<?php
/* ------------------------------------------------------------------------------------------------------------------
   $Id: function.traffic_light.php
   
   CSS Produkt- & Attributlagerampel v1.0(2017-04-22) Community Edition
  
   Authors:
   -------------------
     awids (www.awids.de)
     web28 (www.rpa-com.de)
     noRiddle (www.revilonetz.de)
     
   Calls:	
   -------------------
     Community Edition:
     product_info: 		{traffic_light stock=$PRODUCTS_QUANTITY modul='info'}
     product_listing: 	{traffic_light stock=$module_data.PRODUCTS_QUANTITY modul='listing'}
     attributes: 		{traffic_light stock=$item_data.STOCK modul='attributes'}
     
   ----------------------------------------------------------------------------------------------------------------*/

function smarty_function_traffic_light($params, &$smarty) {
  
  $modul = isset($params['modul']) ? $params['modul'] : '';
  
  if (MODULE_TRAFFIC_LIGHTS_STATUS == 'true' && constant('MODULE_TRAFFIC_LIGHTS_ATTRIBUTES') == 'true' && $modul == 'attributes') {

      $stock = isset($params['stock']) ? $params['stock'] : false;
  	  
      if ($stock === false) {
        return false;
      }
      
      if ($stock < MODULE_TRAFFIC_LIGHTS_STOCK_RED_YELL) {
          //$stock_info = '<span class="traff-light"><span class="stock_title">'.MODULE_TRAFFIC_LIGHTS_STOCK.':</span> <span class="tl zero-tl"></span><span class="tl zero-tl"></span><span class="tl red-tl"></span><span class="nr-tooltip red-tl" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_RED.' | '.$stock.'</span></span>';
          $stock_info = '<span class="traff-light"><span class="tl red-tl"></span><span class="nr-tooltip red-tl" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_RED.' | '.$stock.'</span></span>';
          $html .= $stock_info;
      } 
      elseif ($stock >= MODULE_TRAFFIC_LIGHTS_STOCK_RED_YELL && $stock < MODULE_TRAFFIC_LIGHTS_STOCK_GREEN) {
          //$stock_info = '<span class="traff-light"><span class="stock_title">'.MODULE_TRAFFIC_LIGHTS_STOCK.':</span> <span class="tl zero-tl"></span><span class="tl yell-tl"></span><span class="tl zero-tl"></span><span class="nr-tooltip yell-tl yell-txt" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_YELL.' | '.$stock.'</span></span>';
          $stock_info = '<span class="traff-light"><span class="tl yell-tl"></span><span class="nr-tooltip yell-tl yell-txt" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_YELL.' | '.$stock.'</span></span>';
          $html .= $stock_info;
      }
      elseif ($stock >= MODULE_TRAFFIC_LIGHTS_STOCK_GREEN) {
          //$stock_info = '<span class="traff-light"><span class="stock_title">'.MODULE_TRAFFIC_LIGHTS_STOCK.':</span> <span class="tl green-tl"></span><span class="tl zero-tl"></span><span class="tl zero-tl"></span><span class="nr-tooltip green-tl" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_GREEN.' | '.$stock.'</span></span>';
          $stock_info = '<span class="traff-light"><span class="tl green-tl"></span><span class="nr-tooltip green-tl" aria-label="'.MODULE_TRAFFIC_LIGHTS_STOCK.'">'.MODULE_TRAFFIC_LIGHTS_QTY_GREEN.' | '.$stock.'</span></span>';
          $html .= $stock_info;
      }
      
      return $html;

  } elseif (MODULE_TRAFFIC_LIGHTS_STATUS == 'true' && constant('MODULE_TRAFFIC_LIGHTS_'.strtoupper($modul)) == 'true'  && $modul != 'attributes') {
    
      $stock = isset($params['stock']) ? $params['stock'] : false;
      if ($stock === false) {
        return false;
      }
      
      $tag = isset($params['tag']) ? $params['tag'] : '';
      $class = isset($params['class']) ? ' class="'.$params['class'].'"' : '';
      $style = isset($params['style']) ? $params['style'] : 'light';
      $brackets = isset($params['brackets']) ? $params['brackets'] : false;
      $show_stocktext = isset($params['show_stocktext']) ? $params['show_stocktext'] : true;
     
      $show_qty = false;

      if ($modul && defined('MODULE_TRAFFIC_LIGHTS_'.strtoupper($modul).'_LIGHT')) {
         $style = constant('MODULE_TRAFFIC_LIGHTS_'.strtoupper($modul).'_LIGHT');
      }
      
      $html = $show_stocktext ? '<span class="stocktext"><span class="stock_title">'.MODULE_TRAFFIC_LIGHTS_STOCK.':</span></span> ' : '';
      
      if ($style == 'light' && !$brackets) {
          $stock_info = '<span class="tl green-tl"></span><span class="tl yell-tl"></span><span class="tl red-tl"></span>';
      } else {
          $stock_info = '<span class="stock-txt"><span class="stock_title">#stock_title#</span></span>';
      }
      
      $stock_title = '<span title="#stock_title#" aria-label="#stock_title#">#stock_info#</span>';
      $stock_title = $brackets ? str_replace('#stock_info#',' (#stock_info#)',$stock_title) : $stock_title;
      
      if ($stock < MODULE_TRAFFIC_LIGHTS_STOCK_RED_YELL) {
          $stock_txt = MODULE_TRAFFIC_LIGHTS_QTY_RED. ($show_qty ? ' '. $stock : '');
          $stock_info = str_replace(array('tl green-tl','tl yell-tl','stock-txt','#stock_title#'),array('tl zero-tl','tl zero-tl','red-txt',$stock_txt),$stock_info);
          $html .= str_replace(array('#stock_title#','#stock_info#'),array($stock_txt,$stock_info),$stock_title);
      } 
      elseif ($stock >= MODULE_TRAFFIC_LIGHTS_STOCK_RED_YELL && $stock < MODULE_TRAFFIC_LIGHTS_STOCK_GREEN) {
          $stock_txt = MODULE_TRAFFIC_LIGHTS_QTY_YELL . ($show_qty ? ' '. $stock : '');
          $stock_info = str_replace(array('tl green-tl','stock-txt','tl red-tl','#stock_title#'),array('tl zero-tl','yell-txt','tl zero-tl',$stock_txt),$stock_info);
          $html .= str_replace(array('#stock_title#','#stock_info#'),array($stock_txt,$stock_info),$stock_title); 
      }
      elseif ($stock >= MODULE_TRAFFIC_LIGHTS_STOCK_GREEN) {
          $stock_txt = MODULE_TRAFFIC_LIGHTS_QTY_GREEN. ($show_qty ? ' '. $stock : '');
          $stock_info = str_replace(array('stock-txt','tl yell-tl','tl red-tl','#stock_title#'),array('green-txt','tl zero-tl','tl zero-tl',$stock_txt),$stock_info);
          $html .= str_replace(array('#stock_title#','#stock_info#'),array($stock_txt,$stock_info),$stock_title); 
      }
      
      $html = $tag ? '<'.$tag.$class.$style.'>'.$html.'</'.$tag.'>' : $html;
      return $html;
  } 
  
  return false;
}
