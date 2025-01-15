<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentDescription = array(
    "NAME" => "Review Form",
    "DESCRIPTION" => "Form for adding reviews and sending them to an external API.",
    "COMPLEX" => "N",
    "PATH" => array(
        "ID" => "content",
        "CHILD" => array(
            "ID" => "reviewform",
            "NAME" => "Review Form"
        )
    ),
);