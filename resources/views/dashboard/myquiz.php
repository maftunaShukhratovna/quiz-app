<?php require '../resources/views/components/header.php' ?>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <?php require '../resources/views/components/sidebar.php' ?>

        <!-- Main Content -->
        <div class="flex-1">
            <?php require '../resources/views/components/topnavigation.php' ?>

            <!-- Content -->
            <main class="p-6">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">My Quizzes</h2>
                    <div class="flex space-x-4">
                        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Create New Quiz
                        </button>
                        <div class="flex border rounded-lg">
                            <button class="px-3 py-2 bg-white border-r">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 4h10v2H5V4zm0 5h10v2H5V9zm0 5h10v2H5v-2z"></path>
                                </svg>
                            </button>
                            <button class="px-3 py-2 bg-gray-100">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 5h2v2H5V5zm0 4h2v2H5V9zm0 4h2v2H5v-2zm4-8h6v2H9V5zm0 4h6v2H9V9zm0 4h6v2H9v-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                    <div class="flex flex-wrap gap-4">
                        <div class="flex-1">
                            <input type="text" placeholder="Search quizzes..." class="w-full px-4 py-2 border rounded-lg">
                        </div>
                        <select class="px-4 py-2 border rounded-lg">
                            <option>Sort by</option>
                            <option>Date Created</option>
                            <option>Completion Rate</option>
                            <option>Title</option>
                        </select>
                    </div>
                </div>

                <!-- Quiz Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="quizList">
                    <!-- Quiz Cards will be dynamically inserted here -->
                </div>
            </main>
        </div>
    </div>

    <script>
    async function quizzes() {
        const quizList = document.getElementById('quizList');

        try {
            const { default: apiFetch } = await import('/js/utils/apiFetch.js');
            const data = await apiFetch('/quizzes', { method: 'GET' });

            // Check if data.message exists and is an array
            if (data && Array.isArray(data.message)) {
                data.message.forEach((quiz) => {
                    // Create a new quiz card
                    const quizCard = document.createElement('div');
                    quizCard.className = 'bg-white rounded-lg shadow-sm p-6';

                    quizCard.innerHTML = `
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">${quiz.title}</h3>
                                <p class="text-gray-500 text-sm">Mathematics</p>
                            </div>
                            <div class="dropdown">
                                <button class="p-2 hover:bg-gray-100 rounded-full">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">${quiz.description}</p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">${quiz.time_limit} min</span>
                            <span class="text-sm text-gray-500">Created on: ${new Date(quiz.created_at).toLocaleDateString()}</span>
                        </div>
                        <div class="mb-4">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                            <span class="text-sm text-gray-500">Completion Rate: 75%</span>
                        </div>
                        <div class="flex justify-between">
                            <a href="/updatequiz/${quiz.id}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                            <button class="text-green-600 hover:text-green-800" onclick="copyContent('${quiz.unique_value}')">Share</button>
                            <button class="text-red-600 hover:text-red-800" onclick="deleteQuiz(${quiz.id})">Delete</button>
                        </div>
                    `;

                    // Append the quiz card to the quizList
                    quizList.appendChild(quizCard);
                });
            } else {
                quizList.innerHTML = `<p class="text-gray-600">No quizzes available.</p>`;
            }
        } catch (error) {
            console.error('Error:', error);
            alert('There was an issue loading the quizzes. Please check your internet connection.');
        }
    }

    quizzes();

    async function deleteQuiz(id){
        if(confirm('Are u sure')){
            const {default: apiFetch} = await import('/js/utils/apiFetch.js');
            const data = await apiFetch(`/quizzes/${id}`, {
                method: 'DELETE'
            })
                .then(data=>{
                    window.location.reload();
                })
                .catch(error=>{
                    alert('check your internet.');
                });
        }
    }

    const copyContent = async (uniqueValue) => {
        try {
            uniqueValue = '<?php echo $_ENV['APP_URL'] ?>' + '/take-quiz/' + uniqueValue;
            await navigator.clipboard.writeText(uniqueValue)
            alert('Content copied to clipboard')
        } catch (err) {
            console.error("Failed to copy: ", err);
        }
    }
</script>


    <?php require '../resources/views/components/footer.php'; ?>
</body>
