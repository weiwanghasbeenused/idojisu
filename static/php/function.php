<?

function m_src($m){
	return '../../media/'.m_pad($m['id']).".".$m['type'];
}

function wysiwygClean($str)
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

?>