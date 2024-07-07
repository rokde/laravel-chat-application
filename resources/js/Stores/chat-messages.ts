import {reactive} from 'vue';

export const chatMessages = reactive({
    messages: {},

    addMessage(target: string, message: any): void {
        this._initializeTargetArray(target);

        this.messages[target].push(message);
    },

    prependMessage(target: string, message: any): void {
        this._initializeTargetArray(target);

        this.messages[target].unshift(message);
    },

    setMessages(target: string, messages: []): void {
        this._initializeTargetArray(target);

        this.messages[target] = messages;
    },

    // messages(target: string): [] {
    //     this._initializeTargetArray();
    //
    //     return this._messages[target];
    // },

    _initializeTargetArray(target: string): void {
        if (!this.messages.hasOwnProperty(target)) {
            this.messages[target] = reactive([]);
        }
    }
});
