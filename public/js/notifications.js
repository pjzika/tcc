// Verificar se o navegador suporta notificações
if ('serviceWorker' in navigator && 'PushManager' in window) {
    console.log('Service Worker e Push são suportados');

    // Registrar o Service Worker
    navigator.serviceWorker.register('/sw.js')
        .then(function(registration) {
            console.log('Service Worker registrado com sucesso:', registration);
            
            // Solicitar permissão para notificações
            return registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array('BBBDWQYtX_cPVZKxTFGCdqIB_M8SHRuBttPc4j8_xTsP5SNYqCAypc36co8hBaxI_uKD1vIYQedeu282RNwgFuc')
            });
        })
        .then(function(subscription) {
            console.log('Usuário inscrito:', subscription);
            
            // Enviar a inscrição para o servidor
            return fetch('/notifications/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ subscription })
            });
        })
        .then(function(response) {
            if (response.ok) {
                console.log('Inscrição salva com sucesso no servidor');
            } else {
                throw new Error('Falha ao salvar inscrição');
            }
        })
        .catch(function(error) {
            console.error('Erro:', error);
        });
} else {
    console.warn('Push messaging não é suportado');
}

// Função auxiliar para converter a chave VAPID
function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
} 