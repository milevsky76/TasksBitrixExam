<?
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
	"main",
	"OnPageStart",
	function($IBLOCK_ID = 5)
	{
		global $APPLICATION;

		if (CModule::IncludeModule("iblock"))
		{
			$dir = $APPLICATION->GetCurDir();

			$iterator = CIBlockElement::GetList(
				array(),
				array(
					"IBLOCK_ID" => $IBLOCK_ID,
					"NAME" => $dir
				),
				false,
				array(),
				array(
					"ID",
					"PROPERTY_TITLE",
					"PROPERTY_DESCRIPTION"
				)
			);
			
			$ob = $iterator->GetNext();

			if (!$ob["PROPERTY_TITLE_VALUE"] && !$ob["PROPERTY_DESCRIPTION_VALUE"]) {
				return false;
			}

			$arProp["title"] = $ob["PROPERTY_TITLE_VALUE"];
			$arProp["description"] = $ob["PROPERTY_DESCRIPTION_VALUE"];

			foreach ($arProp as $key => $value) {
				$APPLICATION->SetPageProperty($key, $value);
			}

			return true;
		}

		return false;
	}
);
?>