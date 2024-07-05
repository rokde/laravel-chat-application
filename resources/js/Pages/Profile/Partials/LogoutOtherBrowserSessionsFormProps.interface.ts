export interface Session {
    agent: {
        is_desktop: boolean;
        platform?: string;
        browser?: string;
    };
    ip_address: string;
    is_current_device: boolean;
    last_active: string;
}

export interface LogoutOtherBrowserSessionsFormProps {
    sessions: Session[];
}
