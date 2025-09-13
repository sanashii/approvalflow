declare global {
    function route(name: string, params?: any, absolute?: boolean): string;
    
    interface Window {
        axios: any;
    }
    
    interface InertiaPageProps {
        auth: {
            user: {
                id: number;
                name: string;
                email: string;
                email_verified_at: string | null;
            };
        };
    }
}

export {};