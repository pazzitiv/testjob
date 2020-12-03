const Cookie = {
    cookie: {},

    parseCookie: (cookie) => {
        cookie = cookie.split(', ');
        let result = {};
        for (let i = 0; i < cookie.length; i++) {
            let cur = cookie[i].split('=');
            result[cur[0]] = cur[1];
        }
        Cookie.cookie = result;
        return Cookie;
    },

    setCookie: (key, value) => {
        Cookie.cookie[key] = value;
        return Cookie
    },

    getCookie: () => {
        let cook = Cookie.cookie;
        let result = [];
        for(let key in cook) {
            let value = cook[key];
            result.push(`${key}=${value}`)
        }
        return result.join('; ')
    }
}

const InitialStorage = Object.assign(JSON.parse(localStorage.getItem('storage')) ?? {
    auth: null,
    user: null,
}, {Cookie});

localStorage.setItem('storage', JSON.stringify(InitialStorage));

window.AppStorage = new Proxy(
    InitialStorage,
    {
        set: (target, prop, value, receiver) => {
            target[prop] = value;
            localStorage.setItem('storage', JSON.stringify(receiver));
        },
        deleteProperty(target, p) {
            if(!target.hasOwnProperty(p)) return false;
            delete (target[p])
            return true;
        }
    }
)
