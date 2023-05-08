<?php
function gera($type, $array, $imgHeight, $imgWidth)
{
    $html = <<<HTML
    <table>
    HTML;

    if ($type == "geral") {
        $html = <<<HTML
        $html
        <style>
            table {
                max-width: 100%;
            }
            th, td {
                text-align: center;
                border: 1 solid black;
            }

            img {
                width: 1000mm;
                height: 23.8mm;
            }
        </style>
        <tr>
        HTML;
        // Pegando os headers (caso existam registros)
        if (isset($array[0])) {
            foreach ($array[0] as $header => $path) {
                if ($header == "imgpath")
                    $header = "imagem";
                if ($header == "nome")
                    $header = "sistema";

                $html = <<<HTML
                $html<th><b>$header</b></th>
                HTML;
            }
        } else {
            $html = <<<HTML
            $html<th>Sem registros</th>
            HTML;
        }

        $html = <<<HTML
            $html</tr>
            HTML;

        // Inserindo os dados na tabela
        foreach ($array as $jogo) {
            $html = <<<HTML
            $html<tr>
            HTML;

            foreach ($jogo as $key => $dado) {
                if ($key == "imgpath") {
                    $html = <<<HTML
                    $html<td><img src="$dado" width="80vw"></td>
                    HTML;
                } else {
                    if ($dado) {
                        $html = <<<HTML
                        $html<td><p>$dado</p></td>
                        HTML;
                    } else {
                        $html = <<<HTML
                        $html<td><p>NÃO CADASTRADO</p></td>
                        HTML;
                    }
                }
            }
            $html = <<<HTML
            $html</tr>
            HTML;
        }
    } else if ($type == "resumo") {
        $html = <<<HTML
        $html
        <style>
            table {
                max-width: 100%;
            }
            th, td {
                text-align: center;
                border: 1 solid black;
            }
            
            img {
                width: $imgWidth mm;
                height: $imgHeight mm;
            }
        </style>
        HTML;
        if (!isset($array[0])) {
            $html = <<<HTML
            $html<th>Sem registros</th></tr>
            HTML;
        } else {
            for ($rows = 0; $rows < ceil(sizeof($array) / 3); $rows += 1) {
                $html = <<<HTML
                $html<tr>
                HTML;
                // Inserindo os dados na tabela
                for ($i = ($rows * 3); $i < min(($rows + 1) * 3, sizeof($array)); $i += 1) {
                    $html = <<<HTML
                    $html<td>
                    HTML;
                    $jogo = $array[$i];
                    foreach ($jogo as $key => $dado) {
                        if ($key == "imgpath") {
                            $html = <<<HTML
                            $html<img src="$dado"><br>
                            HTML;
                        } else {
                            $html = <<<HTML
                            $html<b>$key: $dado</b><br>
                            HTML;
                        }
                    }
                    $html = <<<HTML
                    $html</td>
                    HTML;
                }
                $html = <<<HTML
                $html</tr>
                HTML;
            }
        }
    }
    $html = <<<HTML
    $html</table>
    HTML;

    return $html;
}
