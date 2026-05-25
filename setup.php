<?php
require_once 'config/db.php';

try {
    $db = getDB();

    $db->exec("
        CREATE TABLE IF NOT EXISTS documentos (
            id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            codigo        VARCHAR(30)  NOT NULL UNIQUE,
            tipo          VARCHAR(50)  NOT NULL DEFAULT 'Atestado Médico',
            tratamento    VARCHAR(10)  NOT NULL DEFAULT 'Sr.',
            paciente      VARCHAR(255) NOT NULL,
            unidade       VARCHAR(255) NOT NULL DEFAULT '',
            endereco      VARCHAR(255) NOT NULL DEFAULT '',
            medico        VARCHAR(255) NOT NULL,
            especialidade VARCHAR(100) NOT NULL DEFAULT '',
            crm_estado    VARCHAR(5)   NOT NULL DEFAULT '',
            crm_numero    VARCHAR(20)  NOT NULL DEFAULT '',
            cns           VARCHAR(30)  NOT NULL DEFAULT '',
            data_atend    DATE         NOT NULL,
            quadro        TEXT         NOT NULL DEFAULT '',
            tipo_afast    VARCHAR(10)  NOT NULL DEFAULT 'dia',
            dias_afast    TINYINT      NOT NULL DEFAULT 1,
            data_afast    DATE         NULL,
            recomendacoes TEXT         NOT NULL DEFAULT '',
            cid           VARCHAR(20)  NOT NULL DEFAULT '',
            cidade        VARCHAR(100) NOT NULL DEFAULT '',
            observacoes   TEXT         NOT NULL DEFAULT '',
            status        ENUM('ativo','cancelado') NOT NULL DEFAULT 'ativo',
            created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    echo '<p style="color:green;font-family:monospace;">✅ Tabela <strong>documentos</strong> criada com sucesso!</p>';
    echo '<p style="font-family:monospace;"><a href="admin/">Ir para o Admin →</a></p>';
    echo '<p style="color:red;font-size:.85rem;font-family:monospace;">⚠️ Apague este arquivo (setup.php) após executar.</p>';

} catch (PDOException $e) {
    echo '<p style="color:red;font-family:monospace;">Erro: ' . htmlspecialchars($e->getMessage()) . '</p>';
}
