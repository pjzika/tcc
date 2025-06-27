import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next, we will create a fresh Axios instance with a base URL and
 * retrieve the CSRF token from the meta tag. This will allow us to
 * make AJAX requests to our Laravel back-end.
 */

const csrfToken = document.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Teste simples para verificar se o JavaScript está funcionando
console.log('Bootstrap.js carregado com sucesso!');

// Alarm Management Code
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM carregado - Alarm Manager iniciado');
    
    const alarmToggles = document.querySelectorAll('.alarm-toggle');
    console.log('Encontrados', alarmToggles.length, 'alarmes para configurar');

    if (alarmToggles.length === 0) {
        console.log('Nenhum alarme encontrado na página');
        return;
    }

    alarmToggles.forEach((toggle, index) => {
        console.log(`Configurando alarme ${index + 1}:`, toggle.dataset.alarmId);
        
        toggle.addEventListener('change', function () {
            const alarmId = this.dataset.alarmId;
            const isActive = this.checked;
            
            console.log('Tentando alterar alarme:', alarmId, 'para:', isActive);

            window.axios.post(`/dashboard/alarm/${alarmId}/toggle`, {
                is_active: isActive
            })
            .then(response => {
                console.log('Resposta do servidor:', response.data);
                if (!response.data.success) {
                    showCustomModal('Erro ao alterar o alarme: ' + response.data.message, 'error');
                    this.checked = !isActive;
                } else {
                    console.log('Estado do alarme alterado com sucesso.');
                }
            })
            .catch(error => {
                console.error('Erro completo:', error);
                let errorMessage = 'Ocorreu um erro de comunicação ao alterar o alarme.';
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
                console.error('Erro ao alterar o alarme:', error.response || error);
                showCustomModal(errorMessage, 'error');
                this.checked = !isActive;
            });
        });
    });

    const editAlarmModal = document.getElementById('editAlarmModal');
    if (editAlarmModal) {
        console.log('Modal de edição encontrado');
        const editAlarmForm = document.getElementById('editAlarmForm');
        const editAlarmIdInput = document.getElementById('editAlarmId');
        const editAlarmTimeInput = document.getElementById('editAlarmTime');

        document.querySelectorAll('.edit-alarm-btn').forEach(button => {
            button.addEventListener('click', function () {
                console.log('Botão de editar clicado para alarme:', this.dataset.alarmId);
                editAlarmIdInput.value = this.dataset.alarmId;
                editAlarmTimeInput.value = this.dataset.alarmTime;
            });
        });

        editAlarmForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const alarmId = editAlarmIdInput.value;
            const newTime = editAlarmTimeInput.value;
            
            console.log('Tentando atualizar alarme:', alarmId, 'para horário:', newTime);

            window.axios.post(`/dashboard/alarm/${alarmId}/update`, {
                time: newTime
            })
            .then(response => {
                console.log('Resposta da edição:', response.data);
                if (response.data.success) {
                    const alarmElement = document.querySelector(`.alarm-toggle[data-alarm-id='${alarmId}']`);
                    const alarmItem = alarmElement.closest('.alarm-item');
                    const timeSpan = alarmItem.querySelector('.alarm-time');
                    const editButton = alarmItem.querySelector('.edit-alarm-btn');

                    timeSpan.textContent = newTime.substring(0, 5);
                    editButton.dataset.alarmTime = newTime;

                    const closeButton = editAlarmModal.querySelector('.btn-close');
                    if(closeButton) {
                        closeButton.click();
                    }
                } else {
                    showCustomModal('O servidor respondeu, mas indicou um erro: ' + response.data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro completo na edição:', error);
                let errorMessage = 'Ocorreu um erro de comunicação ao salvar o alarme.';
                if (error.response && error.response.data && error.response.data.message) {
                    errorMessage = error.response.data.message;
                }
                console.error('Erro ao atualizar alarme:', error.response || error);
                showCustomModal(errorMessage, 'error');
            });
        });
    } else {
        console.log('Modal de edição NÃO encontrado');
    }
});

// Sistema de notificações de alarme
class AlarmNotificationManager {
    constructor() {
        this.audio = null;
        this.alarms = [];
        this.checkInterval = null;
        this.initAudio();
        this.loadAlarms();
        this.startChecking();
    }

    initAudio() {
        // Criar elemento de áudio para tocar o som do alarme
        this.audio = new Audio('/sounds/alarm.mp3');
        this.audio.loop = true; // Repetir o som até o usuário parar
        this.audio.volume = 0.7; // Volume em 70%
    }

    async loadAlarms() {
        try {
            // Buscar alarmes ativos do usuário
            const response = await axios.get('/api/alarms/active');
            this.alarms = response.data.alarms || [];
            console.log('Alarmes carregados:', this.alarms.length);
        } catch (error) {
            console.error('Erro ao carregar alarmes:', error);
        }
    }

