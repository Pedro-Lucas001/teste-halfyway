document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const chatInput = document.getElementById('chat-input');
    const btnEnviar = document.getElementById('btn-enviar-chat');
  
    if (!chatBox || !chatInput || !btnEnviar) return;
  
    function adicionarMensagem(texto, tipo) {
      const div = document.createElement('div');
      div.classList.add('msg', tipo === 'user' ? 'msg-user' : 'msg-bot');
      div.textContent = texto;
      chatBox.appendChild(div);
      chatBox.scrollTop = chatBox.scrollHeight;
      return div;
    }
  
    async function enviarMensagem() {
      const mensagem = chatInput.value.trim();
      if (!mensagem) return;
  
      // 1. Renderiza a mensagem do usuário
      adicionarMensagem(mensagem, 'user');
      chatInput.value = '';
      chatInput.disabled = true;
      btnEnviar.disabled = true;
  
      // 2. Feedback visual enquanto o Python processa a IA
      const loadingMsg = adicionarMensagem('Processando...', 'bot');
  
      try {
        const response = await fetch('../controllers/BotController.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ mensagem })
        });
  
        if (!response.ok) throw new Error('Falha na comunicação com o servidor');
  
        const data = await response.json();
        loadingMsg.textContent = data.resposta || 'Não consegui entender sua solicitação.';
      } catch (error) {
        loadingMsg.textContent = 'Servidor do chatbot offline no momento. Verifique se o PHP e o Flask (Python) estão ativos.';
        console.error('Erro no chatbot:', error);
      } finally {
        chatInput.disabled = false;
        btnEnviar.disabled = false;
        chatInput.focus();
        chatBox.scrollTop = chatBox.scrollHeight;
      }
    }
  
    btnEnviar.addEventListener('click', enviarMensagem);
  
    chatInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        enviarMensagem();
      }
    });
  });