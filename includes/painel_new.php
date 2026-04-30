<?php
//
/**  Bancos de Dados ativos - MYSQLI */
// $proc="SELECT * FROM information_schema.PROCESSLIST WHERE COMMAND != 'Sleep' ";
//  $rsql = $conex->query($proc);                                    
//
// BUSCAR DADOS
/**
 *  $processes = $conex->query("SELECT * FROM information_schema.PROCESSLIST WHERE COMMAND != 'Sleep' ");
*  $processes = $conex->query("SELECT * FROM information_schema.PROCESSLIST  ");
 */

$processes = $conex->query("SELECT CURRENT_SCHEMA AS DB,
    COUNT(*) AS total 
    FROM performance_schema.events_statements_history
    GROUP BY CURRENT_SCHEMA
    ORDER BY total DESC"
);
if( ! $processes ) {
     $merr="Selecionando BDs ativos -&nbsp;db/mysqli:&nbsp;";   
     echo $funcoes->mostra_msg_erro("$merr".mysqli_error($_SESSION["conex"]));
     exit();
}
//
//
?>
<style>
.card { display:inline-block; padding:15px; margin:10px; color: #FFFFFF; background:#222; border-radius:8px; }
.tablex { width:100%; border-collapse: collapse; margin-top:20px; }
.tablex th, td { padding:8px; border:1px solid #444; font-size:12px; }
.tablex th { background:#333; color:#FFFFFF;}
.running { color:lime; }
.sleep { color:orange; }
</style>
<h1>📊 Dashboard MariaDB (Tempo Real)</h1>

<h2>Bancos mais usados</h2>
<table class="tablex" >
<tr>
<th>DB</th><th>Uso</th>
</tr>
<?php while($row = $processes->fetch_assoc()): ?>
<tr>
<td><?php $row['DB'] ?></td>
<td class="<?php strtolower($row['total']) ?>"><?= $row['total'] ?></td>
</tr>
<?php endwhile; ?>
</table>


