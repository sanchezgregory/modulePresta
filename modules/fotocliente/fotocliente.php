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
        return $this->display(__FILE__,"getContent.tpl");
    }

    /**
     * @return string
     */
    public function install()
    {
        if (!parent::install()) return false;
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall()) return false;
        return true;
    }
}