# Sistema de Alarmes de Amamentação

## Visão Geral

Este sistema implementa notificações automáticas para alarmes de amamentação que tocam no horário configurado com a mensagem "Hora de alimentar o bebê".

## Componentes Implementados

### 1. Comando de Verificação de Alarmes (`CheckAlarms`)
- **Arquivo**: `app/Console/Commands/CheckAlarms.php`
- **Função**: Verifica a cada minuto se há alarmes ativos que devem disparar
- **Execução**: Automática via scheduler do Laravel

### 2. Job de Notificação (`SendAlarmNotification`)
- **Arquivo**: `app/Jobs/SendAlarmNotification.php`
- **Função**: Processa e envia notificações de alarme
- **Execução**: Assíncrona via fila do Laravel

### 3. Notificação Personalizada (`FeedingAlarmNotification`)
- **Arquivo**: `app/Notifications/FeedingAlarmNotification.php`
- **Função**: Define o formato e conteúdo das notificações
- **Recursos**: Som de alarme, ícone personalizado, ações interativas

### 4. JavaScript para Notificações (`AlarmNotificationManager`)
- **Arquivo**: `resources/js/bootstrap.js`
- **Função**: Gerencia notificações no frontend
- **Recursos**: Som de alarme, modal de alerta, notificações do navegador

## Como Funciona

1. **Agendamento**: O scheduler executa `alarms:check` a cada minuto
2. **Verificação**: O comando busca alarmes ativos que devem disparar no horário atual
3. **Notificação**: Para cada alarme encontrado, um job é despachado
4. **Entrega**: A notificação é enviada via database e broadcast
5. **Frontend**: O JavaScript recebe a notificação e:
   - Toca o som de alarme
   - Mostra notificação do navegador
   - Exibe modal de alerta
   - Permite parar o som e ir para o dashboard

## Configuração

### 1. Scheduler (já configurado)
O scheduler está configurado em `app/Console/Kernel.php`:
```php
$schedule->command('alarms:check')->everyMinute();
```

### 2. Som de Alarme
- **Arquivo**: `public/sounds/alarm.mp3`
- **Substitua** o arquivo placeholder por um som real de alarme
- **Sites recomendados**:
  - https://freesound.org/
  - https://mixkit.co/free-sound-effects/
  - https://www.zapsplat.com/

### 3. Ícones
- **Arquivo**: `public/images/baby-icon.png`
- **Crie** ícones personalizados para as notificações

## Testando o Sistema

### 1. Teste Manual
```bash
php artisan alarm:test --user-id=1 --alarm-id=1
```

### 2. Teste do Scheduler
```bash
php artisan schedule:run
```

### 3. Teste de Notificação
```bash
php artisan tinker
```
```php
$user = App\Models\User::find(1);
$alarm = $user->babies->first()->alarms->first();
App\Jobs\SendAlarmNotification::dispatch($user, $alarm);
```

## Funcionalidades

### Notificações do Navegador
- Título: "Hora de alimentar o bebê!"
- Corpo: "Alarme configurado para: HH:MM"
- Ações: "Parar Alarme" e "Ver Dashboard"
- Som: Reproduz automaticamente

### Modal de Alarme
- Aparece automaticamente quando o alarme dispara
- Mostra nome do bebê e horário do alarme
- Botões para parar som e ir para dashboard
- Não pode ser fechado sem interação

### Som de Alarme
- Reproduz em loop até ser parado
- Volume configurado em 70%
- Para automaticamente ao fechar modal

## Troubleshooting

### 1. Notificações não aparecem
- Verifique se o usuário tem `push_subscription` configurado
- Confirme se as permissões de notificação estão ativadas
- Verifique os logs do Laravel

### 2. Som não toca
- Verifique se o arquivo `alarm.mp3` existe
- Confirme se o navegador permite reprodução de áudio
- Verifique o console do navegador para erros

### 3. Scheduler não executa
- Configure um cron job no servidor:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

## Logs

O sistema registra logs detalhados:
- Verificação de alarmes
- Envio de notificações
- Erros e exceções

Verifique os logs em `storage/logs/laravel.log`

## Próximos Passos

1. **Implementar notificações push reais** (Firebase, OneSignal, etc.)
2. **Adicionar diferentes sons de alarme**
3. **Implementar snooze/alarme repetitivo**
4. **Adicionar estatísticas de alarmes**
5. **Implementar notificações por email/SMS** 