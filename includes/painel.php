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
$processes = $conex->query("
    SELECT * 
    FROM information_schema.PROCESSLIST
    WHERE DB IS NOT NULL
");


if( ! $processes ) {
     $merr="Selecionando BDs ativos -&nbsp;db/mysqli:&nbsp;";   
     echo $funcoes->mostra_msg_erro("$merr".mysqli_error($_SESSION["conex"]));
     exit();
}
$statusThreads = $conex->query("SHOW STATUS LIKE 'Threads_connected'")->fetch_assoc();
$statusRunning = $conex->query("SHOW STATUS LIKE 'Threads_running'")->fetch_assoc();
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

<div class="card">
    <h3>Conexões Ativas</h3>
    <p><?php echo $statusThreads['Value']; ?></p>
</div>

<div class="card">
    <h3>Threads Rodando</h3>
    <p class="running"><?php echo $statusRunning['Value']; ?></p>
</div>

<h2>Processos</h2>
<table class="tablex" >
<tr>
<th>ID</th><th>DB</th><th>Command</th><th>Time</th><th>State</th>
</tr>
<?php while($row = $processes->fetch_assoc()): ?>
<tr>
<td><?= $row['ID'] ?></td>
<td><?= $row['DB'] ?></td>
<td class="<?= strtolower($row['COMMAND']) ?>"><?= $row['COMMAND'] ?></td>
<td><?= $row['TIME'] ?></td>
<td><?= $row['STATE'] ?></td>
</tr>
<?php endwhile; ?>
</table>


