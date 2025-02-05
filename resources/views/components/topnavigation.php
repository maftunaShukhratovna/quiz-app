    <header class="bg-white shadow-sm">
        <div class="h-16 flex items-center justify-between px-4">
            <button class="md:hidden text-gray-600" onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full">
                    <span class="text-gray-700 font-medium" id="userName"></span>
                </div>
            </div>
        </div>
    </header>

    <script type="module">
        async function fetchUserInfo() {
            try {
                const { default: apiFetch } = await import("<?php echo assets('/js/utils/apiFetch.js') ?>");
                
                const response = await apiFetch('/users/getInfo', { method: 'GET' });
                
                if (response && response.data && response.data.full_name) {
                    document.getElementById('userName').innerText = response.data.full_name;
                } else {
                    throw new Error('Invalid user data received');
                }
            } catch (error) {
                console.error('Error fetching user info:', error);
                window.location.href = "/login";
            }
        }

        fetchUserInfo();
    </script>

