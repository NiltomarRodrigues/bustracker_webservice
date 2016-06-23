<?php

/**
 * Arquivo que ira guardar as coordenadas enviadas pelo servidor
 * verifique se o arquivo tem permissao para leitura e escrita
 * formato do dado gravado: yyyy-mm-dd hh:mm:ss_lat_log_
 */
$file = "position.txt";

/**
 * Recebe os dados via get @see $_GET documentação PHP
 * verifica se essas dados correspondente a uma coordenada valida 
 * obdecendo o formato +/-x.xxxxxxxx para ambos (lat,log)
 */
if (isset($_GET["lat"]) && preg_match("/^-?\d+\.\d+$/", $_GET["lat"])
    && isset($_GET["lon"]) && preg_match("/^-?\d+\.\d+$/", $_GET["lon"]) ) 
{
    $fh = fopen($file, "w");

    // Não foi possivel abrir o arquivo
    if (!$fh) {
        header("HTTP/1.0 500 Internal Server Error");
        exit(print_r(error_get_last(), true));
    }

    // Grava as coordenadas recebidas no arquivo
    fwrite($fh, date("Y-m-d H:i:s")."_".$_GET["lat"]."_".$_GET["lon"]."_");
    if (isset($_GET["t"]) && preg_match("/^\d+$/", $_GET["t"])) {
        fwrite($fh, $_GET["t"]);
    }
    fclose($fh);

    // Feedback para servidor
    echo "OK";

} elseif (isset($_GET["tracker"])) {
    echo "OK";
} else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Nao foi possivel conectar ao servidor!';
}
?>
