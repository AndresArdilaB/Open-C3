<? 
session_start();

if($_GET[op] != 1 ){ //aqui esta el buscador de grabaciones ?>
 <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
 <link rel="stylesheet" type="text/css" href="../../css/style.css">
<div align="center">
  <h3>Buscar Grabaciones
    </h3><form name="form1" onsubmit="EnviarLinkForm('RecordsFound','<?=$RAIZHTTP?>/modules/monitoring/recordings.php?op=1',this);return false;">
      <table border="0" align="center" cellpadding="0" cellspacing="2" class="rounded-corners-gray">
      <tr align="center">
        <td class="textos"><span class="texto">Desde</span></td>
        <td class="textomenu"><?=$formulario->c_fecha_input("","fecha_ini","","")?></td>
        <td align="left" class="textos">Numero Telefonico </td>
        <td align="left" class="textomenu"><input name="telefono" onfocus="if(this.value=='(Todos)') this.value=''" onblur="if(this.value=='') this.value='(Todos)'" type="text" id="telefono" value="(Todos)" /></td>
        <td align="left" class="textos">Contexto:
          <select name="contexto" id="contexto">
            <option value="-" selected="selected">Todos</option>
            <?
             mysql_select_db("asteriskcdrdb");
$SelectContext=$sqlm->sql_select("cdr","dcontext","1 GROUP BY dcontext",1);

	for($i=0 ; $i < count($SelectContext) ; $i++){                    

?>
            <option value="<?=$SelectContext[$i][dcontext]?>">
              <?=$SelectContext[$i][dcontext]?>
            </option>
            <?
              }
            ?>
          </select></td>
        <td rowspan="2" class="textomenu"><span class="tituloadmin">
          <input name="ver" type="submit" class="button" id="ver" value="Ver" <?=$control_to[1]?> onclick="EnviaPost('Resultado','buscar_grabaciones.php?option=2',this.form);" />
        </span></td>
      </tr>
      <tr align="center">
        <td class="textos">Hasta </td>
        <td class="textomenu"><?=$formulario->c_fecha_input("","fecha_fin","","")?></td>
        <td align="left" class="textos">Numero de extension</td>
        <td colspan="2" align="left" class="textomenu"><? mysql_select_db("asterisk");
         $ExteSelect=$sqlm->sql_select("sip","id","1 GROUP BY id",0);
             ?>
          <select name="Operador" id="Operador">
            <option value="-" selected="selected">Todos</option>
            <? for($d=0; $d < count($ExteSelect) ; $d++){ ?>
            <option value="<?=$ExteSelect[$d][id]?>"> Ext
              <?=$ExteSelect[$d][id]?>
            </option>
            <?  }  ?>
          </select></td>
        </tr>
    </table>
  </form>
</div>
<iframe width="100%" height="20px" name="reproductor" scrolling="no" frameborder="0"></iframe>
<div id="RecordsFound">
</div>
<? } //aqui esta el buscador de grabaciones 
if($_GET[op] == 1){  
include '../../appcfg/general_config.php';
$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->ReporteScripts();

if($telefono != "" and $telefono != "(Todos)"){	$clausulas .= "AND dst REGEXP '$telefono'";} 
if($contexto != "-"){$clausulas .= "AND dcontext = '$contexto'";} 
if($Operador != "-"){$clausulas .= "AND channel REGEXP '".$Operador."'";} 

mysql_select_db("asteriskcdrdb");
$grabacionSelect=$sqlm->sql_select("cdr","uniqueid,src,dcontext,channel,dst,calldate,billsec,userfield","DATE(calldate) BETWEEN '$fecha_ini' AND '$fecha_fin' AND disposition = 'ANSWERED' AND billsec > '15' AND dst != '' AND lastapp  != 'Queue' AND lastapp != 'AgentLogin' AND dst != 's' AND channel NOT REGEXP 'telmex'".$clausulas);

if(is_array($grabacionSelect)){
?>
<script>

$(document).ready(function(){
$('#RegResults').dataTable();

});

</script>  


<table border="0" align="center" cellpadding="2" cellspacing="2" id="RegResults" class="display">
  <thead>
  <tr>
    <th>Extension</th>
    <th>Telefono</th>
    <th>Fecha y Hora</th>
    <th>Contexto</th>
    <th>Minutos</th>
    <th>Segundos</th>
    <th>Grabacion</th>
    <th>Identificador</th>
  </tr>
  </thead>
  <? for($i=0 ; $i < count($grabacionSelect) ; $i++){ //arrancamos buscador ?>
  <tr>
    <td>
	<?    
		  $extencion1=explode("/",$grabacionSelect[$i][channel]);
		  $extencion=explode("-",$extencion1[1]);
		  echo $extencion[0];
	?>
    </td>
    <td><?=$grabacionSelect[$i][dst]?></td>
    <td><?=$grabacionSelect[$i][calldate]?></td>
    <td><?=$grabacionSelect[$i][dcontext]?></td>
    <td><?=number_format($grabacionSelect[$i][billsec]/60,1)?></td>
    <td><?=$grabacionSelect[$i][billsec]?></td>
    <td><div align="center" id="RecMostrar<?=$i?>"><a href="javascript:EnviarLinkJ('RecMostrar<?=$i?>','modules/monitoring/recfinder.php?unicoid=<?=$grabacionSelect[$i][uniqueid]?>');">Buscar Archivo</a></div></td>
    <td><?=$grabacionSelect[$i][uniqueid]?></td>
  </tr>
  <? }//cerramos el for de las grabaciones ?>
    <tfoot>
  <tr>
    <th>Extension</th>
    <th>Telefono</th>
    <th>Fecha y Hora</th>
    <th>Contexto</th>
    <th>Minutos</th>
    <th>Segundos</th>
    <th>Grabacion</th>
    <th>Identificador</th>
  </tr>
  </tfoot>
</table>
<? }//este es el if 
	else{ ?>
		
 <table border="0" align="center" cellpadding="2" cellspacing="2" id="RegResults" class="rounded-corners-blue">
  <thead>
  <tr>
    <th>Sin Resultados</th>
  </tr>
  </thead>
</table>
		
	<?	} } //if de la op 1?>