    startChecking() {
        // Verificar a cada 30 segundos
        this.checkInterval = setInterval(() => {
            this.checkAlarms();
        }, 30000); // 30 segundos

        // Verificar imediatamente
        this.checkAlarms();
    }

    stopChecking() {
        if (this.checkInterval) {
            clearInterval(this.checkInterval);
            this.checkInterval = null;
        }
    }

    checkAlarms() {
        const now = new Date();
        const currentTime = now.toTimeString().substring(0, 5); // HH:MM
        const currentDay = now.toLocaleDateString('en-US', { weekday: 'long' }).toLowerCase();
        
        console.log('Verificando alarmes:', currentTime, currentDay);

        this.alarms.forEach(alarm => {
            if (alarm.is_active && alarm.time === currentTime) {
                // Verificar se é o dia correto
                if (alarm.day_of_week === 'all' || alarm.day_of_week === currentDay) {
                    console.log('ALARME DISPARADO!', alarm);
                    this.triggerAlarm(alarm);
                }
            }
        });
    }

    triggerAlarm(alarm) {
        console.log('Disparando alarme:', alarm);
        
        // Tocar som do alarme
        this.playAlarmSound();
        
        // Mostrar notificação do navegador
        this.showBrowserNotification(alarm);
        
        // Mostrar modal de alarme
        this.showAlarmModal(alarm);
    }

    playAlarmSound() {
        try {
            this.audio.play().catch((error) => {
                console.error('Erro ao tocar som do alarme:', error);
            });
        } catch (error) {
            console.error('Erro ao inicializar som do alarme:', error);
        }
    }

    stopAlarmSound() {
        if (this.audio) {
            this.audio.pause();
            this.audio.currentTime = 0;
        }
    }

    showBrowserNotification(alarm) {
        if ('Notification' in window && Notification.permission === 'granted') {
            const notification = new Notification('Hora de alimentar o bebê!', {
                body: `Alarme configurado para: ${alarm.time}`,
                icon: '/images/baby-icon.png',
                badge: '/images/baby-icon.png',
                tag: 'feeding_alarm',
                requireInteraction: true,
                actions: [
                    {
                        action: 'stop',
                        title: 'Parar Alarme',
                        icon: '/images/stop-icon.png'
                    },
                    {
                        action: 'view',
                        title: 'Ver Dashboard',
                        icon: '/images/dashboard-icon.png'
                    }
                ]
            });

            notification.onclick = () => {
                window.focus();
                window.location.href = '/dashboard';
                this.stopAlarmSound();
            };

            notification.onaction = (event) => {
                if (event.action === 'stop') {
                    this.stopAlarmSound();
                } else if (event.action === 'view') {
                    window.focus();
                    window.location.href = '/dashboard';
                    this.stopAlarmSound();
                }
            };
        }
    }

    showAlarmModal(alarm) {
        // Criar modal de alarme se não existir
        let alarmModal = document.getElementById('alarmModal');
        if (!alarmModal) {
            alarmModal = document.createElement('div');
            alarmModal.id = 'alarmModal';
            alarmModal.className = 'modal fade';
            alarmModal.setAttribute('data-bs-backdrop', 'static');
            alarmModal.setAttribute('data-bs-keyboard', 'false');
            alarmModal.innerHTML = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">
                                <i class="fas fa-bell"></i> Hora de Alimentar o Bebê!
                            </h5>
                        </div>
                        <div class="modal-body text-center">
                            <h4 class="text-warning mb-3">
                                <i class="fas fa-baby"></i> ${alarm.baby_name || 'Bebê'}
                            </h4>
                            <p class="lead">Alarme configurado para: <strong>${alarm.time}</strong></p>
                            <p>É hora de alimentar seu bebê!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="alarmNotificationManager.stopAlarmSound()">
                                <i class="fas fa-volume-mute"></i> Parar Som
                            </button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='/dashboard'">
                                <i class="fas fa-tachometer-alt"></i> Ir para Dashboard
                            </button>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(alarmModal);
        }

        // Mostrar o modal
        const modal = new bootstrap.Modal(alarmModal);
        modal.show();

        // Parar o som quando o modal for fechado
        alarmModal.addEventListener('hidden.bs.modal', () => {
            this.stopAlarmSound();
        });
    }
}

// Inicializar o gerenciador de notificações de alarme
let alarmNotificationManager;
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Inicializar gerenciador de notificações de alarme
    alarmNotificationManager = new AlarmNotificationManager();
    window.alarmNotificationManager = alarmNotificationManager;
    
    // Botão de teste de alarme
    const testAlarmBtn = document.getElementById('test-alarm-btn');
    if (testAlarmBtn) {
        testAlarmBtn.addEventListener('click', function() {
            const fakeAlarm = {
                is_active: true,
                time: 'TESTE',
                day_of_week: 'all',
                baby_name: 'Bebê de Teste'
            };
            alarmNotificationManager.triggerAlarm(fakeAlarm);
        });
    }
    // ... existing code ...
});
