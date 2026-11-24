import mysql.connector

DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "",
    "database": "halfyway"
}

def get_connection():
    return mysql.connector.connect(**DB_CONFIG)

def buscar_vagas_abertas() -> list[dict]:
    conn = get_connection()
    try:
        cursor = conn.cursor(dictionary=True)
        cursor.execute(
            "SELECT id, titulo, descricao, salario, status FROM vagas WHERE status = 'aberta' ORDER BY id DESC LIMIT 10"
        )
        vagas = cursor.fetchall()
        for v in vagas:
            v["salario"] = float(v["salario"])
        return vagas
    finally:
        conn.close()

def buscar_servicos_agendados() -> list[dict]:
    conn = get_connection()
    try:
        cursor = conn.cursor(dictionary=True)
        cursor.execute(
            "SELECT id, nome_servico, tipo, status, data_agendada FROM servicos_triagem ORDER BY data_agendada ASC LIMIT 10"
        )
        servicos = cursor.fetchall()
        for s in servicos:
            s["data_agendada"] = str(s["data_agendada"])
        return servicos
    finally:
        conn.close()

def buscar_candidaturas_usuario(usuario_id: int) -> list[dict]:
    conn = get_connection()
    try:
        cursor = conn.cursor(dictionary=True)
        cursor.execute(
            """
            SELECT c.id, v.titulo, c.match_percentual, c.status, c.criado_em
            FROM candidaturas c
            JOIN vagas v ON v.id = c.vaga_id
            WHERE c.usuario_id = %s
            ORDER BY c.id DESC
            """,
            (usuario_id,)
        )
        candidaturas = cursor.fetchall()
        for c in candidaturas:
            c["criado_em"] = str(c["criado_em"])
        return candidaturas
    finally:
        conn.close()

def registrar_candidatura(usuario_id: int, vaga_id: int) -> dict:
    conn = get_connection()
    try:
        cursor = conn.cursor(dictionary=True)
        cursor.execute("SELECT id, titulo FROM vagas WHERE id = %s AND status = 'aberta'", (vaga_id,))
        vaga = cursor.fetchone()
        if not vaga:
            return {"sucesso": False, "mensagem": f"Vaga ID {vaga_id} não encontrada ou não está aberta."}

        cursor.execute(
            "SELECT id FROM candidaturas WHERE usuario_id = %s AND vaga_id = %s",
            (usuario_id, vaga_id)
        )
        if cursor.fetchone():
            return {"sucesso": False, "mensagem": f"Você já está candidatado à vaga '{vaga['titulo']}'."}

        cursor.execute(
            "INSERT INTO candidaturas (usuario_id, vaga_id, match_percentual, status) VALUES (%s, %s, %s, 'enviada')",
            (usuario_id, vaga_id, 88)
        )
        conn.commit()
        return {"sucesso": True, "mensagem": f"Candidatura registrada com sucesso na vaga '{vaga['titulo']}'!"}
    finally:
        conn.close()

def buscar_historico_chat(usuario_id: int, limite: int = 5) -> list[dict]:
    conn = get_connection()
    try:
        cursor = conn.cursor(dictionary=True)
        cursor.execute(
            """
            SELECT mensagem_usuario, resposta_bot
            FROM chat_logs
            WHERE usuario_id = %s
            ORDER BY id DESC
            LIMIT %s
            """,
            (usuario_id, limite)
        )
        return list(reversed(cursor.fetchall()))
    finally:
        conn.close()

def salvar_log(usuario_id: int | None, mensagem_usuario: str, resposta_bot: str, intencao: str) -> None:
    conn = get_connection()
    try:
        cursor = conn.cursor()
        cursor.execute(
            """
            INSERT INTO chat_logs (usuario_id, mensagem_usuario, resposta_bot, intencao_detectada)
            VALUES (%s, %s, %s, %s)
            """,
            (usuario_id, mensagem_usuario, resposta_bot, intencao)
        )
        conn.commit()
    finally:
        conn.close()