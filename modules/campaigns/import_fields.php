<? 
session_start();

if($_GET[op] != 1 and $_GET[op] != 2 and $_GET[op] != 3and $_GET[op] != 4 and $_GET[op] != 5 and $_GET[op] != 6 and $_POST[addcampo] != 1){ 

include("../../appcfg/cc.php");
include("../../appcfg/func_mis.php");
include("../../appcfg/js_scripts.php");
include("../../appcfg/class_sqlman.php");
include("../../appcfg/class_forms.php");
include("../../appcfg/class_autoforms.php");

$sqlm= new Man_Mysql();

$JsScripts= new ScriptsSitio();
$JsScripts->rutaserver="$RAIZHTTP";
$JsScripts->AllScripts();

$formulario = new Generar_Formulario();
$formulario->RutaRaiz="$RAIZHTTP";

$formulario_auto = new Auto_Forms();
$formulario_auto->RutaRaiz="$RAIZHTTP";
$formulario_auto->RutaHTTP="$RAIZHTTP";

//------------------------------------------------------------- 
$TraerFormCampania 	= $sqlm->sql_select("autoform_tablas","campaignid","id_autoformtablas = '$_GET[formid]'",0);
$SeleccionaForms	= $sqlm->sql_select("autoform_tablas","id_autoformtablas,labeltabla,nombretabla","campaignid = '".$TraerFormCampania[0][campaignid]."' ORDER BY id_autoformtablas",0);

?>
 	<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
 
 <div align="center">
   <form id="form1" name="form1" method="post" action="import_fields.php?op=1">
<? for($t = 0 ;$t < count($SeleccionaForms) ; $t++) {

$formgrupos = $sqlm->sql_select("autoform_grupos","labelgrupo,id_autoformgrupos","idtabla_rel = '".$SeleccionaForms[$t][id_autoformtablas]."' ORDER BY posiciongrupo",0);

?>
   
<div align="center" class="rounded-corners-gray"><span class="textos_titulos">Formulario: <?=$SeleccionaForms[$t][labeltabla]?></span></div>
     <table border="0" align="center" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
       <tr>
         <td colspan="2" align="center" class="textos_titulos"><p>Seleccione Los Campos a Importar</p></td>
       </tr>
       <? for($i=0 ; $i < count($formgrupos) ; $i++ ){ 
$formcampos = $sqlm->sql_select("autoform_config","labelcampo,nombrecampo,tipocampo,paramcampo","idgrupo = '".@$formgrupos[$i][id_autoformgrupos]."' AND eliminado = 0 ORDER BY poscampo",0);
?>
       <tr>
         <td class="textos_titulos"><?=@$formgrupos[$i][labelgrupo]?>
         &nbsp;           <label for="condicion[]"></label></td>
         <td align="center" class="textos_titulos">Incluir</td>
       </tr>
       <? for($o=0 ; $o < count($formcampos) ; $o++ ){ ?>
       <tr>
         <td class="textospadding"><?=utf8_encode(@$formcampos[$o][labelcampo])?>
           &nbsp;</td>
         <td align="center" class="textospadding"><input name="incluir[]" type="checkbox" id="incluir[]" value="<?=$formcampos[$o][nombrecampo]?>" />
         <label for="incluir[]"></label></td>
       </tr>

       <? 
} // segundo for
} // primer for
?>       
		<tr>
         <td colspan="2" align="center" class="textospadding"><input type="submit" name="button" id="button" value="Guardar" />
          <input name="idforma" type="hidden" id="idforma" value="<?=$_GET[formid]?>" /></td>
       </tr>
     </table>
<? } ?> 
   </form>
 </div>
<? }  //termina el primer paso
if($_GET[op] == 1){ // termina la prime opcion
include '../../appcfg/general_config.php';

//print_r($_POST);

for($i=0 ; $i < count($_POST[incluir]) ; $i++){
	
	if($_POST[incluir][$i] != ""){
	$CamposMos .= $_POST[incluir][$i].",";
	}
//---------------	
	}
 
 $CamposMosF=substr($CamposMos,0,-1);
 
 $sqlm->inser_data("importdata","campos,idform","'$CamposMosF','$_POST[idforma]'",1);
 
//echo "$cadenaF";
?>
<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>

<div align="center"><br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table border="0" cellpadding="0" cellspacing="0" class="rounded-corners-blue">
    <tr>
      <td align="center" class="textos_titulos">La configuracion fue guardada</td>
    </tr>
  </table>
</div>

<?  } // termina la prime opcion ?>
 
 