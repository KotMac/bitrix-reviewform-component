<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Context;

class ReviewFormComponent extends \CBitrixComponent
{
    public function executeComponent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processForm();
        }

        $this->includeComponentTemplate();
    }

    private function processForm()
    {
        Loader::includeModule('iblock'); // Подключаем модуль инфоблоков

        global $USER;

        $name = trim($_POST['name']);
        $review = trim($_POST['review']);
        $rating = (int)$_POST['rating'];

        if (empty($name) || empty($review) || !$rating) {
            $this->arResult["ERROR"] = "Пожалуйста, заполните все поля.";
            return;
        }

        if ($rating < 1 || $rating > 5) {
            $this->arResult["ERROR"] = "Рейтинг должен быть от 1 до 5.";
            return;
        }

        $iblockId = 12;
        $element = new \CIBlockElement;
        $currentDate = new \Bitrix\Main\Type\DateTime();
        $elementId = $element->Add([
            "IBLOCK_ID" => $iblockId,
            "ACTIVE" => "Y",
            "NAME" => $name,
            "PROPERTY_VALUES" => [
                "ATT_NAME" => $name,
                "ATT_REVIEW" => $review,
                "ATT_RATING" => $rating,
                "ATT_DATE" => $currentDate->format("d.m.Y"), // Преобразование в строку с нужным форматом
            ],
        ]);

        if ($elementId) {
            $this->sendToExternalAPI($name, $review, $rating);
            $this->arResult["SUCCESS"] = "Отзыв успешно добавлен!";
            
            // Редирект на ту же страницу после успешного добавления отзыва
            LocalRedirect(Context::getCurrent()->getRequest()->getRequestUri());
        } else {
            $this->arResult["ERROR"] = "Ошибка при добавлении отзыва: " . $element->LAST_ERROR;
        }
    }

    private function sendToExternalAPI($name, $review, $rating)
    {
        $url = "https://example.com/api/reviews";
        $data = [
            "name" => $name,
            "review" => $review,
            "rating" => $rating,
        ];

        $httpClient = new HttpClient();
        $response = $httpClient->post($url, json_encode($data), [
            "headers" => ["Content-Type" => "application/json"],
        ]);

        $this->logResponse($response);
    }

    private function logResponse($response)
    {
        $logFile = $_SERVER["DOCUMENT_ROOT"] . "/local/logs/api.log";
        $logMessage = date("Y-m-d H:i:s") . " - Response: " . print_r($response, true) . "\n";

        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }
}