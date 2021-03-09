<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc;

$arTemplateParameters = array(
	"COMPLAINTS_AJAX" => array(
		"NAME" => Loc::getMessage("COLL_COMPLAINTS_AJAX"),
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
	),
);

?>
