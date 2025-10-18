import { useEffect, useRef } from 'react';

declare global {
    interface Window {
        turnstile?: {
            render: (
                container: HTMLElement,
                options?: Record<string, unknown>
            ) => string;
            remove: (widgetId?: string) => void;
        };
    }
}

const SITE_KEY = '0x4AAAAAAB7UrPyi6g0W9ZZf';

export default function TurnstileWidget() {
    const containerRef = useRef<HTMLDivElement | null>(null);

    useEffect(() => {
        let widgetId: string | undefined;
        let intervalId: number | undefined;
        let cancelled = false;

        const renderWidget = () => {
            if (
                cancelled ||
                !containerRef.current ||
                !window.turnstile ||
                containerRef.current.childNodes.length > 0
            ) {
                return;
            }

            widgetId = window.turnstile.render(containerRef.current, {
                sitekey: SITE_KEY,
            });
        };

        if (window.turnstile) {
            renderWidget();
        } else {
            intervalId = window.setInterval(() => {
                if (window.turnstile) {
                    clearInterval(intervalId);
                    renderWidget();
                }
            }, 200);
        }

        return () => {
            cancelled = true;
            if (typeof intervalId !== 'undefined') {
                clearInterval(intervalId);
            }

            if (widgetId && window.turnstile) {
                window.turnstile.remove(widgetId);
            } else if (containerRef.current) {
                containerRef.current.innerHTML = '';
            }
        };
    }, []);

    return <div ref={containerRef} className="cf-turnstile" />;
}
