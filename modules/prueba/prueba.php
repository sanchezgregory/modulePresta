<?php
if (!defined ('_PS_VERSION_')) exit;

class prueba extends Module
{
    public function __construct()
    {
        $this->name = "prueba";
        $this->tab = "Modulo de prueba ";
        $this->version = "1.0";
        $this->author = "Gregory Sanchez";
        $this->instance = 0;

        parent::__construct();
        $this->displayName = $this->l("Modulo de prueba");
        $this->description = $this->l("Este es probando un modulo mio");

    }

    public function install()
    {
        if (parent::install() == false OR !$this->registerHook('leftColumn') OR !$this->registerHook('rightColumn') OR !Configuration::updateValue('MODULOPRUEBA_TEXTO','')) {
            return false;
        } else {
            return true;
        }
    }

    public function uninstall()
    {
        return (parent::uninstall() AND Configuration::deleteByName('MODULOPRUEBA_TEXTO'));
    }

    public function hookRightColumn($params)
    {
        return $this->hookLeftColumn($params);
    }

    public function hookLeftColumn($params)
    {
        return $this->display(__FILE__, 'prueba.tpl');
    }

    public function getContent()
    {
        $output='';
        if (Tools::isSubmit()) {
            Configuration::updateValue('MODULOPRUEBA_TEXTO', Tools::getValue('moduloprueba_texto', ''));
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminModules').'&configure='.$this->name.'&tab_module='.$this->tab.'$conf=4&module_name='.$this->name);
        }

        return $output.$this->renderForm();
    }

    public function renderForm()
    {
        $fields_form = array(
            'form' => array(
              'legend' => array(
                  'title' => $this->l('Configuration'),
                  'icon' => 'icon.cogs',
              ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Pon Tu text'),
                        'name' => 'moduloprueba_texto',
                        'desc' => $this->l('introduce un trexto a vicualizar'),
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Guardar'),
                )
            )
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;

    }
}