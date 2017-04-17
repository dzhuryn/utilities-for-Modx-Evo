//<?php
/**
 * hits
 *
 * hits plugin
 *
 * @category    plugin
 * @version     0.1
 * @license     http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnWebPageInit
 * @internal    @modx_category sys
 * @internal    @legacy_names compare
 * @internal    @installset base
 *
 * @author Dzhuryn Volodymyr / updated: 2017-04-17


 */


include_once(MODX_BASE_PATH . 'assets/lib/MODxAPI/modResource.php');
$recourse = new modResource($modx);
$recourse->edit($modx->documentIdentifier);
$hits = intval($recourse->get('hits'));
$recourse->set('hits', $hits+1);
$recourse->save(false, false);