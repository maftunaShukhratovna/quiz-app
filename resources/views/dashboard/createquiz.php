<?php require '../resources/views/components/header.php' ?>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <?php require '../resources/views/components/sidebar.php' ?>

        <div class="flex-1">
            <?php require '../resources/views/components/topnavigation.php' ?>
            <!-- Content -->
            <main class="p-6">
                <div class="min-h-screen bg-gray-100">
                    <div class="container">
                        <!-- Header -->
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">My Quizzes</h2>
                            <p class="mt-2 text-gray-600">Fill in the details below to create a new quiz</p>
                        </div>

                        <!-- Main Form -->
                        <form class="space-y-4" id="quizForm" onsubmit="createQuiz(event)">
                            <!-- Quiz Details Section -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <h3 class="text-xl font-semibold text-gray-800 mb-4">Quiz Details</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">Quiz Title</label>
                                        <input type="text" id="title" name="title" placeholder="Quiz Title" required
                                               class="w-full px-4 py-2 border rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea id="description" name="description" rows="3" placeholder="Description" required
                                                  class="w-full px-4 py-2 border rounded-lg mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>
                                    <div>
                                        <label for="time_limit" class="block text-sm font-medium text-gray-700">Time Limit (minutes)</label>
                                        <input type="number" id="time_limit" name="time_limit" placeholder="Time Limit" min="1" required
                                               class="px-4 py-2 border rounded-lg mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Questions Section -->
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="flex justify-between items-center mb-4">
                                    <h2 class="text-xl font-semibold text-gray-800">Questions</h2>
                                    <button type="button" id="addQuestionBtn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                        Add Question
                                    </button>
                                </div>

                                <!-- Question Template -->
                                <div id="questionsContainer" class="space-y-6">
                                    <div class="p-4 border border-gray-200 rounded-lg" data-question-id="1">
                                        <div>
                                            <h3>1</h3>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700">Question Text</label>
                                            <input name="questions[0][quiz]" type="text" required
                                                   class="w-full px-4 py-2 border rounded-lg mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>

                                        <div class="space-y-3" data-options-container>
                                            <div class="flex justify-between">
                                                <p class="text-sm font-medium text-gray-700">Answer Options</p>
                                                <button type="button" class="addOptionBtn px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                                    Add Option
                                                </button>
                                            </div>
                                            <!-- Option 1 -->
                                            <div class="flex items-center gap-4">
                                                <input type="radio" name="questions[0][correct]" value="0" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                <input type="text" name="questions[0][options][]" placeholder="Option 1" required
                                                       class="w-full px-4 py-2 border rounded-lg block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                <button type="button" class="removeOptionBtn px-2 py-1 text-red-600 hover:text-red-800">×</button>
                                            </div>
                                            <!-- Option 2 -->
                                        </div>

                                        <div class="mt-4 flex justify-end">
                                            <button type="button" class="removeQuestionBtn text-red-600 hover:text-red-800 font-medium">
                                                Remove Question
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                    Create Quiz
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
    async function createQuiz(event) {
        event.preventDefault();

        const button = event.submitter; 
        button.disabled = true; 

        const form = document.getElementById("quizForm");
        const formData = new FormData(form); 

        const timeLimit = formData.get('time_limit');
        if (!timeLimit || parseInt(timeLimit) <= 0) {
            alert('Please provide a valid time limit (in minutes).');
            button.disabled = false; 
            return;
        }

        const {
            default: apiFetch
        } = await import("<?php echo assets('/js/utils/apiFetch.js') ?>");

        try {
            const data = await apiFetch('/quizzes', {
                method: 'POST',
                body: formData,
                headers: {} 
            });

            alert("Quiz created successfully!");
            window.location.href = '/myquiz';
            
        } catch (error) {
            const errorElement = document.getElementById('error');
            if (errorElement) {
                errorElement.innerHTML = error.data?.message || error.message || "An error occurred";
            } else {
                alert(error.message || "An error occurred");
            }
        } finally {
            button.disabled = false; 
        }
    }
    </script>

    
    <?php require '../resources/views/components/footer.php' ?>