const state = {
    isLoggedIn: false,
    token: null
};

const mutations = {

    setLoggedIn(state, isLoggedIn) {
        state.isLoggedIn = isLoggedIn;
    },
    setToken(state, token) {
        state.token = token;
    }
};

const actions = {
    async login({ commit }, { username, password }) {
        try {
            const response = await fetch('http://localhost:9000/api/login_check', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ username, password })
            });
            const data = await response.json();
            const token = data.token;

            // Set token in local storage
            localStorage.setItem('token', token);

            // Update Vuex store
            commit('setLoggedIn', true);
            commit('setToken', token);

            return true; // Login successful
        } catch (error) {
            console.error('Login error:', error);
            return false; // Login failed
        }
    },
    logout({ commit }) {
        // Clear token from local storage
        localStorage.removeItem('token');

        // Update Vuex store
        commit('setLoggedIn', false);
        commit('setToken', null);
    }
};

const getters = {
    isLoggedIn: state => state.isLoggedIn,
    token: state => state.token
};

export default {
    state,
    mutations,
    actions,
    getters
};
