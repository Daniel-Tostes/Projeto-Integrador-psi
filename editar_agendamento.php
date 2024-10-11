<?php
$conn = new mysqli("localhost", "root", "", "banco_psi");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM agendamentos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $agendamento = $result->fetch_assoc();
        if (isset($agendamento['data']) && !empty($agendamento['data'])) {
            $data_formatada = date('Y-m-d', strtotime($agendamento['data']));
        } else {
            $data_formatada = ''; 
        }
    } else {
        echo "Agendamento não encontrado.";
        exit;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data = $_POST['data'];
    $horario = $_POST['horario'];

    $sql = "UPDATE agendamentos SET nome=?, email=?, data=?, horario=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $data, $horario, $id);

    if ($stmt->execute()) {
        echo "Agendamento atualizado com sucesso!";
        header("Location: agendamentos_marcados.php");
        exit;
    } else {
        echo "Erro ao atualizar agendamento: " . $conn->error;
    }
} else {
    echo "Acesso inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
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
        form {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        label, input {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="email"], input[type="date"], input[type="time"] {
            padding: 10px;
            font-size: 16px;
        }
        button {
            background-color: #ff69b4;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff1493;
        }
    </style>
</head>
<body>

<h1>Editar Agendamento</h1>

<form method="POST" action="editar_agendamento.php">
    <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
    
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo $agendamento['nome']; ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo $agendamento['email']; ?>" required>
    
    <label for="data">Data:</label>
    <input type="date" id="data" name="data" value="<?php echo $data_formatada; ?>" required>
    
    <label for="horario">Horário:</label>
    <input type="time" id="horario" name="horario" value="<?php echo $agendamento['horario']; ?>" required>
    
    <button type="submit">Salvar Alterações</button>
</form>

</body>
</html>
