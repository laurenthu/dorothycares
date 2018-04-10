<?php

class formHTML {

  static public function getFormSelectFromArray ($array,$name,$id,$class,$selected=false,$required=false,$autofocus=false) {
    /*
    (IN) $array = array of arrays with keys value & name
    (IN) $name = name of input SELECT
    (IN) $id = id  of input SELECT
    (IN) $class = class  of input SELECT
    (IN) $selected = preselected value in the SELECT or false
    (IN) $required = boolean if the SELECT is required
    (IN) $autofocus = boolean if the SELECT must be in autofocus
    (OUT) HTML code string
    */

    if ($required) {
      $required = ' required ';
    } else {
      $required = '';
    }
    if ($autofocus) {
      $autofocus = ' autofocus ';
    } else {
      $autofocus = '';
    }
    if ($selected === false) {
      $selected = ' selected';
    }

    $s = '<select name="'.$name.'" id="'.$id.'" class="'.$class.'"'.$required.$autofocus.'>';
    $s .= '<option value=""'.$selected.'>--</option>';

    foreach ($array as $k => $v) {
      if ($v['value'] === $selected)
        $s.= '<option value="'.$v['value'].'" selected>'.$v['name'].'</option>';
      else
        $s.= '<option value="'.$v['value'].'">'.$v['name'].'</option>';
    }

    $s .= '</select>';

    return $s;
  }

}

?>
