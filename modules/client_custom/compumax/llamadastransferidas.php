<?
session_start();
if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3 and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_GET[op] != 7){

?>
<link rel="stylesheet" type="text/css" href="../../../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../../../css/estilos.css"/>

<div align="center">
  <h3>Informes de Call Center</h3>
</div>
<div align="center" class="rounded-corners-gray">
  <form name="form1" method="post" onSubmit="EnviarLinkForm('PersInf','<?=$RAIZHTTP?>/modules/client_custom/compumax/llamadastransferidas.php?op=1',this);return false;">
    <table width="0" border="0" cellspacing="0" cellpadding="0">
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Inicial: <br></td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_ini","","")?></td>
        <td rowspan="2" class="textos_titulos"><span class="textosbig">
          <input type="submit" name="button" id="button" value="Generar">
        </span></td>
      </tr>
      <tr class="textos_titulos">
        <td class="textos_titulos">Fecha Final: </td>
        <td class="textos_titulos"><?=$formulario->c_fecha_input("","fecha_fin","","")?></td>
      </tr>
    </table>
  </form>
</div>
<br />
<div id="PersInf"></div>
<? 
}//este es el que saca si no ahy ninguna opcion
if($_GET[op] == 1){ // aqui termina la opcion 1
include '../../../appcfg/general_config.php';


//--- aqui seleccionamos la data
mysql_select_db ("asteriskcdrdb"); 
$SelectData = $sqlm->sql_select("cdr","*","dstchannel NOT REGEXP dst AND dst != 's' AND length(src) > 4 AND dst NOT IN (600,601,1,'s','') AND dstchannel != '' AND length(dst) > 1  AND dstchannel REGEXP 'sip' AND dstchannel NOT REGEXP 'gsm' AND calldate BETWEEN '$_GET[fecha_ini]' AND '$_GET[fecha_fin]'",0);


if(is_array($SelectData)){
	
	excelexp("reporto");
?>
<div>
<table border="0" cellpadding="2" cellspacing="2" bgcolor="#CCCCCC" id="reporto">
  <tr>
    <td bgcolor="#FFFFFF" class="textos_titulos">Numero de Origen</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Extension Inicial</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Extension Final</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Duracion (seg)</td>
    <td bgcolor="#FFFFFF" class="textos_titulos">Fecha y Hora</td>
    </tr>
<? 

for($i=0 ; $i < count($SelectData) ; $i++){

$dstc = explode("/",$SelectData[$i][dstchannel]);
$dstc2 = explode("-",$dstc[1]);
	
?>
  <tr>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][src]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][dst]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$dstc2[0]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][duration]?></td>
    <td bgcolor="#FFFFFF" class="textospadding"><?=$SelectData[$i][calldate]?></td>
    </tr>
<? } ?>
</table>
</div>

<?
}


} // aqui termina la opcion 1?>