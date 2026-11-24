import os
from dotenv import load_dotenv
from google import genai
from google.genai import types
import db_service

load_dotenv()

def processar_mensagem(usuario_id: int | None, mensagem: str) -> tuple[str, str]:
    api_key = os.getenv("GEMINI_API_KEY")
    if not api_key:
        return (
            "Chave GEMINI_API_KEY não configurada no arquivo .env da pasta chatbot_python.",
            "erro_configuracao"
        )

    client = genai.Client(api_key=api_key)
    intencao = {"nome": "duvida_geral"}

    # Ferramentas que o agente de IA pode acionar automaticamente no MySQL
    def listar_vagas() -> list[dict]:
        """Lista as vagas de emprego atualmente abertas na plataforma HalfyWay."""
        intencao["nome"] = "buscar_vagas"
        return db_service.buscar_vagas_abertas()

    def listar_servicos_triagem() -> list[dict]:
        """Lista os serviços de triagem, entrevistas técnicas e avaliações agendadas."""
        intencao["nome"] = "buscar_servicos"
        return db_service.buscar_servicos_agendados()

    def consultar_minhas_candidaturas() -> list[dict]:
        """Consulta as candidaturas já enviadas pelo usuário atual."""
        intencao["nome"] = "consultar_candidaturas"
        if not usuario_id:
            return []
        return db_service.buscar_candidaturas_usuario(usuario_id)

    def candidatar_em_vaga(vaga_id: int) -> dict:
        """Inscreve o usuário atual em uma vaga aberta informando o ID numérico da vaga."""
        intencao["nome"] = "registrar_candidatura"
        if not usuario_id:
            return {"sucesso": False, "mensagem": "Usuário não autenticado."}
        return db_service.registrar_candidatura(usuario_id, vaga_id)

    # Monta o histórico recente para Gerenciamento de Diálogo
    historico_texto = ""
    if usuario_id:
        historico = db_service.buscar_historico_chat(usuario_id, limite=5)
        for item in historico:
            historico_texto += f"Usuário: {item['mensagem_usuario']}\nAssistente: {item['resposta_bot']}\n"

    system_instruction = (
        "Você é o assistente virtual da plataforma de recrutamento HalfyWay. "
        "Responda sempre em português do Brasil, de forma clara, objetiva e amigável. "
        "Use as ferramentas disponíveis sempre que o usuário perguntar sobre vagas, serviços de triagem, "
        "suas candidaturas ou pedir para se candidatar a uma vaga."
    )

    prompt = (
        f"Histórico recente da conversa:\n{historico_texto}\n"
        f"Mensagem atual do usuário: {mensagem}"
    )

    try:
        response = client.models.generate_content(
            model="gemini-2.5-flash",
            contents=prompt,
            config=types.GenerateContentConfig(
                system_instruction=system_instruction,
                tools=[
                    listar_vagas,
                    listar_servicos_triagem,
                    consultar_minhas_candidaturas,
                    candidatar_em_vaga,
                ],
                temperature=0.4,
            ),
        )
        texto_final = response.text or "Não consegui gerar uma resposta no momento."
        return texto_final, intencao["nome"]
    except Exception as e:
        return f"Erro ao processar com a IA: {str(e)}", "erro_ia"