<?php
/**
 * Fidor-Payments: all in one Payment Solutions
 *
 * Copyright (c) 2017 Henry Lamorski
 *
 * @package FidorPays
 * @author  Henry Lamorski <henry.lamorski@mailbox.org>
 */


/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']['FidorPays'] = '{type_legend},name,label,type;{note_legend:hide},note;{config_legend},new_order_status,quantity_mode,minimum_quantity,maximum_quantity,minimum_total,maximum_total,countries,shipping_modules,product_types,product_types_condition,config_ids;
{gateway_legend},fidorpays_sender;fidorpays_login;fidorpays_pwd;fidorpays_secret;fidorpays_channel;{price_legend:hide},price,tax_class;{expert_legend:hide},guests,protected;{enabled_legend},debug,enabled';

$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']['FidorPaysMc'] ? 


$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_sender'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_sender'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_login'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_login'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_pwd'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_pwd'],
    'exclude'               => true,
    'inputType'             => 'password',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_secret'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_secret'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_channel'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_channel'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);


