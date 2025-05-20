console.log('Teste de JavaScript carregado com sucesso!');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM carregado com sucesso!');
    
    // Verificar se o token CSRF está disponível
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) {
        console.log('Token CSRF encontrado:', metaToken.getAttribute('content'));
    } else {
        console.error('Token CSRF não encontrado!');
    }
    
    // Verificar se o seletor de bebê está disponível
    const babySelector = document.getElementById('baby-selector');
    if (babySelector) {
        console.log('Seletor de bebê encontrado:', babySelector.value);
    } else {
        console.error('Seletor de bebê não encontrado!');
    }
    
    // Verificar se o botão de amamentação está disponível
    const feedingButton = document.getElementById('feeding-button');
    if (feedingButton) {
        console.log('Botão de amamentação encontrado');
    } else {
        console.error('Botão de amamentação não encontrado!');
    }
}); 