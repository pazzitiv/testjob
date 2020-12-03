/*$('form').on('submit', (e) => {
    //e.preventDefault();
    let form = e.target;
    let data = {};

    $(form).serializeArray().map((item) => data[item.name] = item.value);

    if(typeof form.dataset.action !== "undefined") {
        __api[form.method](form.action, {
            headers: {
                'Content-Type': 'application/x-www-form-urlencodeda'
            },
            params: data
        })
            .then(
                (response) => {
                    let data = response.data;
                    window[form.dataset.action](data);
                }
            )
            .catch((err) => {
                if(err.response) err.response;//console.error(err.response.status, err.message);
            });
    }
    //return false;
})*/

function login(data) {
    AppStorage.auth = data.auth === null ? undefined : data.auth;
    AppStorage.user = data.user;
}

function logout()
{
    AppStorage.auth = null;
    AppStorage.user = null;
    document.cookie = 'token; expires=-1'
}
