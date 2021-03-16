<?$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler(
	"main",
	"OnEpilog",
	function()
	{
		if (defined("ERROR_404") && ERROR_404 == "Y" || CHTTP::GetLastStatus() == "404 Not Found") {
			global $APPLICATION;
			
			CEventLog::Add(array(
				"SEVERITY" => "INFO",
				"AUDIT_TYPE_ID" => "ERROR_404",
				"MODULE_ID" => "main",
				"DESCRIPTION" => $APPLICATION->GetCurUri(),
			));
		}
	}
);