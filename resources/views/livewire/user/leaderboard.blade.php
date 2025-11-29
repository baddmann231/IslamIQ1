<!-- resources/views/livewire/user/leaderboard.blade.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Leaderboard</h4>
                </div>
                <div class="card-body">
                    <!-- View Switcher -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="btn-group w-100">
                                <button class="btn {{ $view == 'global' ? 'btn-success' : 'btn-outline-success' }}"
                                        wire:click="switchView('global')">
                                    <i class="fas fa-globe"></i> Global Leaderboard
                                </button>
                                <button class="btn {{ $view == 'friends' ? 'btn-success' : 'btn-outline-success' }}"
                                        wire:click="switchView('friends')">
                                    <i class="fas fa-users"></i> Leaderboard Teman
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($view == 'global')
                    <!-- Global Leaderboard -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th>Points</th>
                                    <th>Kuis Selesai</th>
                                    <th>Jawaban Benar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($globalLeaderboard as $user)
                                <tr class="{{ $user->id == auth()->id() ? 'table-success' : '' }}">
                                    <td>
                                        @if($user->rank == 1)
                                        <span class="badge bg-warning">🥇</span>
                                        @elseif($user->rank == 2)
                                        <span class="badge bg-secondary">🥈</span>
                                        @elseif($user->rank == 3)
                                        <span class="badge bg-danger">🥉</span>
                                        @else
                                        #{{ $user->rank }}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id == auth()->id())
                                        <span class="badge bg-info">Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->level }}</td>
                                    <td>{{ number_format($user->points) }}</td>
                                    <td>{{ $user->quizzes_completed }}</td>
                                    <td>{{ number_format($user->correct_answers) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <!-- Friends Leaderboard -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Peringkat</th>
                                    <th>Nama</th>
                                    <th>Level</th>
                                    <th>Points</th>
                                    <th>Kuis Selesai</th>
                                    <th>Jawaban Benar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($friendsLeaderboard as $user)
                                <tr class="{{ $user->id == auth()->id() ? 'table-success' : '' }}">
                                    <td>
                                        @if($user->rank == 1)
                                        <span class="badge bg-warning">🥇</span>
                                        @elseif($user->rank == 2)
                                        <span class="badge bg-secondary">🥈</span>
                                        @elseif($user->rank == 3)
                                        <span class="badge bg-danger">🥉</span>
                                        @else
                                        #{{ $user->rank }}
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id == auth()->id())
                                        <span class="badge bg-info">Anda</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->level }}</td>
                                    <td>{{ number_format($user->points) }}</td>
                                    <td>{{ $user->quizzes_completed }}</td>
                                    <td>{{ number_format($user->correct_answers) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>