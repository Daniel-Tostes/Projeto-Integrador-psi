<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "banco_psi");

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    $data = $_POST['date'];
    $horario = $_POST['horario'];

    $dataFormatada = DateTime::createFromFormat('d-m-Y', $data);
    if ($dataFormatada) {
        $dataFormatada = $dataFormatada->format('Y-m-d');
    } else {
        echo "Data inválida!";
        exit;
    }

    $sql = "INSERT INTO agendamentos (nome, email, telefone, data, horario) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $telefone, $dataFormatada, $horario);

    if ($stmt->execute()) {
        echo "<script>
                alert('Cadastro realizado!');
                setTimeout(() => {
                    window.location.href = 'index.php'; // redireciona para a página inicial
                }, 2000);
              </script>";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
