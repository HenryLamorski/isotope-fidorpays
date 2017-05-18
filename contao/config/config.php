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
 * Attributes
 */
\Isotope\Model\Payment::registerModelType('FidorPaysMc', 'Isotope\Model\Payment\FidorPaysMc');
\Isotope\Model\Payment::registerModelType('FidorPaysVisa', 'Isotope\Model\Payment\FidorPaysVisa');
