function apiFetch(uri, options = {}) {
    const baseUrl = 'http://localhost:8000/api',
        token = localStorage.getItem('token');
    const defaultHeaders = {};
    if (token) {
        defaultHeaders.Authorization = `Bearer ${token}`;
    }
    return fetch(`${baseUrl}${uri}`, {
        ...options,
        headers: { ...defaultHeaders, ...options.headers },
    })
        .then(async response => {
            if (!response.ok) {
                const error = new Error("HTTP error");
                error.data = await response.json();
                throw error;
            }
            return response.json();
        })
        .catch(error => {
            throw error;
        });
}

export default apiFetch;