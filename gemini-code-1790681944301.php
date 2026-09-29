<?php
require_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Avaliações | Prof. Halexandre Lord</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: { 800: '#0f172a', 900: '#0b1120', 950: '#050811' }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; color: #1e293b; }
        .serif-title { font-family: 'Playfair Display', serif; }
        .glass-card { background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px); border: 1px solid rgba(226, 232, 240, 0.9); }
        .gradient-header { background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #1e1b4b 100%); }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between bg-slate-50 antialiased selection:bg-amber-100 selection:text-amber-900">

    <header class="gradient-header text-white shadow-xl border-b border-amber-500/35 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-tr from-amber-400 to-amber-600 p-0.5 shadow-lg">
                            <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center overflow-hidden">
                                <span class="text-2xl font-serif font-bold text-amber-400">HL</span>
                            </div>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-slate-900 rounded-full" title="Conectado ao Cloud Deploy"></span>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="bg-amber-500/20 text-amber-300 text-[10px] sm:text-xs px-2.5 py-0.5 rounded-full font-semibold border border-amber-500/30">
                                Docente Executivo & Acadêmico
                            </span>
                        </div>
                        <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white mt-0.5">Prof. Halexandre Lord</h1>
                        <p class="text-xs text-slate-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-graduation-cap text-amber-400"></i> Portal de Avaliações Acadêmicas
                        </p>
                    </div>
                </div>

                <div class="flex items-center justify-between md:justify-end gap-2 border-t border-slate-700/60 pt-3 md:pt-0 md:border-0">
                    <div class="bg-slate-900/90 p-1.5 rounded-xl border border-slate-700 flex items-center gap-1">
                        <button id="nav-btn-student" onclick="switchRole('student')" class="px-3 py-1.5 rounded-lg text-xs font-semibold transition-all flex items-center gap-1.5 bg-amber-500 text-slate-950 shadow">
                            <i class="fa-solid fa-user-graduate"></i> <span>Portal Aluno</span>
                        </button>
                        <button id="nav-btn-teacher" onclick="switchRole('teacher')" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-300 hover:text-white hover:bg-slate-800 transition-all flex items-center gap-1.5">
                            <i class="fa-solid fa-user-shield"></i> <span>Área Professor</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">
        <!-- VISÃO 1: ALUNO - SELEÇÃO DE PROVA -->
        <div id="view-student-dashboard" class="space-y-8 transition-all duration-300">
            <div class="glass-card rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200">
                <div class="max-w-3xl">
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 serif-title">Realização de Prova Online</h2>
                    <p class="mt-2 text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Preencha seus dados institucionais e selecione uma das disciplinas ativas do Prof. Halexandre Lord.
                    </p>
                </div>
                <div class="mt-6 pt-6 border-t border-slate-200/80 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-slate-700 mb-1">Nome Completo do Aluno *</label>
                        <input type="text" id="student-name" placeholder="Ex: Maria Eduarda Santos" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-slate-700 mb-1">R.A. / Matrícula *</label>
                        <input type="text" id="student-ra" placeholder="Ex: 20269874" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold uppercase tracking-wider text-slate-700 mb-1">Turma / Semestre</label>
                        <input type="text" id="student-turma" placeholder="Ex: 4º Semestre" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs sm:text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900 tracking-tight">Provas Disponíveis</h3>
                    <span id="exam-cards-count" class="text-xs font-semibold text-amber-900 bg-amber-100 px-3 py-1 rounded-full border border-amber-200">Carregando...</span>
                </div>
                <div id="student-exams-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6"></div>
            </div>
        </div>

        <!-- VISÃO 2: ALUNO - EXECUÇÃO DA PROVA -->
        <div id="view-student-exam" class="hidden space-y-6 transition-all duration-300">
            <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-md border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
                <div>
                    <h2 id="exam-title" class="text-xl font-bold text-slate-900 mt-1">Título da Prova</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Aluno: <span id="exam-student-display" class="font-semibold text-slate-800">---</span></p>
                </div>
                <div class="text-right">
                    <span class="text-[10px] text-slate-400 font-semibold uppercase block">Tempo Restante</span>
                    <span id="timer" class="text-2xl font-mono font-bold text-slate-900">00:00</span>
                </div>
            </div>
            <div id="questions-container" class="space-y-6"></div>
            <div class="flex justify-end pt-4">
                <button onclick="submitExam()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-xl shadow-lg transition-all text-xs sm:text-sm">Enviar Prova</button>
            </div>
        </div>

        <!-- VISÃO 3: RESULTADO -->
        <div id="view-student-result" class="hidden space-y-6 max-w-4xl mx-auto text-center">
            <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-xl border border-slate-200">
                <h2 class="text-2xl font-bold text-slate-900 serif-title">Prova Entregue com Sucesso!</h2>
                <div class="my-6 bg-slate-50 border border-slate-200 rounded-2xl p-5 max-w-md mx-auto">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Nota Registrada</span>
                    <div class="text-4xl sm:text-5xl font-extrabold text-slate-900 my-2" id="result-score">0.0</div>
                </div>
                <button onclick="switchRole('student')" class="bg-slate-900 text-white text-xs font-semibold px-6 py-3 rounded-xl">Voltar ao Início</button>
            </div>
        </div>

        <!-- VISÃO 4: PROFESSOR AUTH -->
        <div id="view-teacher-auth" class="hidden max-w-md mx-auto my-12">
            <div class="bg-white rounded-2xl p-8 shadow-xl border border-slate-200 text-center">
                <h2 class="text-xl font-bold text-slate-900 mb-2">Acesso Restrito do Professor</h2>
                <p class="text-xs text-slate-500 mb-6">PIN Padrão: <span class="font-mono font-bold">1234</span></p>
                <form onsubmit="handleTeacherLogin(event)" class="space-y-4">
                    <input type="password" id="teacher-pin" maxlength="10" placeholder="PIN" required class="w-full px-4 py-3 bg-slate-50 border border-slate-300 text-center font-mono text-xl rounded-xl">
                    <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-3 rounded-xl text-xs sm:text-sm">Entrar no Painel</button>
                </form>
            </div>
        </div>

        <!-- VISÃO 5: PAINEL PROFESSOR -->
        <div id="view-teacher-panel" class="hidden space-y-8">
            <div class="bg-slate-900 text-white rounded-2xl p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Painel Docente</h2>
                    <p class="text-xs text-slate-400">Gerenciamento e submissões dos alunos.</p>
                </div>
                <button onclick="openExamModal()" class="bg-amber-500 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs">Criar Nova Prova</button>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                <h3 class="text-md font-bold text-slate-900 mb-4"><i class="fa-solid fa-list-check text-amber-500 mr-2"></i> Submissões Recebidas</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-600">
                                <th class="p-3">Aluno</th>
                                <th class="p-3">R.A.</th>
                                <th class="p-3">Turma</th>
                                <th class="p-3">Prova</th>
                                <th class="p-3">Nota</th>
                                <th class="p-3">Data</th>
                            </tr>
                        </thead>
                        <tbody id="teacher-submissions-list">
                            <tr><td colspan="6" class="p-4 text-center text-slate-400">Carregando submissões...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="teacher-exams-list"></div>
        </div>
    </main>

    <!-- MODAL CRIAR PROVA -->
    <div id="modal-exam" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Criar Nova Prova</h3>
            <form onsubmit="saveExamForm(event)" class="space-y-4">
                <input type="hidden" id="form-exam-id">
                <div>
                    <label class="block text-xs font-semibold mb-1">Título da Prova</label>
                    <input type="text" id="form-exam-title" placeholder="Ex: Sociologia da Educação" required class="w-full px-3 py-2 border rounded-xl text-xs">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Duração (Minutos)</label>
                        <input type="number" id="form-exam-duration" value="15" required class="w-full px-3 py-2 border rounded-xl text-xs">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Identificador ID (ex: sociologia)</label>
                        <input type="text" id="form-exam-key" placeholder="sociologia" required class="w-full px-3 py-2 border rounded-xl text-xs">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Descrição</label>
                    <input type="text" id="form-exam-desc" placeholder="Resumo do conteúdo..." required class="w-full px-3 py-2 border rounded-xl text-xs">
                </div>
                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" onclick="closeExamModal()" class="px-4 py-2 text-xs text-slate-600">Cancelar</button>
                    <button type="submit" class="bg-amber-500 text-slate-950 font-bold px-6 py-2 rounded-xl text-xs">Salvar Prova</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let examsData = {};
        let submissionsData = [];
        let currentExamId = null;
        let userAnswers = {};
        let teacherAuthenticated = false;
        let timerInterval = null;
        let timeRemainingSeconds = 0;
        let studentProfile = {};

        async function loadAppData() {
            try {
                const res = await fetch('api.php?action=get_data');
                const data = await res.json();
                if (data.success) {
                    examsData = data.exams;
                    submissionsData = data.submissions;
                    renderStudentExamsGrid();
                    renderTeacherExamsList();
                    renderTeacherSubmissions();
                }
            } catch (err) {
                console.error("Erro ao carregar dados do servidor:", err);
            }
        }

        function switchRole(role) {
            document.getElementById('view-student-dashboard').classList.add('hidden');
            document.getElementById('view-student-exam').classList.add('hidden');
            document.getElementById('view-student-result').classList.add('hidden');
            document.getElementById('view-teacher-auth').classList.add('hidden');
            document.getElementById('view-teacher-panel').classList.add('hidden');

            if (role === 'student') {
                document.getElementById('view-student-dashboard').classList.remove('hidden');
                loadAppData();
            } else {
                if (teacherAuthenticated) {
                    document.getElementById('view-teacher-panel').classList.remove('hidden');
                    loadAppData();
                } else {
                    document.getElementById('view-teacher-auth').classList.remove('hidden');
                }
            }
        }

        function handleTeacherLogin(e) {
            e.preventDefault();
            if (document.getElementById('teacher-pin').value === '1234') {
                teacherAuthenticated = true;
                switchRole('teacher');
            } else {
                alert('PIN incorreto!');
            }
        }

        function renderStudentExamsGrid() {
            const grid = document.getElementById('student-exams-grid');
            grid.innerHTML = '';
            const keys = Object.keys(examsData);
            document.getElementById('exam-cards-count').innerText = `${keys.length} Provas Ativas`;

            keys.forEach(key => {
                const exam = examsData[key];
                const card = document.createElement('div');
                card.className = "bg-white rounded-2xl p-6 border shadow-sm flex flex-col justify-between";
                card.innerHTML = `
                    <div>
                        <h4 class="text-lg font-bold text-slate-900">${exam.title}</h4>
                        <p class="text-xs text-slate-500 mt-2">${exam.description}</p>
                        <div class="mt-4 text-[11px] text-amber-800 bg-amber-50 inline-block px-2 py-1 rounded font-medium">
                            <i class="fa-regular fa-clock mr-1"></i> Duração: ${exam.durationMinutes} min
                        </div>
                    </div>
                    <button onclick="startStudentExam('${exam.id}')" class="mt-6 w-full bg-slate-900 hover:bg-amber-600 text-white font-semibold py-3 rounded-xl text-xs transition-colors">Iniciar Avaliação</button>
                `;
                grid.appendChild(card);
            });
        }

        function startStudentExam(examId) {
            const name = document.getElementById('student-name').value.trim();
            const ra = document.getElementById('student-ra').value.trim();
            if (!name || !ra) { alert('Por favor, preencha o seu Nome Completo e R.A. antes de iniciar.'); return; }

            studentProfile = { name, ra, turma: document.getElementById('student-turma').value };
            currentExamId = examId;
            userAnswers = {};
            const exam = examsData[examId];

            document.getElementById('exam-title').innerText = exam.title;
            document.getElementById('exam-student-display').innerText = name;
            
            const container = document.getElementById('questions-container');
            container.innerHTML = '';
            (exam.questions || []).forEach((q, idx) => {
                let html = `<div class="bg-white p-6 rounded-2xl border shadow-sm"><p class="font-bold text-xs sm:text-sm text-slate-900 mb-3">Questão ${idx+1}: ${q.text}</p>`;
                if (q.type === 'multiple') {
                    q.options.forEach((opt, oIdx) => {
                        html += `<label class="block text-xs sm:text-sm my-2 p-2 rounded hover:bg-slate-50 cursor-pointer"><input type="radio" name="q_${q.id}" value="${oIdx}" onchange="userAnswers[${q.id}] = ${oIdx}" class="mr-2"> ${opt}</label>`;
                    });
                } else {
                    html += `<textarea oninput="userAnswers[${q.id}] = this.value" class="w-full border p-3 text-xs rounded-xl h-24 focus:ring-2 focus:ring-amber-500 outline-none" placeholder="Digite sua resposta discursiva aqui..."></textarea>`;
                }
                html += `</div>`;
                container.innerHTML += html;
            });

            timeRemainingSeconds = exam.durationMinutes * 60;
            startTimer();

            document.getElementById('view-student-dashboard').classList.add('hidden');
            document.getElementById('view-student-exam').classList.remove('hidden');
        }

        function startTimer() {
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                timeRemainingSeconds--;
                let m = Math.floor(timeRemainingSeconds / 60), s = timeRemainingSeconds % 60;
                document.getElementById('timer').innerText = `${String(m).padStart(2,'0')}:${String(s).padStart(2,'0')}`;
                if (timeRemainingSeconds <= 0) { clearInterval(timerInterval); submitExam(); }
            }, 1000);
        }

        async function submitExam() {
            clearInterval(timerInterval);
            const exam = examsData[currentExamId];
            let correct = 0, total = 0;
            (exam.questions || []).forEach(q => {
                if (q.type === 'multiple') {
                    total++;
                    if (userAnswers[q.id] === q.correct) correct++;
                }
            });
            const score = total > 0 ? ((correct / total) * 10).toFixed(1) : 10.0;

            await fetch('api.php?action=submit_exam', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    studentName: studentProfile.name,
                    studentRa: studentProfile.ra,
                    turma: studentProfile.turma || 'Não informada',
                    examId: exam.id,
                    examTitle: exam.title,
                    score: parseFloat(score),
                    answers: userAnswers,
                    timestamp: new Date().toLocaleString('pt-BR')
                })
            });

            document.getElementById('result-score').innerText = score;
            document.getElementById('view-student-exam').classList.add('hidden');
            document.getElementById('view-student-result').classList.remove('hidden');
        }

        function renderTeacherExamsList() {
            const container = document.getElementById('teacher-exams-list');
            if (!container) return;
            container.innerHTML = '';
            Object.keys(examsData).forEach(key => {
                const exam = examsData[key];
                container.innerHTML += `
                    <div class="bg-white p-6 rounded-2xl border flex justify-between items-center shadow-sm">
                        <div>
                            <h4 class="font-bold text-sm text-slate-900">${exam.title}</h4>
                            <p class="text-xs text-slate-500 mt-1">${exam.description}</p>
                        </div>
                        <button onclick="deleteExam('${exam.id}')" class="text-red-600 hover:text-red-800 text-xs font-bold px-3 py-1.5 bg-red-50 rounded-lg">Excluir</button>
                    </div>`;
            });
        }

        function renderTeacherSubmissions() {
            const tbody = document.getElementById('teacher-submissions-list');
            if (!tbody) return;
            if (submissionsData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="6" class="p-4 text-center text-slate-400">Nenhuma submissão registrada até o momento.</td></tr>`;
                return;
            }
            tbody.innerHTML = '';
            submissionsData.forEach(sub => {
                tbody.innerHTML += `
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-3 font-semibold text-slate-800">${sub.studentName}</td>
                        <td class="p-3 font-mono">${sub.studentRa}</td>
                        <td class="p-3">${sub.turma}</td>
                        <td class="p-3">${sub.examTitle}</td>
                        <td class="p-3 font-bold text-amber-600">${sub.score}</td>
                        <td class="p-3 text-slate-500">${sub.timestamp}</td>
                    </tr>`;
            });
        }

        async function deleteExam(id) {
            if (confirm('Tem certeza que deseja excluir esta prova?')) {
                await fetch('api.php?action=delete_exam', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify({id}) });
                loadAppData();
            }
        }

        function openExamModal() { document.getElementById('modal-exam').classList.remove('hidden'); }
        function closeExamModal() { document.getElementById('modal-exam').classList.add('hidden'); }

        async function saveExamForm(e) {
            e.preventDefault();
            const examObj = {
                id: document.getElementById('form-exam-key').value.trim().toLowerCase(),
                title: document.getElementById('form-exam-title').value,
                durationMinutes: parseInt(document.getElementById('form-exam-duration').value),
                description: document.getElementById('form-exam-desc').value,
                questions: [
                    { id: 1, type: 'multiple', text: 'Questão Padrão de Exemplo para a Avaliação', options: ['Alternativa A', 'Alternativa B', 'Alternativa C', 'Alternativa D'], correct: 0 }
                ]
            };
            await fetch('api.php?action=save_exam', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(examObj) });
            closeExamModal();
            loadAppData();
        }

        loadAppData();
    </script>
</body>
</html>