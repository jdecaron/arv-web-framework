<?
class structureDefinition{
    $includePath = '/include/php/tlp/';
    $fileSuffix = '.tpl';

    function news(){
        return array(
            'load' => $this . 'news' . $fileSuffix;
        );
    }

    function main(){
        return array(
        'a0' => array(
                '' => $
            ),
        'title' => 'Find-Spots.com'
        );
    }
}

class buildStructure extends structureDefinition{
    jsArray($arguments_array){

    }

    html(){

    }
}
?>
