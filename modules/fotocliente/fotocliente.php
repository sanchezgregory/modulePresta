<?php

require_once (dirname(__FILE__).'/classes/fotoclienteObj.php');

class Fotocliente extends Module
{
    public function __construct()
    {
        $this->name = "fotocliente";
        $this->displayName = "Fotos de los Clientes";
        $this->description = "Modulo para añadir fotos";
        $this->tab = "front_office_features";
        $this->author = "Gregory Sanchez";
        $this->version = 1.0;
        $this->bootstrap = true;
        $this->ps_versions_compliancy = array("min"=>"1.5.2", "max"=>"1.7.1");
        //$this->dependencies = array(""); // de cuales modulo depende este para ser instalado

        parent::__construct();

    }

    public function getContent()
    {
        if (Tools::isSubmit("fotocliente_form")) {
            $enable = Tools::getValue("enable_comment");
            Configuration::updateValue("FOTOCLIENTE_COMMENTS", $enable);
        }
        $enable = Configuration::get("FOTOCLIENTE_COMMENTS");
        $this->context->smarty->assign("enable", $enable);

        return $this->display(__FILE__,"getContent.tpl");
    }

    /**
     * @return string
     */
    public function install()
    {
        if (!parent::install()) return false;

        Configuration::updateValue('FOTOCLI_COMMENTS','1');
        $this->registerHook("displayProductTabContent");

        $result = $this->installDB();
        return $result;
    }

    public function installDB()
    {
        return Db::getInstance()->execute("CREATE TABLE IF NOT EXISTS "._DB_PREFIX_."fotocliente_item (
            id_fotocliente_item int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_product int(11) NOT NULL,
            foto VARCHAR(255) NOT NULL,
            comment text NOT NULL)ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");
    }

    public function uninstall()
    {
        if (!parent::uninstall()) return false;

        Configuration::deleteByName('FOTOCLI_COMMENTS');
        $result = $this->uninstallDb();

        return $result;
    }

    public function uninstallDb()
    {
        return Db::getInstance()->execute('DROP TABLE "._DB_PREFIX_."fotocliente_item');
    }

    public function hookDisplayProductTabContent($params)
    {
        // --> validando y guardando imagen del frontend.
        if (Tools::isSubmit('fotocliente_submit_foto')) {
            if (isset($_FILES["foto"])) {
                $foto = $_FILES["foto"];
                if ($foto['name'] != "") {
                    $allowed =array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');

                    if (in_array($foto['type'], $allowed)) {
                        $path = './upload/';
                        list($width, $height) = getimagesize($foto['tmp_name']);
                        $propo = 400/$width;
                        $copy = ImageManager::resize($foto['tmp_name'],$path.$foto['name'],400,$propo=$height,$foto['type']);
                        if (!$copy) {
                            $this->context->smarty->assign('errorForm', 'Error  copiando la imagen: '.$path.$foto['name']);
                        } else {
                            $id_product = Tools::getValue('id_product');
                            $pathfoto = "upload/".$foto['name'];
                            $comentario = Tools::getValue('comment');

                            $fotoObj = new fotoclienteObj();
                            $fotoObj->id_product = (int)$id_product;
                            $fotoObj->foto = $pathfoto;
                            $fotoObj->comment = pSQL($comentario);
                            $result = $fotoObj->add();

                            if ($result) {
                                $this->context->smarty->assign('savedForm','1');
                            } else {
                                $this->context->smarty->assign('errorForm','No se ha guardado la imagen en la BD');
                            }
                        }
                    } else {

                        $this->context->smarty->assign('errorForm', 'Formato de imagen no valida');
                    }
                }
            }
        }
        // ----------------------------------------------
        $enable_comments = Configuration::get('FOTOCLIENTE_COMMENTS');
        $this->context->smarty->assign('enable_comments', $enable_comments);
        return $this->display(__FILE__,'displayProductTabContent.tpl');
    }
}