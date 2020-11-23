<?php

require_once __DIR__ . '../mpdf-8/vendor/autoload.php';

?>

<?php
include_once '../model/relatorio.php';
//Chamando função de consulta

$bens = RelatorioSetorLocal($_POST['relatorio-local']);
?>

    <?php while ($bem = mysqli_fetch_assoc($bens)) : ?>
<?php
$setor = "{$bem['nome_setor']}";
?>

    <?php endwhile; ?>
        <?php


        $nomeeteot = 'ESCOLA TÉCNICA OSCAR TENÓRIO';

        

        $h = "<div style='text-align:right;'>Página {PAGENO} de {nbpg}</div>";

        $html1 = "
 <fieldset>
 <div class='cabecalho'>
 <div class='imgcab'><img src='\projeto-g1/images/logo.png'></div>
 <div class='titcab'>
 $nomeeteot
 </div>
 </div>
 ";

        $html1 .= "
 <h2>
 <div class='titulorel'>" . $setor . "</div>
 </h2>
 ";

        $html1 .= "
 <div class='referencia'>
 <h4>
 <div class='ref2'>SISTEMA DE INVENTÁRIO</div>
 </h4>
 </div>
 </hr>
 ";

        $html1 .= "
 <div class='dados'>
 <table class='fontedados' cellspacing='2' cellpadding='2' width='100%'>
 <tr>
 <td width='10%'><strong>Nº INVENTÁRIO</strong></td>
 <td width='30%'><strong>IDENTIFICAÇÃO</strong></td>
 <td width='20%'><strong>OPERAÇÃO</strong></td>
 <td width='20%'><strong>SITUAÇÃO</strong></td>
 <td width='20%'><strong>CHECK</strong></td>
 </tr>
 ";
        ?>

<?php
include_once '../model/relatorio.php';
//Chamando função de consulta

$bens = RelatorioSetorLocal($_POST['relatorio-local']);
?>

<?php if (mysqli_num_rows($bens) > 0) : ?>
    <?php while ($bem = mysqli_fetch_assoc($bens)) : ?>

        <?php
        $html1 .= "
        
         <tr style='background:#eee;'>
             <td>{$bem['numero_inventario_bem']}</td>
             <td>{$bem['identificacao_bem']}</td>
             <td>{$bem['nome_operacao']}</td>
             <td>{$bem['nome_situacao']}</td>
             <td><spam class=\"quadrado\">[ &nbsp; &nbsp; ]</spam></td>
         </tr>
         ";
        ?>
    <?php endwhile; ?>
<?php else : ?>
    <tr>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
        <td>-</td>
    </tr>
<?php endif; ?>
<?php
$html1 .= "</table>
     </div><br>";

$htmlfooter = "
     <hr>
     <div class='rodape'>Emissão: " . date('d/m/y - H:i:s') . "</div>
     </fieldset>
     ";
?>

<?php

$mpdf = new \Mpdf\Mpdf();
$mpdf->setDisplayMode('fullpage');
$stylesheet = file_get_contents('../css/stylerel.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->SetHTMLHeader($h);
$mpdf->SetHTMLFooter($htmlfooter);
$mpdf->WriteHTML($html1);
$mpdf->Output();
?>