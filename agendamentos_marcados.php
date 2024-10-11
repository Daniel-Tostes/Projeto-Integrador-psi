<?php
$conn = new mysqli("localhost", "root", "", "banco_psi");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT id, nome, email, data, horario FROM agendamentos ORDER BY data DESC, horario DESC";  
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos Marcados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; 
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd; 
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #ff69b4; 
            color: white; 
        }
        .btn-voltar, .btn-editar {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ff69b4; 
            color: white; 
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            text-align: center;
            cursor: pointer;
        }
        .btn-voltar:hover, .btn-editar:hover {
            background-color: #ff1493; 
        }
        .btn-voltar {
            display: block;
            width: 200px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<h1>Agendamentos Marcados</h1>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["nome"]; ?></td>
                    <td><?php echo $row["email"]; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($row["data"])); ?></td>
                    <td><?php echo date("H:i", strtotime($row["horario"])); ?></td>
                    <td>
                        <a class="btn-editar" href="editar_agendamento.php?id=<?php echo $row['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum agendamento marcado.</p>
<?php endif; ?>

<a href="index.php" class="btn-voltar">Voltar ao Início</a>

<?php $conn->close(); ?>

</body>
</html>
