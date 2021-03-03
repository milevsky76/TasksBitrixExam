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
				array("ID")
			);
			
			$elem = $iterator->GetNext();

			if (!$elem) {
				return false;
			}

			$iterator = CIBlockElement::GetProperty(
				$IBLOCK_ID,
				$elem["ID"],
				array(),
				array()
			);

			while($ob = $iterator->GetNext())
			{
				$arProp[$ob["NAME"]]=$ob["VALUE"];
			}

			if (!$arProp) {
				return false;
			}

			foreach ($arProp as $key => $value) {
				$APPLICATION->SetPageProperty($key, $value);
			}

			return true;
		}

		return false;
	}
);
?>