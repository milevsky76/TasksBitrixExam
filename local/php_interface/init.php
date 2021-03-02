<?
$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
	"main",
	"OnBeforeEventAdd",
	function (&$event, &$lid, &$arFields)
	{
		global $USER;
	
		if ($event !== "FEEDBACK_FORM")
		{
			return true;
		}
	
		if ($USER->IsAuthorized())
		{
			$arFields["AUTHOR"] = "Пользователь авторизован: " . $USER->GetID() . " (" . $USER->GetLogin() . ") " . $USER->GetFirstName() . ", данные из формы: " . $arFields["AUTHOR"];
		}
		else
		{
			$arFields["AUTHOR"] = "Пользователь не авторизован, данные из формы: " . $arFields["AUTHOR"];
		}

		CEventLog::Add(array(
			"SEVERITY" => "INFO",
			"AUDIT_TYPE_ID" => "EPLACEMENT_OF_MAIL_DATA",
			"MODULE_ID" => "main",
			"ITEM_ID" => NULL,
			"DESCRIPTION" => "Замена данных в отсылаемом письме – " . $arFields["AUTHOR"],
		));
	}
);
?>