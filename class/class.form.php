<?php

class formHTML {

  static public function getFormSelectFromArray ($array,$name,$id,$class,$selected=false,$required=false,$autofocus=false) {
    /*
    (IN) $array = tableau de valeur
    (IN) $name = name du champ SELECT
    (IN) $id = id du champ SELECT
    (IN) $class = class du champ SELECT
    (IN) $selected = valeur préselectionné dans le SELECT ou false
    (IN) $required = boolean si le champ SELECT est obligatoire ou non
    (IN) $autofocus = boolean si le champ SELECT doit recevoir l'autofocus
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
