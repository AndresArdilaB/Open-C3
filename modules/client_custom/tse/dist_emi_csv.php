<?
session_start();

include '../../../appcfg/general_config.php';

$SelectDATA = $sqlm->sql_select("autof_matrizprincipal_1","*","DATE(af13_34) BETWEEN '$_GET[fechai]' AND '$_GET[fechaf]'",0);

if(is_array($SelectDATA)){

$htm .= "Mes Fisico,Fecha Fisico TSE,Campaña,Estado Custodia,Identificacion Cliente,SEUDOCODIGO,Nombre Cliente,Activacion,Fecha de Activacion,Fecha de Entrega / Envio,DATOS TERCERO AUTORIZADO,Tipo de Entrega,Nombre Asesor Call Center,Gestion Realizada,Call,Fecha de Gestion Call Center,Ciudad Base,Direccion Cita,Cupo,Nombre Base,Bodega,Gestion Mesa,Punto de Venta,Fecha Entrega,Cliente,Feedback manifiesto,FECHA BANCO BASE AGENDAMIENTO,FECHA RECEPCION BASE TSE,Tipo de entrega inicial,# Bolsa seguridad de salida,Código de dirección,Id Registro \r";


for($i=0;$i < count($SelectDATA);$i++){ 


$CustodiuaDATA = $sqlm->sql_select("inv_inventario,inv_estado","estado,fechasalida,idbodega","idregistro ='".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND idestado = id_estado",0);

if(is_array($CustodiuaDATA)){
$BodegaNombre = $sqlm->sql_select("inv_bodegas","nombre","id_bodegas ='".$CustodiuaDATA[0][idbodega]."'",0);
}
if(is_array($BodegaNombre)){$BodegaTxt = $BodegaNombre[0][nombre];}else{$BodegaTxt = "";}

$campanaDATA= $sqlm->sql_select("autof_af13_38","field1","id_af13_38 ='".$SelectDATA[$i][af13_38]."'",0);
if(is_array($campanaDATA)){	$campanaTEXT = $campanaDATA[0][field1];	}else{ $campanaTEXT = ""; }

$activacionDATA = $sqlm->sql_select("autof_af13_126","field1","id_af13_126 ='".$SelectDATA[$i][af13_126]."'",0);
if(is_array($activacionDATA)){$actData = $activacionDATA[0][field1];	}else{ $actData = ""; }

$tipoentDATA = $sqlm->sql_select("autof_af13_155","field1","id_af13_155 ='".$SelectDATA[$i][af13_155]."'",0);
if(is_array($tipoentDATA)){$entData = $tipoentDATA[0][field1];	}else{ $entData = ""; }

$gescallDATA = $sqlm->sql_select("autof_af13_109","field1","id_af13_109 ='".$SelectDATA[$i][af13_109]."'",0);
if(is_array($gescallDATA)){$gescallText = $gescallDATA[0][field1];	}else{ $gescallText = ""; }


$gmesaDATA = $sqlm->sql_select("autof_af13_100","field1","id_af13_100 ='".$SelectDATA[$i][af13_100]."'",0);
if(is_array($gmesaDATA)){$gmesaText = $gmesaDATA[0][field1];	}else{ $gmesaText = ""; }


$pventaDATA = $sqlm->sql_select("autof_af13_92","field1","id_af13_92 ='".$SelectDATA[$i][af13_92]."'",0);
if(is_array($pventaDATA)){$pventaText = $pventaDATA[0][field1];	}else{ $pventaText = ""; }

$CiudadData = $sqlm->sql_select("autof_af13_37","field1","id_af13_37 ='".$SelectDATA[$i][af13_37]."'",0);
if(is_array($CiudadData)){$CiudadBText = $CiudadData[0][field1];	}else{ $CiudadBText = ""; }


if(is_array($CustodiuaDATA)){
	
	$estadoINV = $CustodiuaDATA[0][estado]; 
	$fechaSalidaINV = $CustodiuaDATA[0][fechasalida]; 
	
	}else {
		
	$estadoINV = "";
	$fechaSalidaINV = ""; 
	
	} 

$OperadorDATA = $sqlm->sql_select("agents,history_1","name","id_reg = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' AND id_agents = id_usuario AND tipo = 0 ORDER BY id_history_1 DESC LIMIT 0,1",0);


if(is_array($OperadorDATA)){$operadorText = $OperadorDATA[0][name];}else{ $operadorText = ""; }


//nuevos campos de soporte adicionados el 13 de diciembre

$AgendaFeed = $sqlm->sql_select("agenda","feedback","idregistro = '".$SelectDATA[$i][autof_matrizprincipal_1_id]."' ORDER BY id_agenda DESC",0);

if(is_array($AgendaFeed)){

$AgendaFeedDATA = $sqlm->sql_select("agenda_estados","estado","id_estado = '".$AgendaFeed[0][feedback]."'",0);
if(is_array($AgendaFeedDATA)){ $FeedBACKT = $AgendaFeedDATA[0][estado]; }else{ $FeedBACKT = ""; }

}else{ $FeedBACKT = ""; }


//*****

$tentregadataDATA = $sqlm->sql_select("autof_af13_795","field1","id_af13_795 ='".$SelectDATA[$i][af13_795]."'",0);
if(is_array($tentregadataDATA)){$tentregaText = $tentregadataDATA[0][field1];	}else{ $tentregaText = ""; }



$dircodDATA = $sqlm->sql_select("autof_af13_796","field1","id_af13_796 ='".$SelectDATA[$i][af13_796]."'",0);
if(is_array($dircodDATA)){$coddirText = $dircodDATA[0][field1];	}else{ $coddirText = ""; }


$htm .= $SelectDATA[$i][af13_33].",".$SelectDATA[$i][af13_34].",".$campanaTEXT.",".$estadoINV.",".$SelectDATA[$i][af13_39].",".$SelectDATA[$i][af13_41].",".$SelectDATA[$i][af13_40].",".$actData.",".$SelectDATA[$i][af13_128].",".$fechaSalidaINV.",".$SelectDATA[$i][af13_794].",".$entData.",".$operadorText.",".$gescallText.",".substr($SelectDATA[$i][af13_34],0,10).",".$CiudadBText.",".$SelectDATA[$i][af13_145].",".$SelectDATA[$i][af13_42].",".$SelectDATA[$i][af13_171].",".$BodegaTxt.",".$gmesaText.",".$pventaText.",".$SelectDATA[$i][af13_93].",".$FeedBACKT.",".$SelectDATA[$i][af13_35].",".$SelectDATA[$i][af13_36].",".$tentregaText."".$SelectDATA[$i][af13_152].",".$coddirText.",".$SelectDATA[$i][autof_matrizprincipal_1_id]."\r";

 } 
 
 
}//aqui si hay resultados

else{ 


$htm .= "No hay registros";


	}



$unirfecha= str_ireplace("-","",$_GET[fechai]);

$new_report=fopen("../../../tmp/emision_distribucion_".$unirfecha.".csv","w");
 
fwrite($new_report, $htm);
 
fclose($new_report);
 
?> 
<br />
<br />
<br />
<br />
<br />
<br />
 <center> <a href="../../../tmp/emision_distribucion_<?=$unirfecha?>.csv" ><strong>Descargar Reporte</strong></a> <br>
       de click secundario y luego la opcion guardar enlace como
  </center> 
