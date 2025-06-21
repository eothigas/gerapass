<?php
function horaAtualComFuso($fusoHorario = 'America/Sao_Paulo') {
    $data = new DateTime('now', new DateTimeZone($fusoHorario));
    return $data->format('H:i');
}

function diaFormatadoComFuso($fusoHorario = 'America/Sao_Paulo') {
    $data = new DateTime('now', new DateTimeZone($fusoHorario));

    // Define nomes em português
    $diasSemana = [
        'Sunday'    => 'Domingo',
        'Monday'    => 'Segunda-feira',
        'Tuesday'   => 'Terça-feira',
        'Wednesday' => 'Quarta-feira',
        'Thursday'  => 'Quinta-feira',
        'Friday'    => 'Sexta-feira',
        'Saturday'  => 'Sábado'
    ];

    $meses = [
        'January'   => 'Janeiro',
        'February'  => 'Fevereiro',
        'March'     => 'Março',
        'April'     => 'Abril',
        'May'       => 'Maio',
        'June'      => 'Junho',
        'July'      => 'Julho',
        'August'    => 'Agosto',
        'September' => 'Setembro',
        'October'   => 'Outubro',
        'November'  => 'Novembro',
        'December'  => 'Dezembro'
    ];

    $diaSemana = $diasSemana[$data->format('l')];
    $mes = $meses[$data->format('F')];
    $dia = $data->format('d');

    return "$diaSemana, $dia de $mes";
}

function classesDiaNoite($fusoHorario = 'America/Sao_Paulo') {
    $hora = (int)(new DateTime('now', new DateTimeZone($fusoHorario)))->format('H');
    
    $isDia = ($hora >= 6 && $hora < 18);

    return [
        'sun_class'  => $isDia ? 'show' : 'hide',
        'moon_class' => $isDia ? 'hide' : 'show',
        'card_class' => $isDia ? 'card-dia' : 'card-noite'
    ];
}

$fuso = $_COOKIE['fuso_usuario'] ?? 'America/Sao_Paulo';
$classes = classesDiaNoite($fuso);
?>