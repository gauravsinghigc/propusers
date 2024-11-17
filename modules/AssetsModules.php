<?php
//get assets images
function GetAssetImages($AssetId, $FileName)
{
    $GetFile = FETCH("SELECT $FileName FROM assets where AssetsId='$AssetId'", "$FileName");

    if ($GetFile ==  null) {
        $ReturnFile = STORAGE_URL_D . "/tool-img/assets.png";
    } else {
        $ReturnFile = STORAGE_URL . "/assets/$GetFile";
    }

    return $ReturnFile;
}
