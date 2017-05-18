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
{gateway_legend},fidorpays_userId,fidorpays_entityId,fidorpays_password,fidorpays_cards;{price_legend:hide},price,tax_class;{expert_legend:hide},guests,protected;{enabled_legend},debug,enabled';

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_userId'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_userId'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_password'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_pwd'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'clr'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_entityId'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_entityId'],
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['fidorpays_cards'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['fidorpays_cards'],
    'exclude'               => true,
    'inputType'             => 'select',
    'options'               => array(
        'VISA'      => 'Visa',
        'MASTER'    => 'MasterCard',
        'AMEX'      => 'American Express',
    ),
    'eval'                  => array('mandatory'=>true, 'tl_class'=>'clr', 'multiple'=>true,'size'=>5 ),
    'sql'                   => "BLOB",
);



