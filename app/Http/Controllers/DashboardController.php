<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\Feeding;
use App\Models\Alarm;
use App\Models\Tip;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\NotificationController;
use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;

    protected $notificationController;

    public function __construct(NotificationController $notificationController)
    {
        $this->notificationController = $notificationController;
    }

    public function index()
    {
        $selectedBabyId = request('baby_id');

        /** @var User $user */
        $user = Auth::user();
        $babies = $user->babies;

        if ($babies->isEmpty()) {
            return view('dashboard', [
                'user' => $user,
                'babies' => $babies,
                'baby' => null,
                'feedings' => collect(),
                'alarms' => collect()
            ]);
        }

        if (!$selectedBabyId) {
            $baby = $babies->first();
        } else {
            $baby = $babies->firstWhere('id', $selectedBabyId);
            if (!$baby) {
                return redirect()->route('dashboard')->with('error', 'Bebê não encontrado.');
            }
        }

        $feedings = $baby->feedings()
            ->whereDate('started_at', today())
            ->orderBy('started_at', 'desc')
            ->take(3)
            ->get(['id', 'baby_id', 'started_at', 'ended_at', 'duration', 'quantity']);

        $alarms = $baby->alarms()
            ->orderBy('time')
            ->get();

        return view('dashboard', [
            'user' => $user,
            'babies' => $babies,
            'baby' => $baby,
            'feedings' => $feedings,
            'alarms' => $alarms
        ]);
    }

    public function storeFeeding(Request $request)
    {
        try {
            Log::info('Iniciando registro de amamentação', ['request' => $request->all()]);

            if (!Auth::check()) {
                Log::warning('Tentativa de registro sem autenticação');
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não autenticado. Por favor, faça login novamente.'
                ], 401);
            }

            $baby = Baby::find($request->baby_id);
            Log::info('Bebê encontrado', ['baby' => $baby]);

            if (!$baby || $baby->user_id !== Auth::id()) {
                Log::warning('Bebê não encontrado ou não pertence ao usuário', [
                    'baby_id' => $request->baby_id,
                    'user_id' => Auth::id()
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Bebê não encontrado ou não pertence ao usuário.'
                ], 403);
            }

            $validated = $request->validate([
                'baby_id' => 'required|exists:babies,id',
                'started_at' => 'required|date',
                'ended_at' => 'nullable|date|after:started_at',
                'quantity' => 'nullable|integer|min:0'
            ]);

            Log::info('Dados validados', ['validated' => $validated]);

            $startedAt = Carbon::parse($validated['started_at']);
            $endedAt = Carbon::parse($validated['ended_at']);
            
            // Calcular a duração em minutos
            $duration = $endedAt->diffInSeconds($startedAt) / 60;

            Log::info('Cálculos realizados', [
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
                'duration' => $duration
            ]);

            $feeding = Feeding::create([
                'baby_id' => $validated['baby_id'],
                'started_at' => $startedAt,
                'ended_at' => $endedAt,
                'duration' => (int)$duration,
                'quantity' => $validated['quantity']
            ]);

            Log::info('Registro criado com sucesso', ['feeding' => $feeding]);

            // Buscar os 3 registros mais recentes
            $recentFeedings = $baby->feedings()
                ->whereDate('started_at', today())
                ->orderBy('started_at', 'desc')
                ->take(3)
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Amamentação registrada com sucesso!',
                'feeding' => $feeding,
                'recent_feedings' => $recentFeedings
            ]);

        } catch (ValidationException $e) {
            Log::warning('Erro de validação', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Dados inválidos. Por favor, verifique os campos.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao registrar amamentação:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao registrar a amamentação. Por favor, tente novamente.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function toggleAlarm(Request $request, $alarmId)
    {
        try {
            Log::info('=== INÍCIO DO TOGGLE ALARME ===');
            Log::info('Request recebida:', $request->all());
            Log::info('Alarm ID:', ['alarm_id' => $alarmId]);
            Log::info('User ID:', ['user_id' => Auth::id()]);

            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            Log::info('Dados validados:', $validated);

            $alarm = Alarm::whereHas('baby', function($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($alarmId);

            Log::info('Alarme encontrado:', [
                'id' => $alarm->id,
                'time' => $alarm->time,
                'is_active_anterior' => $alarm->is_active,
                'baby_id' => $alarm->baby_id
            ]);

            $alarm->is_active = $validated['is_active'];
            $resultado = $alarm->save();

            Log::info('Resultado do save():', ['resultado' => $resultado]);
            Log::info('Estado após save:', [
                'is_active' => $alarm->is_active,
                'updated_at' => $alarm->updated_at
            ]);

            Log::info('Estado do alarme alterado com sucesso', [
                'alarm_id' => $alarmId,
                'new_state' => $alarm->is_active
            ]);

            if ($alarm->is_active) {
                $user = Auth::user();
                $subscription = json_decode($user->push_subscription, true);
                
                if ($subscription) {
                    $this->notificationController->sendNotification(new Request([
                        'message' => "Alarme de amamentação ativado para {$alarm->time} - {$alarm->day_name}"
                    ]));
                }
            }

            Log::info('=== FIM DO TOGGLE ALARME ===');

            return response()->json([
                'success' => true,
                'message' => 'Estado do alarme alterado com sucesso',
                'alarm' => $alarm
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Alarme não encontrado ou não pertence ao usuário', [
                'alarm_id' => $alarmId,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Alarme não encontrado ou não pertence ao usuário'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Erro ao alterar estado do alarme', [
                'alarm_id' => $alarmId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar estado do alarme: ' . $e->getMessage()
            ], 500);
        }
    }

    public function storeBaby(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'birth_date' => [
                    'required',
                    'date',
                    'before_or_equal:today'
                ]
            ]);

            // Verificar limite de bebês
            /** @var User $user */
            $user = Auth::user();
            if ($user->babies->count() >= 5) {
                return redirect()->back()
                    ->with('error', 'Limite máximo de 5 bebês por usuário atingido.')
                    ->withInput();
            }

            DB::beginTransaction();
            
            $baby = $user->babies()->create($validated);

            // Criar alarmes padrão para o bebê
            $defaultAlarms = [
                ['time' => '06:00', 'day_of_week' => 'all', 'is_active' => false],
                ['time' => '09:00', 'day_of_week' => 'all', 'is_active' => false],
                ['time' => '12:00', 'day_of_week' => 'all', 'is_active' => false],
                ['time' => '15:00', 'day_of_week' => 'all', 'is_active' => false],
                ['time' => '18:00', 'day_of_week' => 'all', 'is_active' => false],
                ['time' => '21:00', 'day_of_week' => 'all', 'is_active' => false],
            ];

            foreach ($defaultAlarms as $alarm) {
                if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $alarm['time'])) {
                    throw new \Exception('Formato de horário inválido para o alarme padrão');
                }
                $baby->alarms()->create($alarm);
            }

            DB::commit();

            // Limpar o cache do dashboard para o usuário
            Cache::forget('dashboard_data_' . Auth::id());

            return redirect()->route('dashboard')
                ->with('success', 'Bebê cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar bebê:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar bebê: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getFeedingStatistics($babyId)
    {
        $statistics = [
            'daily_average' => Feeding::where('baby_id', $babyId)
                ->whereDate('started_at', '>=', now()->subDays(7))
                ->avg('duration'),
            'total_feedings' => Feeding::where('baby_id', $babyId)
                ->whereDate('started_at', '>=', now()->subDays(7))
                ->count(),
            // Adicionar mais estatísticas conforme necessário
        ];
        
        return response()->json($statistics);
    }

    public function getRecentFeedings(Request $request)
    {
        try {
            $babyId = $request->query('baby_id');
            
            if (!$babyId) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID do bebê não fornecido'
                ], 400);
            }

            $baby = Baby::where('user_id', Auth::id())
                ->findOrFail($babyId);

            $feedings = $baby->feedings()
                ->whereDate('started_at', today())
                ->orderBy('started_at', 'desc')
                ->take(3)
                ->get();

            return response()->json([
                'success' => true,
                'feedings' => $feedings
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao buscar registros recentes:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar registros recentes'
            ], 500);
        }
    }

    public function updateAlarm(Request $request, Alarm $alarm)
    {
        try {
            // Garante que o alarme pertence a um bebê do usuário autenticado
            $this->authorize('update', $alarm);

            $validated = $request->validate([
                'time' => 'required|date_format:H:i',
            ]);

            $alarm->update([
                'time' => $validated['time'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alarme atualizado com sucesso!',
                'alarm' => $alarm,
            ]);

        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json(['success' => false, 'message' => 'Ação não autorizada.'], 403);
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar alarme', [
                'alarm_id' => $alarm->id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['success' => false, 'message' => 'Erro ao atualizar o alarme.'], 500);
        }
    }

    public function getActiveAlarms(Request $request)
    {
        try {
            $user = Auth::user();
            
            $alarms = Alarm::whereHas('baby', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('is_active', true)
            ->with('baby:id,name')
            ->get(['id', 'time', 'day_of_week', 'is_active', 'baby_id'])
            ->map(function($alarm) {
                return [
                    'id' => $alarm->id,
                    'time' => $alarm->time,
                    'day_of_week' => $alarm->day_of_week,
                    'is_active' => $alarm->is_active,
                    'baby_name' => $alarm->baby->name
                ];
            });

            return response()->json([
                'success' => true,
                'alarms' => $alarms
            ]);

        } catch (\Exception $e) {
            Log::error('Erro ao buscar alarmes ativos', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao buscar alarmes'
            ], 500);
        }
    }
}

class TipsController extends Controller
{
    protected function getBabyAgeRange()
    {
        // Implementar lógica para determinar a faixa etária do bebê
        return '0-6';
    }

    public function getDailyTip()
    {
        $tip = Tip::where('age_range', $this->getBabyAgeRange())
            ->inRandomOrder()
            ->first();
            
        return response()->json($tip);
    }
}

class LgpdMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('lgpd_consent')) {
            return redirect()->route('lgpd.consent');
        }
        
        return $next($request);
    }
} 