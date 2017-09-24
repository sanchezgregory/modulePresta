<?php

/**
 * Created by PhpStorm.
 * User: gregory
 * Date: 9/24/17
 * Time: 12:20 PM
 */
class fotoclienteObj extends ObjectModel
{
    public $id_fotocliente_item;
    public $id_product;
    public $foto;
    public $comment;

    public static $definition = array(
        'table' => 'fotocliente_item', 'primary' => 'id_fotocliente_item', 'multilang' => false,
        'fields' => array (
            'id_product' => array ('type' => self::TYPE_INT, 'validate'=>'isUnsignedId', 'required'=>true),
            'foto'=>array('type'=>self::TYPE_STRING, 'required'=>true),
            'comment'=>array('type'=>self::TYPE_HTML, 'validate'=>'isCleanHtml'),
        ),
    );
}
