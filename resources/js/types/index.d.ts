export interface User {
    id: number
    name: string
    email?: string
}

export interface Participant extends User {
    user_id: number
}

export interface Message {
    id: number
    message: string
    timestamp: string
    user?: User
    user_id: number
}

export interface Chat {
    id: number
    name: string
    participant_count: number
    participants: Array<Participant>
    messages?: Array<Message>
    latestMessage?: Message
}

export interface ConversationProps {
    chat: Chat
    selected: boolean
}
