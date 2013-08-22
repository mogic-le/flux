<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Claus Due <claus@wildside.dk>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 * @author Claus Due <claus@wildside.dk>
 * @package Flux
 */
class Tx_Flux_Backend_TableConfigurationPostProcessorTest extends Tx_Flux_Tests_AbstractFunctionalTest {

	/**
	 * @test
	 */
	public function canLoadFluxService() {
		$object = t3lib_div::getUserObj($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing']['flux']);
		$object->processData();
	}

	/**
	 * @test
	 */
	public function canCreateTcaFromFluxForm() {
		$table = 'this_table_does_not_exist';
		$field = 'input';
		$form = Tx_Flux_Form::create();
		$form->createField('Input', $field);
		Tx_Flux_Core::registerFormForTable($form, $table);
		$object = t3lib_div::getUserObj($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['GLOBAL']['extTablesInclusion-PostProcessing']['flux']);
		$object->processData();
		$this->assertArrayHasKey($table, $GLOBALS['TCA']);
		$this->assertArrayHasKey($field, $GLOBALS['TCA'][$table]['columns']);
		$this->assertContains($GLOBALS['TCA'][$table]['interface']['showRecordFieldList'], $field);
		$this->assertContains($GLOBALS['TCA'][$table]['types'][0]['showitem'], $field);
	}

}
