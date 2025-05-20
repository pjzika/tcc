# Configuração de Notificações Push

Este documento explica como configurar o sistema de notificações push para os alarmes de amamentação.

## Requisitos

- Laravel 10+
- PHP 8.1+
- Navegador moderno que suporte a API de Push (Chrome, Firefox, Edge)
- HTTPS (necessário para notificações push)

## Instalação

1. Instale o pacote web-push:
```bash
composer require minishlink/web-push
```

2. Execute a migração para adicionar a coluna `push_subscription` à tabela de usuários:
```bash
php artisan migrate
```

3. Gere as chaves VAPID:
```bash
php artisan webpush:vapid
```
Ou adicione manualmente ao arquivo `.env`:
```
VAPID_SUBJECT=mailto:seu-email@exemplo.com
VAPID_PUBLIC_KEY=sua_chave_publica
VAPID_PRIVATE_KEY=sua_chave_privada
```

4. Configure o agendador para verificar os alarmes:
```bash
* * * * * cd /caminho/para/seu/projeto && php artisan schedule:run >> /dev/null 2>&1
```

## Como funciona

1. O usuário clica no botão "Ativar Notificações" no dashboard
2. O navegador solicita permissão para enviar notificações
3. O Service Worker é registrado e a subscription é salva no banco de dados
4. Quando um alarme é ativado, uma notificação é enviada imediatamente
5. A cada minuto, o sistema verifica se há alarmes próximos de disparar e envia notificações

## Testando

1. Acesse o dashboard
2. Clique em "Ativar Notificações" e aceite a permissão
3. Ative um alarme clicando no switch
4. Você deve receber uma notificação imediatamente
5. Para testar o agendador, execute:
```bash
php artisan alarms:check
```

## Solução de problemas

- Se as notificações não aparecerem, verifique se o navegador suporta a API de Push
- Verifique se o site está sendo acessado via HTTPS
- Verifique se as chaves VAPID estão configuradas corretamente
- Verifique os logs do Laravel para erros relacionados às notificações 