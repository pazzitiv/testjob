if(AppStorage.auth) {
/*    Api.interceptors.request = {
        headers: {
            Authorization: `${AppStorage.auth.token_type} ${AppStorage.auth.access_token ?? ''}`,
        },
    };*/
    axios.interceptors.request.use(function (config) {
        config.headers.Authorization = `${AppStorage.auth.token_type} ${AppStorage.auth.access_token ?? ''}`;

        return config;
    });
}

window.__api = {
    get: axios.get,
    post: axios.post,
    patch: axios.patch,
    delete: axios.delete,
};
