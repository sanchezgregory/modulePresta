<?php

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
        return Db::getInstance()->execute('DROP TABLE "._DB_PREFIX."fotocliente_item');
    }

    public function hookDisplayProductTabContent($params)
    {
        return $this->display(__FILE__,'displayProductTabContent.tpl');
    }
}