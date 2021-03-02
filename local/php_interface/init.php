<?
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
	"iblock",
	"OnBeforeIBlockElementUpdate",
	function(&$arFields)
	{
		global $APPLICATION;

		if ($arFields["IBLOCK_ID"] !== 2 || $arFields["ACTIVE"] !== "N")
		{
			return true;
		}

		$iterator = CIBlockElement::GetList(
			array(),
			array(
				"ID" => $arFields["ID"],
				"IBLOCK_ID" => $arFields["IBLOCK_ID"]
			),
			false,
			array(),
			array("ID", "SHOW_COUNTER")
		);
	
		$result = $iterator->GetNext();
	
		if (!$result)
		{
			return true;
		}
	
		if ($result["SHOW_COUNTER"] > 2)
		{
			$text = "Товар невозможно деактивировать, у него " . $result["SHOW_COUNTER"] . " просмотров";
			$APPLICATION->throwException($text);
			return false;
		}
	
		return true;
	}
);
?>