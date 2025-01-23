<?php require '../resources/views/components/header.php' ?>

<body class="flex flex-col min-h-screen bg-gray-100">
    <div>
        <?php require '../resources/views/components/topnavigation.php' ?>
    </div>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">

        <div id="start-card" class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quiz title</h2>
                <p class="text-xl text-gray-700 mb-6"> description</p>

                <div class="flex justify-center space-x-12 mb-8">
                    <div class="text-center">

                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600" id="time-taken">0:00</p>
                        <p class="text-gray-600">Time Limit</p>
                    </div>
                </div>

                <button id="start-btn"
                    class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Start
                </button>
            </div>
        </div>


        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 hidden" id="questionContainer">
            <!-- Quiz Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">JavaScript Fundamentals Quiz</h1>
                    <p class="text-gray-600 mt-2">Test your knowledge of JavaScript basics</p>
                </div>
                <div class="text-right">
                    <div class="text-xl font-bold text-blue-600" id="timer">20:00</div>
                    <div class="text-sm text-gray-500">Time Remaining</div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-gray-600">Question <span id="current-question">1</span> of <span
                            id="total-questions">10</span></span>
                    <span class="text-sm text-gray-600">Progress: <span id="progress">10%</span></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 10%"></div>
                </div>
            </div>

            <!-- Question Container -->
            <div class="mb-8">
                <div class="mb-4">
                    <h2 class="text-lg font-semibold text-gray-800" id="question">What is the output of
                        console.log(typeof undefined)?</h2>
                </div>

                <!-- Options -->
                <div class="space-y-3" id="options">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="answer" class="h-4 w-4 text-blue-600" value="a">
                        <span class="ml-3">undefined</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="answer" class="h-4 w-4 text-blue-600" value="b">
                        <span class="ml-3">object</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="answer" class="h-4 w-4 text-blue-600" value="c">
                        <span class="ml-3">string</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="answer" class="h-4 w-4 text-blue-600" value="d">
                        <span class="ml-3">null</span>
                    </label>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between items-center">
                <button id="prev-btn"
                    class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 disabled:opacity-50">
                    Previous
                </button>
                <button id="next-btn" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Next
                </button>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 text-center">
                <button id="submit-quiz" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Submit Quiz
                </button>
            </div>
        </div>

        <!-- Results Card -->
        <div id="results-card" class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 hidden">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Quiz Complete!</h2>
                <h3 class="text-xl text-gray-700 mb-6">JavaScript Fundamentals Quiz</h3>

                <div class="flex justify-center space-x-12 mb-8">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600" id="final-score">0/10</p>
                        <p class="text-gray-600">Final Score</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600" id="time-taken">0:00</p>
                        <p class="text-gray-600">Time Taken</p>
                    </div>
                </div>

                <a href="dashboard.html"
                    class="inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white shadow-lg mt-8">
        <div class="max-w-6xl mx-auto px-4 py-4">
            <div class="text-center text-gray-500 text-sm">
                © 2024 Quiz Platform. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Quiz JavaScript -->
    <script>
    async function getQuizItems() {
            const {
                default: apiFetch
            } = await import('/js/utils/apiFetch.js');
            await apiFetch('/quizzes/<?php echo $unique_value ?>/getByUniqueValue', {
                    method: 'GET'
                })
                .then((data) => {
                    document.getElementById('title').innerText = data.quiz.title;
                    document.getElementById('description').innerText = data.quiz.description;
                    document.getElementById('time-taken').innerText = data.quiz.time_limit;
                })

                .catch((error) => {
                    document.getElementById('error').innerHTML = '';
                
                        Object.keys(error.data.errors).forEach(err => {
                        document.getElementById('error').innerHTML += `<p class="text-red-500 mt-1">${error.data.errors[err]}</p>`;
                    })

                });

        }

        getQuizItems();

            document.addEventListener('DOMContentLoaded', () => {
                const timerDisplay = document.getElementById('timer');
                const startBtn = document.getElementById('start-btn');
                const questionContainer = document.getElementById('questionContainer');
                const startCard = document.getElementById('start-card');
                const resultsCard = document.getElementById('results-card');
                const nextBtn = document.getElementById('next-btn');
                const prevBtn = document.getElementById('prev-btn');
                const submitQuizBtn = document.getElementById('submit-quiz');
                const options = document.getElementById('options');
                const questionElement = document.getElementById('question');
                let currentQuestionIndex = 0;

                // Savollar ro'yxati
                const questions = [{
                        id: 1,
                        question: 'What is the output of console.log(typeof undefined)?',
                        options: ['undefined', 'object', 'string', 'null'],
                        correct: 0
                    },
                    {
                        id: 2,
                        question: 'What is the output of console.log(typeof null)?',
                        options: ['undefined', 'object', 'string', 'null'],
                        correct: 1
                    },
                    {
                        id: 3,
                        question: 'What is the output of console.log(typeof {})?',
                        options: ['undefined', 'object', 'string', 'null'],
                        correct: 1
                    }
                ];

                // Timer funksiyasi
                function startTimer(duration, display) {
                    let timer = duration;
                    const interval = setInterval(() => {
                        const minutes = Math.floor(timer / 60);
                        const seconds = timer % 60;
                        display.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                        if (--timer < 0) {
                            clearInterval(interval);
                            alert('Time is up!');
                            showResults();
                        }
                    }, 1000);
                }

                // Savolni ko'rsatish funksiyasi
                function showQuestion(index) {
                    if (index < 0 || index >= questions.length) return;
                    const question = questions[index];
                    questionElement.textContent = question.question;
                    options.innerHTML = '';
                    question.options.forEach((option, i) => {
                        options.innerHTML += `
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="answer" class="h-4 w-4 text-blue-600" value="${i}">
                        <span class="ml-3">${option}</span>
                    </label>`;
                    });
                }

                // Natijalarni ko'rsatish
                function showResults() {
                    questionContainer.classList.add('hidden');
                    resultsCard.classList.remove('hidden');
                    document.getElementById('final-score').textContent =
                        `${currentQuestionIndex + 1}/${questions.length}`;
                }

                // Boshlash tugmasi
                startBtn.addEventListener('click', () => {
                    startCard.classList.add('hidden');
                    questionContainer.classList.remove('hidden');
                    startTimer(1200, timerDisplay); // 20 daqiqa
                    showQuestion(currentQuestionIndex);
                });

                // Keyingi tugma
                nextBtn.addEventListener('click', () => {
                    if (currentQuestionIndex < questions.length - 1) {
                        currentQuestionIndex++;
                        showQuestion(currentQuestionIndex);
                    }
                });

                // Oldingi tugma
                prevBtn.addEventListener('click', () => {
                    if (currentQuestionIndex > 0) {
                        currentQuestionIndex--;
                        showQuestion(currentQuestionIndex);
                    }
                });

                // Tugatish tugmasi
                submitQuizBtn.addEventListener('click', showResults);

            });
    </script>

</body>

</html>