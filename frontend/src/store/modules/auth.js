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
            // if (!data.token) {
            //     // If token is not found in response data, remove existing token from local storage if any
            //     localStorage.removeItem('token');

            //     // Update Vuex store to reflect logged out state
            //     commit('setLoggedIn', false);
            //     commit('setToken', '2222222222222222');

            //     throw new Error('Token not found in response');
            // }
            const token = data.token;


            // Set token in local storage

            // Update Vuex store
            commit('setLoggedIn', true);
            commit('setToken', token);
            localStorage.setItem('token', token);


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
