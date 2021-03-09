<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Loader;
use \Bitrix\Main\UserTable;
CJSCore::Init();

define("COMPLAINTS_IBLOCK_ID", 6);
$user = "";
$outData = [];
$redirect = $APPLICATION->GetCurPage() . "?type=OUTPUT";

if($_GET["type"] == "OUTPUT"):?>
    <script>
        let complaintRes = document.getElementById("complaint-result");
        let id = <?= isset($_GET["id"]) ? $_GET["id"] : 0;?>;

        if (id) {
            complaintRes.innerText = "Ваше мнение учтено, №" + id;
        } else {
            complaintRes.innerText = "Ошибка!";
        }
    </script>
<?endif;

if(isset($_GET['id']) && Loader::includeModule("iblock") && ($_GET["type"] == "AJAX" || $_GET["type"] == "GET")) {
    if ($USER->IsAuthorized()) {
        $utUser = UserTable::getList(array(
            "select" => array(
                "ID",
                "LOGIN",
                "LAST_NAME",
                "NAME",
                "SECOND_NAME",
            ),
            "filter" => array(
                "ID" => $USER->GetID(),
            ),
        ));

        if ($arUser = $utUser->Fetch()) {
            $user = $arUser["ID"] . ", " . $arUser["LOGIN"] . ", " . $arUser["LAST_NAME"] . " " . $arUser["NAME"] . " " . $arUser["SECOND_NAME"];
        }
    } else {
        $user = "Не авторизован";
    }

    $el = new CIBlockElement();

    $arLoadComp = array(
        "IBLOCK_ID" => COMPLAINTS_IBLOCK_ID,
        "ACTIVE_FROM" => ConvertTimeStamp(time(), "FULL"),
        "NAME" => "Новость, №" . $_GET['id'],
        "PROPERTY_VALUES" => array(
            'COMPLAINT_USER' => $user,
            'COMPLAINT_NEWS' => $_GET['id'],
        ),
    );

    if ($elID = $el->Add($arLoadComp)) {
        $outData["id"] = $elID;

        if ($_GET["type"] == "AJAX") {
            $APPLICATION->RestartBuffer();
            echo json_encode($outData);
            die();
        } elseif ($_GET["type"] == "GET") {
            $redirect .= "&id=" . $outData["id"];
        }
    }

    LocalRedirect($redirect);
}