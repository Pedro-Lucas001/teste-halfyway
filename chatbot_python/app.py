from flask import Flask, request, jsonify
from flask_cors import CORS
import ai_service
import db_service

app = Flask(__name__)
CORS(app)

@app.route("/health", methods=["GET"])
def health():
    return jsonify({"status": "online", "servico": "HalfyWay Chatbot IA"})

@app.route("/chat", methods=["POST"])
def chat():
    dados = request.get_json(silent=True) or {}
    usuario_id = dados.get("usuario_id")
    mensagem = str(dados.get("mensagem", "")).strip()

    if not mensagem:
        return jsonify({"erro": "Mensagem vazia"}), 400

    resposta_bot, intencao = ai_service.processar_mensagem(usuario_id, mensagem)

    try:
        db_service.salvar_log(usuario_id, mensagem, resposta_bot, intencao)
    except Exception as e:
        print(f"Aviso: falha ao salvar log no MySQL: {e}")

    return jsonify({
        "resposta": resposta_bot,
        "intencao": intencao
    })

if __name__ == "__main__":
    app.run(host="127.0.0.1", port=5000, debug=True)