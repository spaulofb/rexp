
<?php
// Dados recebidos de um FORM
set_time_limit(0);

// Inicializando a sessão
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Configuração de caracteres UTF-8
header("Content-Type: text/html; charset=UTF-8");

mb_internal_encoding("UTF-8");

// --------------------------------------------------
// Recebimento dos dados
// IMPORTANTE: os dados devem chegar em UTF-8.
// Não converter para ISO-8859-1.
// --------------------------------------------------

$campo_nome  = (string) ($campo_nome ?? '');
$campo_value = (string) ($campo_value ?? '');
$cpo_final   = (string) ($cpo_final ?? '');

// --------------------------------------------------
// Tratamento dos nomes dos campos
// --------------------------------------------------

if ($cpo_final !== '') {
    $pos_final = strpos($campo_nome, ",$cpo_final");

    if ($pos_final !== false) {
        $campo_nome = substr($campo_nome, 0, $pos_final);
    }
}

if (strtoupper(trim($cpo_final)) == "ALTERAR") {

    $n_coresp_novo = strpos($campo_nome, ",ncoautor_novo");

    if ($n_coresp_novo !== false) {

        $pos_ncoautor = strpos($campo_nome, ",ncoautor");

        if ($pos_ncoautor !== false) {
            $campo_nome = substr($campo_nome, 0, $pos_ncoautor);
        }
    }
}

// --------------------------------------------------
// Separando nomes e valores
// --------------------------------------------------

$array_cpos_nomes = explode(",", $campo_nome);
$array_value      = explode(",", $campo_value);

$count_array_nomes = count($array_cpos_nomes);

$array_valores = array();
$arr_nome_val  = array();

// --------------------------------------------------
// Inicialização
// --------------------------------------------------

$i_codigousp = -1;

$campos_nome  = "";
$campos_valor = "";

// --------------------------------------------------
// Processamento dos campos
// --------------------------------------------------

for ($i = 0; $i < $count_array_nomes; $i++) {

    $nome_campo = trim($array_cpos_nomes[$i]);

    // Obtendo o valor correspondente
    $valor_incluir = trim($array_value[$i] ?? '');

    // Se os dados já vierem como entidades HTML,
    // descomente a linha abaixo para decodificar UMA vez.
    // $valor_incluir = html_entity_decode(
    //     $valor_incluir,
    //     ENT_QUOTES | ENT_HTML5,
    //     'UTF-8'
    // );

    // CPF: retirar pontos e traço
    if (strtoupper($nome_campo) == "CPF") {

        $valor_incluir = preg_replace('/[.-]+/', '', $valor_incluir);

    } elseif (preg_match("/data/i", $nome_campo)) {

        // Converter data DD/MM/YYYY para YYYY-MM-DD
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $valor_incluir, $data)) {

            $valor_incluir = $data[3] . "-" .
                             $data[2] . "-" .
                             $data[1];
        }
    }

    // Guardando os valores
    $array_valores[$i] = $valor_incluir;

    $arr_nome_val[$nome_campo] = $valor_incluir;

    // Localizando CODIGOUSP
    if (strtoupper($nome_campo) == "CODIGOUSP") {
        $i_codigousp = $i;
    }

    // Montando os campos
    $campos_nome .= $nome_campo . ",";

    $campos_valor .= $valor_incluir . ",";
}

// --------------------------------------------------
// Retirando a última vírgula
// --------------------------------------------------

$campos_nome  = rtrim($campos_nome, ",");
$campos_valor = rtrim($campos_valor, ",");

// --------------------------------------------------
// Gravando na SESSION
// --------------------------------------------------

$_SESSION["campos_nome"]  = $campos_nome;
$_SESSION["campos_valor"] = $campos_valor;

$cpo_nome  = $_SESSION["campos_nome"];
$cpo_valor = $_SESSION["campos_valor"];

// Código USP
$_SESSION["i_codigousp"] = (int) $i_codigousp;

// Informações de controle
$_SESSION["nomes_cpos"] =
    $campos_nome . "+++++" .
    $count_array_nomes . "---" .
    count($array_valores);

// --------------------------------------------------
// Liberando resultado MySQL, se existir
// --------------------------------------------------

if (isset($result_tabela) && $result_tabela instanceof mysqli_result) {
    mysqli_free_result($result_tabela);
}

?>
