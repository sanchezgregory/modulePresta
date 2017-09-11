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
        global $smarty;
        $texto = Configuration::get('MODULOPRUEBA_TEXTO');
        $smarty->assign('vertexto', $texto);
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
                        'desc' => $this->l('introduce un texto a visualizar'),
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Guardar'),
                )
            )
        );
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;
        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form));


    }

    public function getConfigFieldsValues()
    {
        return array('moduloprueba_texto' => Tools::getValue('moduloprueba_texto', Configuration::get('MODULOPRUEBA_TEXTO')));
    }
}