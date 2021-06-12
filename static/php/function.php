<?

function m_src($m){
	return '../../media/'.m_pad($m['id']).".".$m['type'];
}

function strictEmpty($str){
  while(ord(substr($str, 0, 1)) == '9' || 
        ord(substr($str, 0, 1)) == '10' || 
        ord(substr($str, 0, 1)) == '13' || 
        ord(substr($str, 0, 1)) == '32')
  {
    $str = substr($str, 1);
  }

  if(empty($str))
    return true;
  return false;
}
function removeSpace($str)
{
  while(ord(substr($str, 0, 1)) == '9' || 
        ord(substr($str, 0, 1)) == '10' || 
        ord(substr($str, 0, 1)) == '13' || 
        ord(substr($str, 0, 1)) == '32'
       )
  {
    $str = substr($str, 1);
  }
  if(!empty($str))
  {
    while(ord(substr($str, strlen($str) - 1)) == '9' || 
          ord(substr($str, strlen($str) - 1)) == '10' || 
          ord(substr($str, strlen($str) - 1)) == '13' || 
          ord(substr($str, strlen($str) - 1)) == '32'
         )
    {
      $str = substr($str, 0, strlen($str) - 1);
    }
  }
  return $str;
}

function replaceDivs($str)
{
  $output = $str;
  if(substr($output, 0, 5) == '<div>')
    $output = substr($output, 5);
  $divs_pattern = "/(<div>)\\1+/";
  $output = preg_replace( $divs_pattern, "$1", $output);
  $output = preg_replace( "/(<br>(?:<\/div>)*?<div>)/", "<br>", $output);
  $output = str_replace( "<div>", "<br>", $output);
  $output = str_replace("</div>", '', $output);

  return $output;
}

function filterClasses($str)
{
  $class_pattern = "#(<[^>]+)( class\s*?=\s*?['\"](.*?)['\"]).*?>#i";
  $allowed_class = array('footnote');
  $changed_tagplusclass = array();
  preg_match_all($class_pattern, $str, $class_arr);
  foreach($class_arr[3] as $key => $classes)
  {
    $this_tag_plus_class = $class_arr[1][$key] . $class_arr[2][$key];
    if(!in_array($this_tag_plus_class, $changed_tagplusclass))
    {
      $changed_tagplusclass[] = $this_tag_plus_class;
      $this_class_arr = explode(' ', $classes);
      $filtered_classes = '';
      foreach($this_class_arr as $class)
      { 
        if(in_array($class, $allowed_class))
          $filtered_classes .= ' ' . $class;
      }
      if($filtered_classes != '')
        $this_changed_tagplusclass = $class_arr[1][$key] . ' class="' . $filtered_classes . '"';
      else
        $this_changed_tagplusclass = $class_arr[1][$key];
      $str = str_replace($this_tag_plus_class, $this_changed_tagplusclass, $str);
    }
  }
  return $str;
}

function modifyLinkTarget($str){
  $link_pattern = '/(\<a\s.*?href\s*?=\s*?[\'"]https?:\/\/(?:www\.)?(?:staging\.)?(.*?)(?:\/.*?)?[\'"])\>/i';
  preg_match_all($link_pattern,$str,$link_arr);
  $domain_arr = $link_arr[2];
  foreach($domain_arr as $key => $domain)
  { 
    if($domain != 'justinbeal.com')
    {
      $this_link = $link_arr[1][$key];
      $this_link_changed = $this_link .= ' target="_blank"';
      $str = str_replace($link_arr[1][$key], $this_link_changed, $str);
    }
  }
  return $str;
}

function stripStyle($str)
{
  $style_pattern = "#(<[^>]+) style=\".*?\"#i";
  $str = preg_replace($style_pattern, "$1", $str); // remove style attribute
  return $str;
}

function wysiwygClean($str){
  $str = removeSpace($str);
  $str = stripStyle($str); // remove style attribute
  $str = replaceDivs($str); // replace div with br
  $str = filterClasses($str); // unwanted filter classes
  return $str;
}

function stripBracket($str){
  $bracket_pattern = '#\[(.*)\]#is';
  preg_match_all($bracket_pattern, $str, $output);
  return $output[1][0];
}
function childrenByBegin($oo, $o){
  $fields = array("objects.*");
  $tables = array("objects", "wires");
  $where  = array("wires.fromid = '".$o."'",
          "wires.active = 1",
          "wires.toid = objects.id",
          "objects.active = '1'");
  $order  = array("objects.rank", "objects.begin");
  $limit = '';
  $descending = true;
  return $oo->get_all($fields, $tables, $where, $order, $limit, $descending);
}
?>