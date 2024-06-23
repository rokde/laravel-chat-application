import {reactive} from 'vue';

export const usersOnline = reactive({
    users: {},

    /**
     * adds a user
     * @param {{id: number, name: string, email: string}} user
     */
    addUser(user) {
        this.users[user.id] = user;
    },

    /**
     * delete a user
     * @param {{id: number}} user
     */
    deleteUser(user) {
        delete this.users[user.id];
    },

    /**
     * @param {string|number} id
     * @returns {boolean}
     */
    isOnline(id) {
        return this.users.hasOwnProperty(id);
    }
});
